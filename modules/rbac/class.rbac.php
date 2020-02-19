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

        //get all roles
        function getAllRoles(){

            $query = "SELECT * FROM roles";
            $result = mysqli_query($this->connection, $query);
            return $result;

        }

        //validate role name
        function checkRoleName($roleName){

            $query = $this->connection->prepare("SELECT * FROM roles WHERE role_name=?");
            $query ->bind_param("s", $roleName); 
            $query ->execute();
            $row   = $query->get_result();

            if($row->num_rows > 0){
                throw new Exception("<strong>Error:</strong> Role Name Already Exist!");
            }

        }

        //validate role level
        function checkRoleLevel($roleLevel){

            $query = $this->connection->prepare("SELECT * FROM roles WHERE role_level=?");
            $query ->bind_param("i", $roleLevel); 
            $query ->execute();
            $row   = $query->get_result();

            if($row->num_rows > 0){
                throw new Exception("<strong>Error:</strong> Role Level Already Exist!");
            }

        }

        //validate add role fields
        function checkRoleFields($roleName, $roleLevel){

            if(!$roleName || !$roleLevel){
                throw new Exception("<strong>Error:</strong> No Blank Fields Please!");
            }

        }

        //add a role
        function addRole($roleName, $roleLevel){

            $this->checkRoleFields($roleName, $roleLevel);
            $this->checkRoleName($roleName);
            $this->checkRoleLevel($roleLevel);

            $query = $this->connection->prepare("INSERT INTO roles (role_name,role_level) VALUES (?,?)");
            $query ->bind_param("si", $roleName, $roleLevel);
            $query ->execute();

            $response = array('Result' => '<strong>Success:</strong> Successfully added role!', 'Status' => 'alert alert-success');
            json_encode($response);

        }

    }//End of class rbac
?>