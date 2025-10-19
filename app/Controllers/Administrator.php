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

    //validate the permission
    public function hasPermission($page)
    {
        $roleModel = new \App\Models\roleModel();
        $accountModel = new \App\Models\accountModel();
        $account = $accountModel->WHERE('account_id',session()->get('loggedAdmin'))->first();
        $role = $roleModel->WHERE('role_id',$account['role_id'])->first();
        if($role[$page] != 1)
        {
            //no access
            return false;
        }
        else
        {
            return true;
        }
    }

    public function index()
    {
        $title = 'Overview';
        //announcement
        $announcementModel = new \App\Models\announcementModel();
        $announcement = $announcementModel->orderBy('announcement_id','DESC')->limit(5)->findAll();
        //enrolment chart
        $builder = $this->db->table('students');
        $builder->select('date_created,COUNT(student_id)total');
        $builder->where('is_enroll',1);
        $builder->groupBy('date_created');
        $enrol = $builder->get()->getResult();

        $data = ['title'=>$title,'announcement'=>$announcement,'enrol'=>$enrol];
        return view('admin/dashboard',$data);
    }

    public function cadetInformation()
    {
        if(!$this->hasPermission('cadet'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $title = 'Cadets';
            $data['title'] = $title;
            return view('admin/cadets/cadet-list',$data);
        }
    }

    public function trainingSchedule()
    {
        if(!$this->hasPermission('schedule'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $title = 'Schedules';
            $data = ['title'=>$title];
            return view('admin/schedules/all-schedules',$data);
        }
    }

    public function attendance()
    {
        if(!$this->hasPermission('attendance'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $title = 'Attendance';
            $data = ['title'=>$title];
            return view('admin/attendance/all-attendance',$data);
        }
    }

    public function gradingSystem()
    {
        if(!$this->hasPermission('grading_system'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $title = 'Gradebook';
            $data = ['title'=>$title];
            return view('admin/grades/index',$data);
        }
    }

    public function announcement()
    {
        if(!$this->hasPermission('announcement'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $data['title']='Announcement';
            $val = $this->request->getGet('search');
            $announcement = new \App\Models\announcementModel();
            $page = (int) ($this->request->getGet('page') ?? 1);
            $perPage = 6;

            // Build query
            if ($val) {
                if ($val) $announcement->like('title', $val);
            }

            $announcement->orderBy('announcement_id', 'DESC');
            $list = $announcement->paginate($perPage, 'default', $page);
            $total = $announcement->countAllResults();       
            $pager = $announcement->pager;
            $data['list']=$list;
            $data['page']=$page;
            $data['perPage']=$perPage;
            $data['total']=$total;
            $data['pager']=$pager;
            return view('admin/announcement/index',$data);
        }
    }

    public function createAnnouncement()
    {
        if(!$this->hasPermission('announcement'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $title = 'New Announcement';
            $data = ['title'=>$title];
            return view('admin/announcement/create',$data);
        }
    }

    public function saveAnnouncement()
    {
        // Get raw HTML from Quill editor
        $rawDetails = $this->request->getPost('details');

        // Sanitize: remove whitespace and check for empty Quill output
        $cleanDetails = trim($rawDetails);

        $validation = $this->validate([
            'title'=>[
                'rules'=>'required|is_unique[announcement.title]',
                'errors'=>[
                    'required'=>'Title is required',
                    'is_unique'=>'Title already exist. Please try again'
                ]
            ],
            'details'=>['rules'=>'required','errors'=>['required'=>'Details is required']],
            'file' => [
                'rules' => 'uploaded[file]|mime_in[file,image/jpg,image/jpeg,image/png]|max_size[file,10240]',
                'errors' => [
                    'uploaded' => 'Please upload a file before submitting.',
                    'mime_in' => 'Only JPG, JPEG, and PNG image formats are allowed.',
                    'max_size' => 'The file size must not exceed 10MB.',
                ]
            ],
        ]);

        if(!$validation)
        {
            return $this->response->setJSON(['errors'=>$this->validator->getErrors()]);
        }
        else
        {
            if ($cleanDetails === '<p><br></p>' || $cleanDetails === '') 
            {
                $error = ['details'=>'Details is required'];
                return $this->response->setJSON(['errors'=>$error]);
            }
            else
            {
                $file = $this->request->getFile('file');
                if ($file && $file->isValid() && !$file->hasMoved()) 
                {
                    $extension = $file->getExtension();
                    $originalname  = pathinfo($file->getClientName(), PATHINFO_FILENAME);
                    $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalname);
                    $newName = date('YmdHis') . '_' . $safeName . '.' . $extension;
                    //create folder
                    $folderName = "assets/images/announcement";
                    if (!is_dir($folderName)) {
                        mkdir($folderName, 0755, true);
                    }
                    $file->move($folderName.'/',$newName);
                    $announcementModel = new \App\Models\announcementModel();
                    //save to the database
                    $data = [
                            'title'=>$this->request->getPost('title'),
                            'details'=>$this->request->getPost('details'),
                            'image'=>$newName,
                            'account_id'=>session()->get('loggedAdmin'),
                            ];
                    $announcementModel->save($data);
                    return $this->response->setJSON(['success'=>'Successfully uploaded']);
                }
                else
                {
                    $errors = ['file'=>'File upload failed or no file selected.'];
                    return $this->response->setJSON(['errors'=>$errors]);
                }
            }
        }
    }

    public function modifyAnnouncement()
    {
        // Get raw HTML from Quill editor
        $rawDetails = $this->request->getPost('details');

        // Sanitize: remove whitespace and check for empty Quill output
        $cleanDetails = trim($rawDetails);

        $validation = $this->validate([
            'id'=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'Announcement ID is required',
                    'numeric'=>'Invalid ID'
                ]
            ],
            'title'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Title is required',
                ]
            ],
            'details'=>['rules'=>'required','errors'=>['required'=>'Details is required']],
        ]);

        if(!$validation)
        {
            return $this->response->setJSON(['errors'=>$this->validator->getErrors()]);
        }
        else
        {
            if ($cleanDetails === '<p><br></p>' || $cleanDetails === '') 
            {
                $error = ['details'=>'Details is required'];
                return $this->response->setJSON(['errors'=>$error]);
            }
            else
            {
                $file = $this->request->getFile('file');
                $originalname  = pathinfo($file->getClientName(), PATHINFO_FILENAME);
                if(empty($originalname))
                {
                    $announcementModel = new \App\Models\announcementModel();
                    //save to the database
                    $data = [
                            'title'=>$this->request->getPost('title'),
                            'details'=>$this->request->getPost('details'),
                            ];
                    $announcementModel->update($this->request->getPost('id'),$data);
                    return $this->response->setJSON(['success'=>'Successfully applied changes']);
                }
                else
                {
                    if ($file && $file->isValid() && !$file->hasMoved()) 
                    {
                        $extension = $file->getExtension();
                        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalname);
                        $newName = date('YmdHis') . '_' . $safeName . '.' . $extension;
                        //create folder
                        $folderName = "assets/images/announcement";
                        if (!is_dir($folderName)) {
                            mkdir($folderName, 0755, true);
                        }
                        $file->move($folderName.'/',$newName);
                        $announcementModel = new \App\Models\announcementModel();
                        //save to the database
                        $data = [
                                'title'=>$this->request->getPost('title'),
                                'details'=>$this->request->getPost('details'),
                                'image'=>$newName,
                                ];
                        $announcementModel->update($this->request->getPost('id'),$data);
                        return $this->response->setJSON(['success'=>'Successfully applied changes']);
                    }
                    else
                    {
                        $errors = ['file'=>'File upload failed or no file selected.'];
                        return $this->response->setJSON(['errors'=>$errors]);
                    }
                }
            }
        }
    }

    public function editAnnouncement($id)
    {
        if(!$this->hasPermission('announcement'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $title = 'Edit Announcement';
            $data = ['title'=>$title];
            $announcementModel = new \App\Models\announcementModel();
            $data['announcement'] = $announcementModel->where('announcement_id',$id)->first();
            return view('admin/announcement/edit',$data);
        }
    }

    public function report()
    {
        $title = 'Reports';
        $data = ['title'=>$title];
        return view('admin/reports/index',$data);
    }

    public function accounts()
    {
        if(!$this->hasPermission('maintenance'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $title = 'Accounts';
            $data = ['title'=>$title];
            return view('admin/maintenance/accounts/manage-user',$data);
        }
    }

    public function createAccount()
    {
        if(!$this->hasPermission('maintenance'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $title = 'Create Account';
            $roleModel = new \App\Models\roleModel();
            $role = $roleModel->findAll();
            $data = ['title'=>$title,'role'=>$role];
            return view('admin/maintenance/accounts/create-account',$data);
        }
    }

    public function editAccount($id)
    {
        if(!$this->hasPermission('maintenance'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $title = 'Edit Account';
            $roleModel = new \App\Models\roleModel();
            $role = $roleModel->findAll();
            //account
            $accountModel = new \App\Models\accountModel();
            $account = $accountModel->where('account_id',$id)->first();
            $data = ['title'=>$title,'role'=>$role,'account'=>$account];
            return view('admin/maintenance/accounts/edit-account',$data);
        }
    }

    public function recovery()
    {
        if(!$this->hasPermission('maintenance'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $title = 'Back-up and Recovery';
            $data = ['title'=>$title];
            return view('admin/maintenance/others/recovery',$data);
        }
    }

    public function fetchPermission()
    {
        $searchTerm = $_GET['search']['value'] ?? '';
        $permissionModel = new \App\Models\roleModel();
        // Apply the search filter for the main query
        if ($searchTerm) {
            $permissionModel->like('role_name', $searchTerm);   
        }
        // Pagination: Get the 'start' and 'length' from the request (these are sent by DataTables)
        $limit = $_GET['length'] ?? 10;  // Number of records per page, default is 10
        $offset = $_GET['start'] ?? 0;   // Starting record for pagination, default is 0
        // Clone the model for counting filtered records, while keeping the original for data fetching
        $filteredPermissionModel = clone $permissionModel;
        if ($searchTerm) {
            $filteredPermissionModel->like('role_name', $searchTerm);
        }
        // Fetch filtered records based on limit and offset
        $permissions = $permissionModel->findAll($limit, $offset);  
        // Count total records (without filter)
        $totalRecords = $permissionModel->countAllResults();
        // Count filtered records (with filter)
        $filteredRecords = $filteredPermissionModel->countAllResults();
        $response = [
            "draw" => $_GET['draw'],
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            'data' => [] 
        ];
        foreach ($permissions as $row) {
            $response['data'][] = [
                'role_name' => htmlspecialchars($row['role_name'], ENT_QUOTES),
                'cadet' => ($row['cadet']==1) ? '<i class="ti ti-check"></i>&nbsp;Active' : '<i class="ti ti-x"></i>&nbsp;Inactive',
                'schedule' => ($row['schedule']==1) ? '<i class="ti ti-check"></i>&nbsp;Active' : '<i class="ti ti-x"></i>&nbsp;Inactive',
                'attendance' => ($row['attendance']==1) ? '<i class="ti ti-check"></i>&nbsp;Active' : '<i class="ti ti-x"></i>&nbsp;Inactive',
                'grading_system' => ($row['grading_system']==1) ? '<i class="ti ti-check"></i>&nbsp;Active' : '<i class="ti ti-x"></i>&nbsp;Inactive',       
                'announcement' => ($row['announcement']==1) ? '<i class="ti ti-check"></i>&nbsp;Active' : '<i class="ti ti-x"></i>&nbsp;Inactive',
                'maintenance' => ($row['maintenance']==1) ? '<i class="ti ti-check"></i>&nbsp;Active' : '<i class="ti ti-x"></i>&nbsp;Inactive',
                'action' => '<a class="btn btn-primary edit_permission" href="/maintenance/permission/edit/' . $row['role_id'] . '"><i class="ti ti-edit"></i> Edit </a>'
            ];
        }
        return $this->response->setJSON($response);
        
    }

    public function savePermission()
    {
        $validation = $this->validate([
            'role'=>['rules'=>'required|is_unique[roles.role_name]','errors'=>['required'=>'Role is required.','is_unique'=>'Role already exist. Please try again']],
            'cadet'=>['rules'=>'required','errors'=>['required'=>'Cadet Module is required']],
            'schedule'=>['rules'=>'required','errors'=>['required'=>'Schedule Module is required']],
            'attendance'=>['rules'=>'required','errors'=>['required'=>'Attendance Module is required']],
            'grade'=>['rules'=>'required','errors'=>['required'=>'Evaluation Module is required']],
            'announcement'=>['rules'=>'required','errors'=>['required'=>'Announcement Module is required']],
            'maintenance'=>['rules'=>'required','errors'=>['required'=>'Maintenance Module is required']],
        ]);

        if(!$validation)
        {
            return $this->response->setJSON(['errors'=>$this->validator->getErrors()]);
        }
        else
        {
            $roleModel = new \App\Models\roleModel();
            $data = [
                    'role_name'=>$this->request->getPost('role'),
                    'cadet'=>$this->request->getPost('cadet'),
                    'schedule'=>$this->request->getPost('schedule'),
                    'attendance'=>$this->request->getPost('attendance'),
                    'grading_system'=>$this->request->getPost('grade'),
                    'announcement'=>$this->request->getPost('announcement'),
                    'maintenance'=>$this->request->getPost('maintenance')
                ];
            $roleModel->save($data);
            //logs  
            date_default_timezone_set('Asia/Manila');
            $logModel = new \App\Models\logModel();
            $data = ['account_id'=>session()->get('loggedAdmin'),
                    'activities'=>'Created new permission',
                    'page'=>'Settings page',
                    'datetime'=>date('Y-m-d h:i:s a')
                    ];      
            $logModel->save($data);
            return $this->response->setJSON(['success'=>'Successfully added']);
        }
    }

    public function modifyPermission()
    {
        $validation = $this->validate([
            'id'=>['rules'=>'required','errors'=>['Role ID is required']],
            'role'=>['rules'=>'required','errors'=>['required'=>'Role is required.']],
            'cadet'=>['rules'=>'required','errors'=>['required'=>'Cadet Module is required']],
            'schedule'=>['rules'=>'required','errors'=>['required'=>'Schedule Module is required']],
            'attendance'=>['rules'=>'required','errors'=>['required'=>'Attendance Module is required']],
            'grade'=>['rules'=>'required','errors'=>['required'=>'Evaluation Module is required']],
            'announcement'=>['rules'=>'required','errors'=>['required'=>'Announcement Module is required']],
            'maintenance'=>['rules'=>'required','errors'=>['required'=>'Maintenance Module is required']],
        ]);

        if(!$validation)
        {
            return $this->response->setJSON(['errors'=>$this->validator->getErrors()]);
        }
        else
        {
            $roleModel = new \App\Models\roleModel();
            $data = [
                    'role_name'=>$this->request->getPost('role'),
                    'cadet'=>$this->request->getPost('cadet'),
                    'schedule'=>$this->request->getPost('schedule'),
                    'attendance'=>$this->request->getPost('attendance'),
                    'grading_system'=>$this->request->getPost('grade'),
                    'announcement'=>$this->request->getPost('announcement'),
                    'maintenance'=>$this->request->getPost('maintenance')
                ];
            $roleModel->update($this->request->getPost('id'),$data);
            //logs  
            date_default_timezone_set('Asia/Manila');
            $logModel = new \App\Models\logModel();
            $data = ['account_id'=>session()->get('loggedAdmin'),
                    'activities'=>'Modify permission',
                    'page'=>'Settings page',
                    'datetime'=>date('Y-m-d h:i:s a')
                    ];      
            $logModel->save($data);
            return $this->response->setJSON(['success'=>'Successfully saved changes']);
        }
    }

    public function settings()
    {
        if(!$this->hasPermission('maintenance'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
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
    }

    public function createPermission()
    {
        if(!$this->hasPermission('maintenance'))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $data['title'] = 'Create Permission';
            return view('admin/maintenance/others/add-permission',$data);
        }
    }

    public function editPermission($id)
    {
        if(!$this->hasPermission('maintenance') || !is_numeric($id))
        {
            return redirect()->to('/dashboard')->with('fail', 'You do not have permission to access that page!');
        }
        else
        {
            $data['title'] = 'Edit Permission';
            $permission = (new \App\Models\roleModel())->WHERE('role_id',$id)->first();
            if(!$permission)
            {
                return redirect()->to('/maintenance/settings')->with('fail', 'Permission not found!');
            }
            $data['permission'] = $permission;
            return view('admin/maintenance/others/edit-permission',$data);
        }
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
            'role'=>[
                'rules'=>'required',
                'errors'=>['Role is required']
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
                "role_id"         =>$this->request->getPost('role'),
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

    public function modifyAccount()
    {
        $accountModel = new \App\Models\accountModel();
        $validation = $this->validate([
            'id'=>[
                'rules'=>'required|numeric',
                'errors'=>[
                    'required'=>'Account ID is required',
                    'numeric'=>'Account ID is numeric'
                ]
            ],
            'fullname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Fullname is required',
                ]
            ],
            'employee_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Employee ID is required',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Email is not valid',
                ]
            ],
            'role'=>[
                'rules'=>'required',
                'errors'=>['Role is required']
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
                "role_id"         =>$this->request->getPost('role'),
                "status"       =>$this->request->getPost('status'),
            ];
            $accountModel->update($this->request->getPost('id'),$data);
            //logs  
            date_default_timezone_set('Asia/Manila');
            $logModel = new \App\Models\logModel();
            $data = ['account_id'=>session()->get('loggedAdmin'),
                    'activities'=>'Modify Account',
                    'page'=>'Create Account page',
                    'datetime'=>date('Y-m-d h:i:s a')
                    ];      
            $logModel->save($data);
            return $this->response->setJSON(['success' => 'Account modified successfully!']);
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