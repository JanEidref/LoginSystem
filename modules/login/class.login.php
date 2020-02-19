<?php
    class Login{

        //Properties of class Login
        private $connection;
          
        
        //Connect to Database and Logs user in
        function __construct(){

            // $this->connection = mysqli_connect("localhost", "root", "admin", "login");
            $this->connection = mysqli_connect("localhost", "root", "admin", "login");

            if(!$this->connection){
                die("Error: " .mysqli_error($this->connection));
            }

        }

        function verifyPassword($password, $hash, $uid){

            if(password_verify($password, $hash)){
                session_start();
                $_SESSION['uid']     = $uid;
                $_SESSION['access']  = 1;
                header('Location: ../../main.php');
            }else{
                session_start();
                $_SESSION['Error'] = "Wrong Password!";
                header('Location: ../../index.php');
            }

        }

        function checkLogin($userName, $password){

            $query   = $this->connection->prepare("SELECT * FROM users WHERE username=?");
            $query   ->bind_param("s",$userName);
            $query   ->execute();                        
            $row     = $query->get_result();
            $data    = $row->fetch_array(MYSQLI_ASSOC);

            if($row->num_rows > 0){

                $this->verifyPassword($password, $data['password'], $data['uid']);

            }else{
                session_start();
                $_SESSION['Error'] = "No Such User!";
                header('Location: ../../index.php');
            }

        }

    }//end of class Login
?>