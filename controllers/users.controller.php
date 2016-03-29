<?php

class UsersController extends Controller{

    public function __construct($data = array() )
    {
        parent::__construct($data);
        $this->model = new User();

    }

    /*  protected function sendWelcomeEmail($email, $login){
          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->SMTPDebug = 0;
          $mail->SMTPAuth = true;
          $mail->SMTPSecure = 'ssl';
          $mail->Host = 'smtp.yandex.ua';
          $mail->Port = 465; //или 587
          $mail->isHTML(true);
          $mail->Username = 'danshevchyk@yandex.ua';
          $mail->Password = '89ghbdtn';
          $mail->CharSet = 'UTF-8';
          $mail->setFrom('danshevchyk@yandex.ua');
          $mail->Subject = 'Успешная регистрация!';
          $mail->Body = '<b>Вы зарегистрировались  !</b> Ваш логин - '.$login;
          $mail->addAddress('danshevchyk@gmail.com');

          return $mail->Send();
  /*
          if( !$mail->send() ) {
              echo 'Сообщение не может быть отправленно';
              echo 'Ошибка Mailer: ' . $mail->ErrorInfo;
          } else {
              //Session::setFlash('Cообщение отправ!');
              echo 'Сообщение отправлено!';
          }
        //  var_dump($mail);die;
    }*/

    public function register(){
        if ($_POST){
          // echo "<pre>";print_r($_POST);die;
            $result= $this->model->register($_POST);
            if ($result){
                $user = $this->model->getById($result);//'Вы зарегестрированы под номером'.$result);
                Session::set('login', $user['login']);
                Session::set('role', $user['role']);
               // $this->sendWelcomeEmail($user['email'],$user['login']);
                Session::setFlash('Вы зарегестрированы! Под номером - '.$result);
                Router::redirect('/');

            } else {
                //Session::setFlash('Ошибка при регистрации!');
                Router::redirect('/users/register');
            }
        }
    }

    public function login(){
        if ($_POST && isset($_POST['login']) && isset($_POST['password']) ){
            $user = $this->model->getByLogin($_POST['login']);
            $hash = md5(Config::get('salt').$_POST['password']);
            if ( $user && $user['is_active'] && $hash == $user['password'] ){
                Session::set('login', $user['login']);
                Session::set('role', $user['role']);
                Session::setFlash('Добро пожаловать! '.$user['login']);
            }else{
                Session::setFlash('Неверный логин/пароль!');
                Router::redirect('/users/login');
            }
            if ( $user['role'] == 'admin'){
                Session::setFlash('Добро пожаловать Admin!');
                Router::redirect('/admin/');
            }
            Router::redirect('/');
        }
    }



    public function admin_logout(){
        Session::destroy();
        Router::redirect('/admin/');
    }
    public function logout(){
        Session::destroy();
        Router::redirect('/');
    }
    public function unlogout(){
        Session::setFlash('Зарегестрируйтесь или войдите перед отправкой сообщения!');
        Router::redirect('/users/register/');
    }





}