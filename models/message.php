<?php

class Message extends Model {

    public function save($data, $id = null){
        if ( !isset($data['login']) || !isset($data['email']) || !isset($data['message'])){
            return false;
        }

        $id = (int)$id;
        $name = $this->db->escape(htmlspecialchars( trim($data['login']), ENT_QUOTES) );
        $email = $this->db->escape(htmlspecialchars( trim($data['email']), ENT_QUOTES) );
        $message = $this->db->escape(htmlspecialchars( trim($data['message']), ENT_QUOTES) );

        if ( !$id ) {

            $sql = "
            insert into messages
                set name = '{$name}',
                    email = '{$email}',
                    message = '{$message}'
            ";
            } else {
            $sql = "
              update messages
                set name = '{$name}',
                    email = '{$email}',
                    message = '{$message}'
                    where id = {$id}
            ";
        }

        return $this->db->query($sql);
    }

    public function getList(){
        $sql = "select * from messages where 1";

        return $this->db->query($sql);

    }


}