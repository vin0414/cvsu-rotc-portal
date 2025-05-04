<?php

namespace App\Controllers;
use App\Libraries\Hash;

class Home extends BaseController
{
    private $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['url', 'form']);
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
            $fullname = $student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['surname'];

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
            $email = \Config\Services::email();
            $email->setTo($student['email']);
            $email->setFrom('vinmogate@gmail.com','CvSU-CCC ROTC Unit Portal');
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
            // Uncomment the following line to actually send the email
            // $email->send();
            // For testing purposes, you can log the email content
            log_message('info', 'Email sent to: ' . $student['email']);
            log_message('info', 'New password: ' . $newPassword);
            // You can also log the email content to a file or database for debugging
            // Logic to send email with new password
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
            $data['fullname'] = $session->get('fullname');
            $data['title']= 'Dashboard';
            return view('cadet/dashboard', $data);
        }
    }
}