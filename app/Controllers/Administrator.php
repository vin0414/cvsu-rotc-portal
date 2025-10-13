<?php

namespace App\Controllers;
use App\Libraries\Hash;

class Administrator extends BaseController
{
    private $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['url', 'form']);
    }

    public function auth()
    {
        return view('auth/login',['validation' => \Config\Services::validation()]);
    }

    public function checkAuth()
    {
        $validation = $this->validate([
            'employee_id' => [
                'rules' => 'required|is_not_unique[accounts.employee_id]',
                'errors' => [
                    'required' => 'Employee ID is required',
                    'is_not_unique' => 'Employee ID does not exist'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[20]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 8 characters long',
                    'max_length' => 'Password cannot exceed 20 characters',
                    'regex_match' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character'
                ]
            ]
        ]);
        if(!$validation)
        {
            return view('auth/login', [
                'validation' => $this->validator
            ]); 
        }
        else
        {
            $accountModel = new \App\Models\accountModel();
            $account = $accountModel->where('employee_id', $this->request->getPost('employee_id'))
                                    ->where('status', 1)
                                    ->first();
            if($account)
            {
                if(Hash::check($this->request->getPost('password'), $account['password']))
                {
                    session()->set('loggedAdmin', $account['account_id']);
                    session()->set('fullname', $account['fullname']);
                    session()->set('role', $account['role_id']);
                    //logs
                    date_default_timezone_set('Asia/Manila');
                    $logModel = new \App\Models\logModel();
                    $data = ['account_id'=>$account['account_id'],
                            'activities'=>'Logged On',
                            'page'=>'Login page',
                            'datetime'=>date('Y-m-d h:i:s a')
                            ];      
                    $logModel->save($data);
                    return redirect()->to('/dashboard');
                }
                else
                {
                    return redirect()->to('/auth')->with('fail', 'Incorrect password!');
                }
            }
            else
            {
                return redirect()->to('/auth')->with('fail', 'Account is inactive!');
            }
        }
    }

    public function logout()
    {
        //logs
        date_default_timezone_set('Asia/Manila');
        $logModel = new \App\Models\logModel();
        $data = ['account_id'=>session()->get('loggedAdmin'),
                'activities'=>'Logged Out',
                'page'=>'Login page',
                'datetime'=>date('Y-m-d h:i:s a')
                ];      
        $logModel->save($data);
        if(session()->has('loggedAdmin'))
        {
            session()->remove('loggedAdmin');
            session()->destroy();
            return redirect()->to('/auth?access=out')->with('fail', 'You are logged out!');
        }
    }

    public function resetPassword()
    {
        return view('auth/forgot-password',['validation' => \Config\Services::validation()]);
    }

    public function index()
    {
        $title = 'Overview';
        $data = ['title'=>$title];
        return view('admin/dashboard',$data);
    }

    public function cadetInformation()
    {
        $title = 'Cadets';
        //students
        $studentModel = new \App\Models\studentModel();
        $students = $studentModel->WHERE('status',1)->findAll();

        $data = ['title'=>$title,'students'=>$students];
        return view('admin/cadet-information',$data);
    }

    public function trainingSchedule()
    {
        $title = 'Training Schedule';
        $data = ['title'=>$title];
        return view('admin/training-schedule',$data);
    }

    public function attendance()
    {
        $title = 'Attendance';
        $data = ['title'=>$title];
        return view('admin/attendance',$data);
    }

    public function announcement()
    {
        $title = 'Announcement';
        $data = ['title'=>$title];
        return view('admin/announcement',$data);
    }

    public function accounts()
    {
        $title = 'Accounts';
        $data = ['title'=>$title];
        return view('admin/maintenance/accounts/manage-user',$data);
    }

    public function createAccount()
    {
        $title = 'Create Account';
        $data = ['title'=>$title];
        return view('admin/maintenance/accounts/create-account',$data);
    }

    public function register()
    {
        $title = "Register";
        $data = ['title'=>$title];
        return view('admin/register-cadet',$data);
    }

    public function recovery()
    {
        $title = 'Back-up and Recovery';
        $data = ['title'=>$title];
        return view('admin/maintenance/others/recovery',$data);
    }

    public function fetchPermission()
    {
        $roleModel = new \App\Models\roleModel();
        $roles = $roleModel->findAll();
        $totalRecords = $roleModel->countAllResults();
        $response = [
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $roles
        ];
        return $this->response->setJSON($response);
    }

    public function settings()
    {
        $title = 'Settings';
        //logs
        $builder = $this->db->table('logs a');
        $builder->select('a.*,b.fullname');
        $builder->join('accounts b','b.account_id=a.account_id','LEFT');
        $logs = $builder->get()->getResult();

        $data = ['title'=>$title,'logs'=>$logs];
        return view('admin/maintenance/others/settings',$data);
    }

    public function myAccount()
    {
        $title = 'My Account';
        $data = ['title'=>$title];
        return view('admin/account',$data);
    }


    //ajax
    public function fetchAccount()
    {
        $searchTerm = $_GET['search']['value'] ?? ''; 
        $builder = $this->db->table('accounts a');
        $builder->select('a.*,b.role_name as role'); 
        $builder->join('roles b','b.role_id=a.role_id','LEFT');
        if(!empty($searchTerm))
        {
            $builder->like('a.fullname', $searchTerm);
            $builder->orLike('a.employee_id', $searchTerm);
            $builder->orLike('a.email', $searchTerm);
            $builder->orLike('b.role', $searchTerm);
        }
        $query = $builder->get();
        $data = $query->getResult();
        $totalRecords = $query->getNumRows();
        $response = [
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data
        ];
        return $this->response->setJSON($response);
    }

    public function saveAccount()
    {
        $accountModel = new \App\Models\accountModel();
        $validation = $this->validate([
            'fullname' => [
                'rules' => 'required|is_not_unique[accounts.fullname]',
                'errors' => [
                    'required' => 'Fullname is required',
                    'is_not_unique' => 'Fullname already exists'
                ]
            ],
            'employee_id' => [
                'rules' => 'required|is_not_unique[accounts.employee_id]',
                'errors' => [
                    'required' => 'Employee ID is required',
                    'is_not_unique' => 'Employee ID already exists'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[accounts.email]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Email is not valid',
                    'is_not_unique' => 'Email already exists'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[20]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 8 characters long',
                    'max_length' => 'Password cannot exceed 20 characters',
                    'regex_match' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character'
                ]
            ]
        ]);
        if(!$validation)
        {
            return $this->response->SetJSON(['error' => $this->validator->getErrors()]);
        }
        else
        {
            $data = [
                "employee_id"  =>$this->request->getPost('employee_id'),
                "password"     =>Hash::make($this->request->getPost('password')),
                "fullname"     =>$this->request->getPost('fullname'),
                "email"        =>$this->request->getPost('email'),  
                "role"         =>$this->request->getPost('role'),
                "status"       =>1,
                "token"        =>md5(uniqid(rand(), true)),
                "date_created" =>date('Y-m-d h:i:s a')
            ];
            $accountModel->save($data);
            //logs  
            date_default_timezone_set('Asia/Manila');
            $logModel = new \App\Models\logModel();
            $data = ['account_id'=>session()->get('loggedAdmin'),
                    'activities'=>'Created Account',
                    'page'=>'Create Account page',
                    'datetime'=>date('Y-m-d h:i:s a')
                    ];      
            $logModel->save($data);
            return $this->response->setJSON(['success' => 'Account created successfully!']);
        }
    }
}