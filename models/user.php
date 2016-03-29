<?php

class User extends Model{

    public function getById($id){
        $id = (int)$id;
        $sql = "select * from users where login = '{$id}' limit 1";
        $result = $this->db->query($sql);
        if (isset($result[0]) ){
            return $result[0];
        }
        return false;
    }

    public function getByLogin($login){
        $login = $this->db->escape($login);
        $sql = "select * from users where email = '{$login}' limit 1";
        $result = $this->db->query($sql);
        if (isset($result[0]) ){
            return $result[0];
        }
        return false;
    }


   /* public function CheckName($name){
        if (strlen($name) >=4){
            return true;
        }
        Session::setFlash('Длина не мен 4');
        return false;
    }*/


    public function register($data){
        if ( !isset($data['password']) || !isset($data['login']) || !isset($data['name']) ){
            return false;
        }
        $login = $this->db->escape(strtolower($data['login']));

        if ( $this->getByLogin($login)){
            Session::setFlash('Такой email уже существует!');
            return false;//такой уже есть в базе
        }

     //   $name = n12br(htmlspecialchars( trim($data['name']),ENT_QUOTES),false);

        $name = htmlspecialchars( trim($data['name']),ENT_QUOTES);
        $password = htmlspecialchars( trim($data['password']),ENT_QUOTES);
        $hash = md5(Config::get('salt').$password);



        $sql = "
            insert into users
            set login = '{$name}',
                email = '{$login}',
                role = 'registered',
                password = '{$hash}',
                is_active = 1
        ";
//print_r($sql); die;

        if ( $this->db->query($sql) ){
            return $this->db->insertId();
        }
        return false;
    }
}