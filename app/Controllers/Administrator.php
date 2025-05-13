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
                    session()->set('role', $account['role']);
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
        return view('admin/manage-user',$data);
    }

    public function createAccount()
    {
        $title = 'Create Account';
        $data = ['title'=>$title];
        return view('admin/create-account',$data);
    }

    public function register()
    {
        $title = "Register";
        //recent cadets
        $cadetModel = new \App\Models\cadetModel();
        $cadet = $cadetModel->orderBy('cadet_id','DESC')->limit(5)->findAll();

        $data = ['title'=>$title,'cadet'=>$cadet];
        return view('admin/register-cadet',$data);
    }

    public function recovery()
    {
        $title = 'Back-up and Recovery';
        $data = ['title'=>$title];
        return view('admin/recovery',$data);
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
        return view('admin/settings',$data);
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
        $accountModel = new \App\Models\accountModel();
        $searchTerm = $_GET['search']['value'] ?? ''; 
        if ($searchTerm) {
            $accountModel->like('fullname', $searchTerm)
                ->orLike('employee_id', $searchTerm)
                ->orLike('email', $searchTerm); 
        }
        $account = $accountModel->findAll();
        $totalRecords = $accountModel->countAllResults();

        $accountModel->like('fullname', $searchTerm)
                ->orLike('employee_id', $searchTerm)
                ->orLike('email', $searchTerm); 
        $totalFiltered = $accountModel->countAllResults();

        $response = [
            "draw" => $_GET['draw'],
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFiltered,
            'data' => [] 
        ];
        foreach ($account as $row) {
            $response['data'][] = [
                'id'=>$row['employee_id'],
                'fullname'=>$row['fullname'],
                'email'=>$row['email'],
                'role'=>$row['role'],
                'status'=>($row['status'] == 1) ? '<span class="badge bg-success text-white">Active</span>' : '<span class="badge bg-danger text-white">Inactive</span>', 
                'action' => '<button class="btn btn-success editAccount" value="' . $row['account_id'] . '"><i class="ti ti-edit"></i>&nbsp;Edit</button>'
            ];
        }
        // Return the response as JSON
        return $this->response->setJSON($response);
    }

    public function saveAccount()
    {
        $accountModel = new \App\Models\accountModel();
        $validation = $this->validate([
            'fullname' => [
                'rules' => 'required|is_unique[accounts.fullname]',
                'errors' => [
                    'required' => 'Fullname is required',
                    'is_unique' => 'Fullname already exists'
                ]
            ],
            'employee_id' => [
                'rules' => 'required|is_unique[accounts.employee_id]',
                'errors' => [
                    'required' => 'Employee ID is required',
                    'is_unique' => 'Employee ID already exists'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[accounts.email]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Email is not valid',
                    'is_unique' => 'Email already exists'
                ]
            ],
        ]);
        if(!$validation)
        {
            return $this->response->SetJSON(['error' => $this->validator->getErrors()]);
        }
        else
        {
            $data = [
                "employee_id"  =>$this->request->getPost('employee_id'),
                "password"     =>Hash::make('Abc12345?'),
                "fullname"     =>$this->request->getPost('fullname'),
                "email"        =>$this->request->getPost('email'),  
                "role"         =>$this->request->getPost('role'),
                "status"       =>$this->request->getPost('status'),
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

    public function saveCadet()
    {
        $studentModel = new \App\Models\studentModel();
        $cadetModel = new \App\Models\cadetModel();
        $validation = $this->validate([
            'lastname' => 'required|min_length[2]|max_length[100]',
            'firstname' => 'required|min_length[2]|max_length[100]',
            'student_no' => 'required|min_length[8]|max_length[15]|is_unique[students.school_id]',
            'house_no' => 'required|max_length[50]',
            'street' => 'required|max_length[100]',
            'village' => 'required|max_length[100]',
            'municipality' => 'required|max_length[100]',
            'province' => 'required|max_length[100]',
            'course' => 'required|max_length[100]',
            'year_level' => 'required',
            'section' => 'required|max_length[50]',
            'birth_date' => 'required|valid_date',
            'height' => 'required|decimal',
            'weight' => 'required|decimal',
            'blood_type' => 'required|max_length[5]',
            'gender' => 'required|in_list[Male,Female]',
            'religion' => 'required|max_length[100]',
            'contact_no' => 'required|numeric|min_length[10]|max_length[15]',
            'fb_account' => 'required|valid_url|max_length[150]',
            'email' => 'required|valid_email|max_length[150]',
            'emergency_contact' => 'required|max_length[150]',
            'emergency_house_no' => 'required|max_length[50]',
            'emergency_street' => 'required|max_length[100]',
            'emergency_village' => 'required|max_length[100]',
            'emergency_municipality' => 'required|max_length[100]',
            'emergency_province' => 'required|max_length[100]',
            'relationship' => 'required|max_length[50]',
            'emergency_contact_no' => 'required|numeric|min_length[10]|max_length[15]',
            'emergency_email' => 'required|valid_email|max_length[150]',
        ]);

        if(!$validation)
        {
            return $this->response->SetJSON(['error' => $this->validator->getErrors()]);
        }
        else
        {
            if(empty($this->request->getPost('mother_sname'))||
                empty($this->request->getPost('father_sname'))||
                empty($this->request->getPost('mother_fname'))||
                empty($this->request->getPost('father_sname')))
            {
                $error = ['parents'=>"Please enter your parent's information"];
                return $this->response->SetJSON(['error' => $error]);
            }
            else
            {
                $token = bin2hex(random_bytes(32));
                $data =  ['school_id'=>$this->request->getPost('student_no'),
                        'password'=>Hash::make('Abc12345?'),
                        'first_name'=>$this->request->getPost('firstname'),
                        'middle_name'=>$this->request->getPost('middlename'),
                        'surname'=>$this->request->getPost('lastname'),
                        'suffix'=>$this->request->getPost('suffix'),
                        'email'=>$this->request->getPost('email'),
                        'status'=>1,
                        'is_enroll'=>1,
                        'photo'=>'',
                        'token'=>$token,
                        'date_created'=>date('Y-m-d H:i:s a')
                        ];
                $studentModel->save($data);
                //get the student ID
                $student = $studentModel->WHERE('school_id',$this->request->getPost('student_no'))->first();
                //cadet information
                $record = ['student_id'=>$student['student_id'],
                            'school_id'=>$this->request->getPost('student_no'),
                            'first_name'=>$this->request->getPost('firstname'),
                            'middle_name'=>$this->request->getPost('middlename'),
                            'surname'=>$this->request->getPost('lastname'),
                            'suffix'=>$this->request->getPost('suffix'),
                            'house_no'=>$this->request->getPost('house_no'),
                            'street'=>$this->request->getPost('street'),
                            'village'=>$this->request->getPost('village'),
                            'municipality'=>$this->request->getPost('municipality'),
                            'province'=>$this->request->getPost('province'),
                            'course'=>$this->request->getPost('course'),
                            'year'=>$this->request->getPost('year_level'),
                            'section'=>$this->request->getPost('section'),
                            'school_attended'=>$this->request->getPost('last_school'),
                            'birthdate'=>$this->request->getPost('birth_date'),
                            'height'=>$this->request->getPost('height'),
                            'weight'=>$this->request->getPost('weight'),
                            'blood_type'=>$this->request->getPost('blood_type'),
                            'gender'=>$this->request->getPost('gender'),
                            'religion'=>$this->request->getPost('religion'),
                            'contact_no'=>$this->request->getPost('contact_no'),
                            'fb_account'=>$this->request->getPost('fb_account'),
                            'email'=>$this->request->getPost('email'),
                            'mother_sname'=>$this->request->getPost('mother_sname'),
                            'mother_fname'=>$this->request->getPost('mother_fname'),
                            'mother_mname'=>$this->request->getPost('mother_mname'),
                            'mother_contact'=>$this->request->getPost('mother_contact'),
                            'mother_work'=>$this->request->getPost('mother_work'),
                            'father_sname'=>$this->request->getPost('father_sname'),
                            'father_fname'=>$this->request->getPost('father_fname'),
                            'father_mname'=>$this->request->getPost('father_mname'),
                            'father_contact'=>$this->request->getPost('father_contact'),
                            'father_work'=>$this->request->getPost('father_work'),
                            'emergency_contact'=>$this->request->getPost('emergency_contact'),
                            'emergency_house_no'=>$this->request->getPost('emergency_house_no'),
                            'emergency_street'=>$this->request->getPost('emergency_street'),
                            'emergency_village'=>$this->request->getPost('emergency_village'),
                            'emergency_municipality'=>$this->request->getPost('emergency_municipality'),
                            'emergency_province'=>$this->request->getPost('emergency_province'),
                            'relationship'=>$this->request->getPost('relationship'),
                            'emergency_contact_no'=>$this->request->getPost('emergency_contact_no'),
                            'emergency_email'=>$this->request->getPost('emergency_email'),
                            'token'=>$token,
                            'date_created'=>date('Y-m-d')];
                $cadetModel->save($record);
                return $this->response->SetJSON(['success' => 'Successfully saved']);
            }
        }
    }
}