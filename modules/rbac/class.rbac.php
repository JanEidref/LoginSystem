<?php
    class Rbac{

        //Properties of class rbac
        private $host     = "localhost";
        private $dbuser   = "root";
        private $dbpass   = "admin";
        private $database = "login";
        private $connection, $uid;
          
        
        //Connect to Database and set id
        function __construct($uid){

            $this->connection = mysqli_connect($this->host, $this->dbuser, $this->dbpass, $this->database);
            $this->uid        = $uid;

            if(!$this->connection){
                die("Error: " .mysqli_error($this->connection));
            }

        }

        //check if user has a session
        function checkSession(){

            if(!$this->uid){
                
                header('Location: http://localhost/loginsystem/index.php');
                exit();   

            }

        }

        //Get number of Users Role
        function getUserRoleNumber(){

            $query  = "SELECT role FROM rbac WHERE uid='$this->uid'";
            $result = mysqli_query($this->connection, $query);
            
            if(mysqli_num_rows($result) > 0){

                $data = mysqli_fetch_assoc($result);

                return $data['role'];

            }

        }

        //Check access of user by his role
        function checkAccess(){

            $role = $this->getUserRoleNumber();

            if($role > 1){

                session_start();
                $_SESSION['access'] = 2;
                header('Location: http://localhost/loginsystem/main.php');
                exit();                

            }

        }

    }//End of class rbac
?>