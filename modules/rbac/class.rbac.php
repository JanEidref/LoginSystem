<?php
    class Rbac extends Database{

        //Get number value of User's Role
        function getUserRoleNumber($uid){

            $this ->connection->where("uid", $uid);
            $data = $this->connection->getOne("rbac");
            return $data['role'];

        }

        //check access of role
        function getAccess($role){

           $this->connection->where("role_level", $role);
           return $this->connection->getOne("roles");

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

            return $this->connection->get("roles");

        }

        //get max uid
        function getMaxUid(){

            return $this->connection->getValue("rbac","max(uid)");

        }

        //validate role name
        function checkRoleName($roleName){

            $this->connection->where("role_name", $roleName);
            $data = $this->connection->getOne("roles");

            if(!is_null($data)){
                throw new Exception('<button type="button" class="close">&times;</button>
                                     <strong>Error:</strong> Role Name Already Exist!');
            }           

        }


        //validate edit role name
        function checkEditRoleName($id, $roleName){

            $query = $this->connection->prepare("SELECT * FROM roles WHERE role_name=? and id!=?");
            $query ->bind_param("si", $roleName, $id); 
            $query ->execute();
            $row   = $query->get_result();

            if($row->num_rows > 0){
                throw new Exception('<button type="button" class="close">&times;</button>
                                     <strong>Error:</strong> Role Name Already Exist!');
            }

        }

        //validate role level
        function checkRoleLevel($roleLevel){

            $this->connection->where("role_level", $roleLevel);
            $data = $this->connection->getOne("roles");

            if(!is_null($data)){
                throw new Exception('<button type="button" class="close">&times;</button>
                                     <strong>Error:</strong> Role Level Already Exist!');
            }

        }

        //validate edit role level
        function checkEditRoleLevel($id, $roleLevel){

            $query = $this->connection->prepare("SELECT * FROM roles WHERE role_level=? and id!=?");
            $query ->bind_param("ii", $roleLevel, $id); 
            $query ->execute();
            $row   = $query->get_result();

            if($row->num_rows > 0){
                throw new Exception('<button type="button" class="close">&times;</button>
                                     <strong>Error:</strong> Role Level Already Exist!');
            }

        }

        //validate add role fields
        function checkRoleFields($roleName, $roleLevel){

            if(!$roleName || !$roleLevel){
                throw new Exception('<button type="button" class="close">&times;</button>
                                     <strong>Error:</strong> No Blank Fields Please!');
            }

        }

        //check if role is assigned to users
        function checkIfUsed($roleLevel){

            $query = $this->connection->prepare("SELECT * FROM rbac where role=?");
            $query ->bind_param("i", $roleLevel);
            $query ->execute();
            $row   = $query->get_result();
            
            if($row->num_rows > 0){

                throw new Exception('<button type="button" class="close">&times;</button>
                                     <strong>Error:</strong> Certain user still assign to this Role!');

            }

        }

        //check if a role is selected
        function checkIfSelected($role){

            if($role == 0){
                throw new Exception('<button type="button" class="close">&times;</button>
                                     <strong>Error:</strong> Please Select a Role for User!');
            }

        }

        //add a role
        function addRole($roleName, $roleLevel){

            $data = array("role_name" => $roleName, "role_level" => $roleLevel);
            $this->connection->insert("roles", $data);

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

           $uid = $this->getMaxUid() + 1;

           $data = array("uid" => $uid, "role" => $role);
           $this->connection->insert("rbac", $data);

       }

       //edit user's role
       function editUserRole($uid,$role){

            $data = array("role" => $role);

            $this->connection->where("uid", $uid);
            $this->connection->update("rbac", $data);

       }

       //delete user's role
       function deleteUserRole($uid){

           $this->connection->where("uid", $uid);
           $this->connection->delete("rbac");

       }

    }//End of class rbac
?>