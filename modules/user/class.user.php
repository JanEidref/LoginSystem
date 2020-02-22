<?php

    class User extends Database{

        //Get uid by username
        function getUid($userName){

            $this ->connection->where("username", $userName);
            $data = $this->connection->getOne("users");
            return $data['uid'];                

        }
   
        //Get name of certain User
        function getUsersName($uid){

            $this ->connection->where("uid", $uid);
            $data = $this->connection->getOne("user_profile");
            return $data['first_name']." ".$data['last_name'];    

        }

        //Get all users data
        function getAllData(){

           return $this->connection->get("complete_data");

       }

       //get data of certain user
       function getData($uid){

          $this->connection->where("uid", $uid);
          return $this->connection->getOne("complete_data");

       }

       //validate if fields are empty
       function checkFields($userName, $password, $firstName, $lastName){

            if(!$userName == TRUE || !$password == TRUE || !$firstName == TRUE || !$lastName == TRUE){
                throw new Exception("<strong>Error:</strong> No Blank Fields Please!");
            }  

       }

       //validate if edit fields are empty
       function checkEditFields($userName, $firstName, $lastName){

            if(!$userName == TRUE || !$firstName == TRUE || !$lastName == TRUE){
                throw new Exception("<strong>Error:</strong> No Blank Fields Please!");
            } 

       }

       //check if username is already taken
       function checkUserName($userName){

            $this->connection->where("username", $userName);
            $data = $this->connection->getOne("users");

            if(!is_null($data)){
                throw new Exception("<strong>Error:</strong> Username Already Taken!");
            }

       }

       //check if edit username is taken
       function checkEditUserName($userName, $uid){

            $query = $this->connection->prepare("SELECT username FROM users WHERE username=? and uid!=?");
            $query -> bind_param("si", $userName,$uid);
            $query ->execute();                        
            $row   = $query->get_result();

            if($row->num_rows > 0){
                throw new Exception("<strong>Error:</strong> Username Already Taken!");
            }

        }

       //get max uid user
       function getMaxUidUser(){

          return $this->connection->getValue("users", "max(uid)");

       }

       //get max uid user_profile
       function getMaxUidProfile(){

          return $this->connection->getValue("user_profile", "max(uid)");
    
       }

       //add login data of user
       function addUser($userName, $password){

            $uid     = $this->getMaxUidUser() + 1;

            $encrypt = password_hash($password, PASSWORD_DEFAULT);
            $data    = array("uid" => $uid, "username" => $userName, "password" => $encrypt);
            $this->connection->insert("users", $data); 

       }

       //add user profile of user
       function addUserProfile($firstName, $lastName){

            $uid  = $this->getMaxUidProfile() + 1;

            $data = array("uid" => $uid, "first_name" => $firstName, "last_name" => $lastName);
            $this->connection->insert("user_profile", $data); 

       }

       //Delete user login data
       function deleteUser($uid){
 
            $this->connection->where("uid", $uid);
            $this->connection->delete("users");
            
       }

       //delete user profile
       function deleteUserProfile($uid){

            $this->connection->where("uid", $uid);
            $this->connection->delete("user_profile");

       }

       //Edit user's login data
       function editUser($uid, $userName, $password){

            $this->uid = $uid;
            
            if(!$password == TRUE){

                $editUser    = $this->connection->prepare('UPDATE users SET username=? WHERE uid=?');
                $editUser->bind_param("si", $userName, $uid);
                $editUser->execute();

            }else{

                $encrypt     = password_hash($password, PASSWORD_DEFAULT);

                $editUser    = $this->connection->prepare('UPDATE users SET username=?, password=? WHERE uid=?');
                $editUser->bind_param("ssi", $userName, $encrypt, $uid);
                $editUser->execute();

            }

       }

       //Edit user profile
       function editProfile($uid, $firstName, $lastName){

            $this->uid = $uid;

            $editProfile = $this->connection->prepare('UPDATE user_profile SET first_name=?, last_name=? WHERE uid=?');
            $editProfile->bind_param("ssi", $firstName, $lastName, $uid);
            $editProfile->execute();

       }

    }

?>