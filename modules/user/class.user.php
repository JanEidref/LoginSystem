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
                throw new Exception('<button type="button" class="close">&times;</button>
                                     <strong>Error:</strong> No Blank Fields Please!');
            }  

       }

       //validate if edit fields are empty
       function checkEditFields($userName, $firstName, $lastName){

            if(!$userName == TRUE || !$firstName == TRUE || !$lastName == TRUE){
                throw new Exception('<button type="button" class="close">&times;</button>
                                     <strong>Error:</strong> No Blank Fields Please!');
            } 

       }

       //check if username is already taken
       function checkUserName($userName){

            $this->connection->where("username", $userName);
            $data = $this->connection->getOne("users");

            if(!is_null($data)){
                throw new Exception('<button type="button" class="close">&times;</button>
                                     <strong>Error:</strong> Username Already Taken!');
            }

       }

       //check if edit username is taken
       function checkEditUserName($userName, $uid){

            $this->connection->where("username", $userName);
            $this->connection->where("uid != ".$uid);
            $data = $this->connection->getOne("users");

            if(!is_null($data)){
                throw new Exception('<button type="button" class="close">&times;</button>
                                     <strong>Error:</strong> Username Already Taken!');
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
   
            if(!$password == TRUE){

                $data = array("username" => $userName);

                $this->connection->where("uid", $uid);
                $this->connection->update("users", $data);

            }else{

                $encrypt = password_hash($password, PASSWORD_DEFAULT);
                $data    = array("username" => $userName, "password" => $encrypt);

                $this->connection->where("uid", $uid);
                $this->connection->update("users", $data);

            }

       }

       //Edit user profile
       function editProfile($uid, $firstName, $lastName){

            $data = array("first_name" => $firstName, "last_name" => $lastName);

            $this->connection->where("uid", $uid);
            $this->connection->update("user_profile", $data);

       }

    }

?>