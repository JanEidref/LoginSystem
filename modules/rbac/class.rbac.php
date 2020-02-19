<?php
    class Rbac{

        //Properties of class rbac
        private $connection, $uid;
          
        
        //Connect to Database and set id
        function __construct($uid){

            // $this->connection = mysqli_connect("localhost", "root", "admin", "login");
            $this->connection = mysqli_connect("localhost", "root", "admin", "login");
            $this->uid        = $uid;

            if(!$this->connection){
                die("Error: " .mysqli_error($this->connection));
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

    }//End of class rbac
?>