<?php

namespace App\Controllers;
use App\Libraries\Hash;
use Config\Email;
use \App\Models\cadetModel;

class Home extends BaseController
{
    private $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['url', 'form','text']);
    }

    public function signUp()
    {
        return view('sign-up',['validation' => \Config\Services::validation()]);
    }

    public function register()
    {
        $validation = $this->validate([
            'name'=>'required|is_unique[students.fullname]',
            'school_id'=>'required|is_unique[students.school_id]',
            'email'=>'required|valid_email|is_unique[students.email]',
            'password'=>'required|min_length[8]|max_length[16]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W]).+$/]',
            'confirm_password'=>'required|matches[password]',
            'agreement'=>'required'
        ]);
        if(!$validation)
        {
            return view('sign-up',['validation'=>$this->validator]);
        }
        else
        {
            $hash_password = Hash::make($this->request->getPost('password'));
            function generateRandomString($length = 64) {
                // Generate random bytes and convert them to hexadecimal
                $bytes = random_bytes($length);
                return substr(bin2hex($bytes), 0, $length);
            }
            $token_code = generateRandomString();
            //save
            $userModel = new \App\Models\studentModel();
            $data = [
                    'school_id'=>$this->request->getPost('school_id'), 
                    'password'=>$hash_password,
                    'fullname'=>$this->request->getPost('name'),
                    'email'=>$this->request->getPost('email'),
                    'status'=>0,
                    'is_enroll'=>0,
                    'photo'=>'',
                    'token'=>$token_code,
                    ];
            $userModel->save($data);
            //send email activation link
            $emailConfig = new Email();
            $fromEmail = $emailConfig->fromEmail;
            $fromName  = $emailConfig->fromName;
            $email = \Config\Services::email();
            $email->setTo($this->request->getPost('email'));
            $email->setFrom($fromEmail, $fromName); 
            $imgURL = "assets/images/logo.jpg";
            $email->attach($imgURL);
            $cid = $email->setAttachmentCID($imgURL);
            $template = "<center>
            <img src='cid:". $cid ."' width='100'/>
            <table style='padding:20px;background-color:#ffffff;' border='0'><tbody>
            <tr><td><center><h1>Account Activation</h1></center></td></tr>
            <tr><td><center>Hi, ".$this->request->getPost('name')."</center></td></tr>
            <tr><td><p><center>Please click the link below to activate your account.</center></p></td><tr>
            <tr><td><center><b>".anchor('activate/'.$token_code,'Activate Account')."</b></center></td></tr>
            <tr><td><p><center>If you did not sign-up in CVSU-CCC ROTC PORTAL,<br/> please ignore this message or contact us @ cvsu-ccc-rotc-portal@gmail.com</center></p></td></tr>
            <tr><td><center>IT Support</center></td></tr></tbody></table></center>";
            $subject = "Account Activation | CVSU-CCC ROTC PORTAL";
            $email->setSubject($subject);
            $email->setMessage($template);
            $email->send();
            session()->setFlashdata('success','Great! Successfully sent activation link');
            return redirect()->to('success/'.$token_code)->withInput();
        }
    }

    public function successLink($id)
    {
        $data = ['token'=>$id];
        return view('success',$data);
    }

    public function resend($id)
    {
        $userModel = new \App\Models\studentModel();
        $user = $userModel->WHERE('token',$id)->first();
        //send email activation link
        $emailConfig = new Email();
        $fromEmail = $emailConfig->fromEmail;
        $fromName  = $emailConfig->fromName;
        $email = \Config\Services::email();
        $email->setTo($user['email']);
        $email->setFrom($fromEmail, $fromName); 
        $imgURL = "assets/images/logo.jpg";
        $email->attach($imgURL);
        $cid = $email->setAttachmentCID($imgURL);
        $template = "<center>
        <img src='cid:". $cid ."' width='100'/>
        <table style='padding:20px;background-color:#ffffff;' border='0'><tbody>
        <tr><td><center><h1>Account Activation</h1></center></td></tr>
        <tr><td><center>Hi, ".$user['fullname']."</center></td></tr>
        <tr><td><p><center>Please click the link below to activate your account.</center></p></td><tr>
        <tr><td><center><b>".anchor('activate/'.$id,'Activate Account')."</b></center></td></tr>
        <tr><td><p><center>If you did not sign-up in CVSU-CCC ROTCL PORTAL Website,<br/> please ignore this message or contact us @ cvsu-ccc-rotc-portalb@gmail.com</center></p></td></tr>
        <tr><td><center>IT Support</center></td></tr></tbody></table></center>";
        $subject = "Account Activation | CVSU-CCC ROTC PORTAL";
        $email->setSubject($subject);
        $email->setMessage($template);
        $email->send();
        session()->setFlashdata('success','Great! Successfully sent activation link');
        return redirect()->to('success/'.$id)->withInput();
    }

    public function activateAccount($id)
    {
        $userModel = new \App\Models\studentModel();
        $student = $userModel->WHERE('token',$id)->first();
        $values = ['status'=>1];
        $userModel->update($student['student_id'],$values);
        session()->set('loggedUser', $student['student_id']);
        session()->set('fullname',$student['fullname']);
        session()->set('student_number',$student['school_id']);
        return $this->response->redirect(site_url('cadet/dashboard'));
    }

    public function index(): string
    {
        return view('welcome_message',['validation' => \Config\Services::validation()]);
    }

    public function validateUser()
    {
        $studentModel = new \App\Models\studentModel();
        $validation = $this->validate([
            'student_number' => [
                'rules' => 'required|is_not_unique[students.school_id]',
                'errors' => [
                    'required' => 'Student Number is required',
                    'is_not_unique' => 'Student Number does not exist'
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
            return view('welcome_message', [
                'validation' => $this->validator
            ]); 
        }
        else
        {
            $student_number = $this->request->getPost('student_number');
            $password = $this->request->getPost('password');

            $student = $studentModel->where('school_id', $student_number)->where('status',1)->first();
            $fullname = $student['fullname'];

            if($student)
            {
                if(Hash::check($password, $student['password']))
                {
                    session()->set('loggedUser', $student['student_id']);
                    session()->set('fullname',$fullname);
                    session()->set('student_number',$student['school_id']);
                    return redirect()->to(base_url('cadet/dashboard'));
                }
                else 
                {
                    session()->setFlashdata('fail','Invalid Password');
                    return redirect()->to('/')->withInput();
                }
            }
            else
            {
                session()->setFlashdata('fail','Student Number does not exist');
                return redirect()->to('/')->withInput();
            }
        }
    }

    public function logout()
    {
        if(session()->has('loggedUser'))
        {
            session()->remove('loggedUser');
            session()->destroy();
            return redirect()->to('/?access=out')->with('fail', 'You are logged out!');
        }
    }

    public function forgotPassword()
    {
       return view('forgot-password',['validation' => \Config\Services::validation()]);
    }
    public function newPassword()
    {
        $validation = $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[students.email]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address',
                    'is_not_unique' => 'Email does not exist'
                ]
            ]
        ]);

        if(!$validation)
        {
            return view('forgot-password', [
                'validation' => $this->validator
            ]); 
        }
        else
        {
            $email = $this->request->getPost('email');
            $studentModel = new \App\Models\StudentModel();
            $student = $studentModel->where('email', $email)->first();
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ?!@#$%^&*()_+';
                function generate_string($input, $strength = 16) {
                    $input_length = strlen($input);
                    $random_string = '';
                    for($i = 0; $i < $strength; $i++) {
                        $random_character = $input[random_int(0, $input_length - 1)];
                        $random_string .= $random_character;
                    }
                    return $random_string;
                }

            $newPassword = generate_string($permitted_chars, 16);
            $hashedPassword = Hash::make($newPassword);
            $studentModel->update($student['student_id'], ['password' => $hashedPassword]); 
            $fullname = $student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['surname'];
            // Send email with new password       
            $emailConfig = new Email();
            $fromEmail = $emailConfig->fromEmail;
            $fromName  = $emailConfig->fromName;  
            $email = \Config\Services::email();
            $email->setTo($student['email']);
            $email->setFrom($fromEmail,$fromName);
            $imgURL = "assets/images/logo.png";
            $email->attach($imgURL);
            $cid = $email->setAttachmentCID($imgURL);
            $template = "<center>
            <img src='cid:". $cid ."' width='100'/>
            <table style='padding:20px;background-color:#ffffff;' border='0'><tbody>
            <tr><td><center><h1>New Password</h1></center></td></tr>
            <tr><td><center>Hi, ".$fullname."</center></td></tr>
            <tr><td><p><center>We hope this email finds you well. This message is to inform you that your password has been successfully reset. Your new password is: </center></p></td><tr>
            <tr><td><center><b>".$newPassword."</b></center></td></tr>
            <tr><td><p><center>For security purposes, we strongly advise you to change this password once you log in to our website.</center></p></td></tr>
            <tr><td><p><center>If you did not request in CvSU CCC ROTC Unit Portal,<br/> please ignore this message or contact us @ division.gentri@deped.gov.ph</center></p></td></tr>
            <tr><td><center>IT Support</center></td></tr></tbody></table></center>";
            $subject = "New Password | CvSU-CCC ROTC Unit Portal";
            $email->setSubject($subject);
            $email->setMessage($template);
            if (!$email->send()) {
                session()->setFlashdata('fail','Failed to send email');
                return redirect()->to('/forgot-password');
            }
            log_message('info', 'Email sent to: ' . $student['email']);
            log_message('info', 'New password: ' . $newPassword);
            session()->setFlashdata('success','New password has been sent to your email');
            return redirect()->to('/forgot-password');
        }
    }

    public function studentDashboard()
    {
        $session = session();
        if($session->get('loggedUser') == null)
        {
            return redirect()->to(base_url('/'));
        }
        else
        {
            //check if cadets is empty
            $cadetModel = new cadetModel();
            $cadet = $cadetModel->where('student_id',session()->get('loggedUser'))->first();
            if(empty($cadet))
            {
                return redirect()->to(base_url('cadet/profile'));
            }
            $data['fullname'] = $session->get('fullname');
            $data['title']= 'Dashboard';
            return view('cadet/dashboard', $data);
        }
    }

    public function studentProfile()
    {
        $data['title'] = "Cadet Profile";
        $cadetModel = new cadetModel();
        $data['cadet'] = $cadetModel->where('student_id',session()->get('loggedUser'))->first();
        return view('cadet/profile',$data);
    }

    public function accountSecurity()
    {
        $data['title'] = "Account Security";
        return view('cadet/account',$data);
    }
}