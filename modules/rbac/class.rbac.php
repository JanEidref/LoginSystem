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

        //Get number value of User's Role
        function getUserRoleNumber(){

            $query  = "SELECT role FROM rbac WHERE uid='$this->uid'";
            $result = mysqli_query($this->connection, $query);
            
            if(mysqli_num_rows($result) > 0){

                $data = mysqli_fetch_assoc($result);

                return $data['role'];

            }

        }

        //get data of a certain role
        function getRoleData($roleId){

            $query = $this->connection->prepare("SELECT * FROM roles WHERE id=?");
            $query -> bind_param("i", $roleId);
            $query ->execute();
            return $query->get_result()->fetch_all(MYSQLI_ASSOC);

        }

        //get all roles
        function getAllRoles(){

            $query = "SELECT * FROM roles";
            $result = mysqli_query($this->connection, $query);
            return $result;

        }

        //get max uid
        function getMaxUid(){

            $selectUsers       = "SELECT max(uid) as max FROM rbac";
            $selectUsersResult = mysqli_query($this->connection, $selectUsers);
            $data              = mysqli_fetch_assoc($selectUsersResult);
            return $data['max'] + 1;

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


        //validate edit role name
        function checkEditRoleName($id, $roleName){

            $query = $this->connection->prepare("SELECT * FROM roles WHERE role_name=? and id!=?");
            $query ->bind_param("si", $roleName, $id); 
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

        //validate edit role level
        function checkEditRoleLevel($id, $roleLevel){

            $query = $this->connection->prepare("SELECT * FROM roles WHERE role_level=? and id!=?");
            $query ->bind_param("ii", $roleLevel, $id); 
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

        //check if role is assigned to users
        function checkIfUsed($roleLevel){

            $query = $this->connection->prepare("SELECT * FROM rbac where role=?");
            $query ->bind_param("i", $roleLevel);
            $query ->execute();
            $row   = $query->get_result();
            
            if($row->num_rows > 0){

                throw new Exception("<strong>Error:</strong> Certain user still assign to this Role!");

            }

        }

        //check if a role is selected
        function checkIfSelected($role){

            if($role == 0){
                throw new Exception("<strong>Error:</strong> Please Select a Role for User!");
            }

        }

        //add a role
        function addRole($roleName, $roleLevel){

            $query = $this->connection->prepare("INSERT INTO roles (role_name,role_level) VALUES (?,?)");
            $query ->bind_param("si", $roleName, $roleLevel);
            $query ->execute();

        }

        //edit a role
        function editRole($id, $roleName, $roleLevel){

            $query = $this->connection->prepare("UPDATE roles SET role_name=?, role_level=? WHERE id=?");
            $query ->bind_param("sii", $roleName, $roleLevel, $id);
            $query ->execute();

        }

        //delete a role
        function deleteRole($roleLevel){

            $query = $this->connection->prepare("DELETE FROM roles WHERE role_level=?");
            $query ->bind_param("i", $roleLevel);
            $query -> execute();

        }

       //add user's role
       function addUserRole($role){

           $uid = $this->getMaxUid();

           $rbac = $this->connection->prepare("INSERT into rbac (uid,role) VALUES (?,?)");
           $rbac->bind_param("ii",$uid,$role);
           $rbac->execute();

       }

       //edit user's role
       function editUserRole($uid,$role){

           $this->checkIfSelected($role);
    
           $editRbac = $this->connection->prepare('UPDATE rbac SET role=? WHERE uid=?');
           $editRbac ->bind_param("ii", $role, $uid);
           $editRbac ->execute();

       }

       //delete user's role
       function deleteUserRole(){

           $rbac = "DELETE FROM rbac WHERE uid='$this->uid'";
           mysqli_query($this->connection, $rbac);

       }

    }//End of class rbac
?>