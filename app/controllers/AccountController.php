<?php

class AccountController{

    private $db;
    private $accountModel;

    function __construct(){
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    function login(){
        include_once 'app/views/account/login.php';
    }

    function register(){
        include_once 'app/views/account/register.php';
    }

    function save(){
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';

            $errors =[];
            if(empty($username)){
                $errors['username'] = "Vui lòng nhập tên đăng nhập!";
            }
            if(empty($fullName)){
                $errors['fullname'] = "Vui lòng nhập tên đầy đủ!";
            }
            if(empty($password)){
                $errors['password'] = "Vui lòng nhập mật khẩu!";
            }
            if($password != $confirmPassword){
                $errors['confirmPass'] = "Mật khẩu xác nhận không đúng!";
            }
            //kiểm tra username đã được đăng ký chưa?
            $account = $this->accountModel->getAccountByUsername($username);

            if($account){
                $errors['account'] = "Tài khoản đã tồn tại!";
            }
            
            if(count($errors) > 0){
                include_once 'app/views/account/register.php';
            }else{
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                
                $result = $this->accountModel->save($username, $fullName, $password);
                
                if($result){
                    header('Location: /topstyle/account/login');
                }
            }
        }       
       
    }
    function checkLogin(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $errors =[];
            if(empty($username)){
                $errors['username'] = "Vui Lòng Nhập Username!";
            }
            if(empty($password)){
                $errors['password'] = "Vui lòng nhập Mật Khẩu!";
            }
            if(count($errors) > 0){
                include_once 'app/views/account/login.php';
            }
            $account = $this->accountModel->getAccountByUsername($username);
            
            if($account && password_verify($password, $account->password)){
                //dang nhap thanh cong
                //luu trang thai dang nhap
                $_SESSION['username'] = $account->email;
                $_SESSION['role'] = $account->role;

                header('Location: /topstyle');
            }else{
                $errors['account'] = "Tài khoản hoặc mật khẩu không đúng!";
                include_once 'app/views/account/login.php';
            }
        }
    }

    function logout(){
        
        unset($_SESSION['username']);
        unset($_SESSION['role']);

        header('Location: /topstyle');
    }
}