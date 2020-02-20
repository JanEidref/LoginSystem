<?php

    class User{

        //Properties of Class User
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
        
        //Get name of certain User
        function getUsersName(){

            $query  = "SELECT first_name, last_name FROM user_profile WHERE uid='$this->uid'";
            $result = mysqli_query($this->connection, $query);     
            $data   = mysqli_fetch_assoc($result);
            return $data['first_name']." ".$data['last_name'];

        }

        //Get all users data
        function getAllData(){

            $query  = "SELECT * FROM complete_data";
            $result = mysqli_query($this->connection, $query);
            return $result;

       }

       //get data of certain user
       function getData(){

            $query = $this->connection->prepare("SELECT * FROM complete_data where uid=?");
            $query ->bind_param("i", $this->uid);
            $query ->execute();
            return $query->get_result()->fetch_all(MYSQLI_ASSOC);

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

            $query = $this->connection->prepare("SELECT username FROM users WHERE username=?");
            $query -> bind_param("s", $userName);
            $query ->execute();                        
            $row   = $query->get_result();

            if($row->num_rows > 0){
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

            $selectUsers       = "SELECT max(uid) as max FROM users";
            $selectUsersResult = mysqli_query($this->connection, $selectUsers);
            $data              = mysqli_fetch_assoc($selectUsersResult);
            return $data['max'] + 1;

       }

       //get max uid user_profile
       function getMaxUidProfile(){

            $selectUsers       = "SELECT max(uid) as max FROM user_profile";
            $selectUsersResult = mysqli_query($this->connection, $selectUsers);
            $data              = mysqli_fetch_assoc($selectUsersResult);
            return $data['max'] + 1;
    
        }

       //add login data of user
       function addUser($userName, $password){

            $uid     = $this->getMaxUidUser();

            $encrypt = password_hash($password, PASSWORD_DEFAULT);
        
            $user    = $this->connection->prepare("INSERT into users (uid,username,password) VALUES (?,?,?)");
            $user->bind_param("iss",$uid,$userName,$encrypt);
            $user->execute();

       }

       //add user profile of user
       function addUserProfile($firstName, $lastName){

            $uid = $this->getMaxUidProfile();

            $profile = $this->connection->prepare("INSERT into user_profile (uid,first_name,last_name) VALUES (?,?,?)");
            $profile->bind_param("iss",$uid,$firstName,$lastName);
            $profile->execute();

       }

       //Delete user login data
       function deleteUser(){
 
            $user = "DELETE FROM users WHERE uid='$this->uid'";
            mysqli_query($this->connection, $user);
            
       }

       //delete user profile
       function deleteUserProfile(){

            $profile = "DELETE FROM user_profile WHERE uid='$this->uid'";
            mysqli_query($this->connection, $profile);

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