<?php
    class Login extends Database{

        function checkLogin($userName, $password){

            $this->connection->where("username", $userName);
            $data = $this->connection->getOne("users");

            if(!is_null($data)){

                if(password_verify($password, $data['password'])){

                    return 1;

                }else{

                    return 2;

                }

            }else{

                return 3;

            }

        }

    }//end of class Login
?>