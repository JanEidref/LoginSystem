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
       function checkFields($userName, $password, $firstName, $lastName, $role){

            if(!$userName == TRUE || !$password == TRUE || !$firstName == TRUE || !$lastName == TRUE){
                throw new Exception("<strong>Error:</strong> No Blank Fields Please!");
            }else if($role == 0){
                throw new Exception("<strong>Error:</strong> Please Select A Role For The User!");
            }    

       }

       //validate if edit fields are empty
       function checkEditFields($userName, $firstName, $lastName, $role){

            if(!$userName == TRUE || !$firstName == TRUE || !$lastName == TRUE){
                throw new Exception("<strong>Error:</strong> No Blank Fields Please!");
            }else if($role == 0){
                throw new Exception("<strong>Error:</strong> Please Select A Role For The User!");
            }    

       }

       //validate if edit fields are empty
       function checkProfileFields($userName, $firstName, $lastName){

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

       //get max uid
       function getMaxUid(){

        $selectUsers       = "SELECT max(uid) as max FROM users";
        $selectUsersResult = mysqli_query($this->connection, $selectUsers);
        $data              = mysqli_fetch_assoc($selectUsersResult);
        return $data['max'] + 1;

       }

       //add data of user
       function addUser($userName, $password, $firstName, $lastName, $role){

            $this->checkFields($userName, $password, $firstName, $lastName, $role);
            $this->checkUserName($userName);
            $uid = $this->getMaxUid();

            $encrypt = password_hash($password, PASSWORD_DEFAULT);
        
            $user    = $this->connection->prepare("INSERT into users (uid,username,password) VALUES (?,?,?)");
            $user->bind_param("iss",$uid,$userName,$encrypt);
            $user->execute();

            $profile = $this->connection->prepare("INSERT into user_profile (uid,first_name,last_name) VALUES (?,?,?)");
            $profile->bind_param("iss",$uid,$firstName,$lastName);
            $profile->execute();

            $rbac    = $this->connection->prepare("INSERT into rbac (uid,role) VALUES (?,?)");
            $rbac->bind_param("ii",$uid,$role);
            $rbac->execute();

            $response = array('Result' => "<strong>Success:</strong> Successfully Added User!", 'Status' => "alert alert-success");
            echo json_encode($response);

       }

       //Delete user by id
       function deleteUser(){

            $name      = $this->getUsersName(); 
            $user      = "DELETE FROM users WHERE uid='$this->uid'";
            $profile   = "DELETE FROM user_profile WHERE uid='$this->uid'";
            $rbac      = "DELETE FROM rbac WHERE uid='$this->uid'";

            mysqli_query($this->connection, $user);
            mysqli_query($this->connection, $profile);
            mysqli_query($this->connection, $rbac);

            echo "<strong>Success:</strong> Successfully Deleted User ".$name."!";
       }

       //Edit user's data
       function editUser($uid, $firstName, $lastName, $userName, $password, $role){

            $this->uid = $uid;
            $name      = $this->getUsersName();
            $this->checkEditUserName($userName, $uid);
            $this->checkEditFields($userName, $firstName, $lastName, $role);
            
            if(!$password == TRUE){

                $editUser    = $this->connection->prepare('UPDATE users SET username=? WHERE uid=?');
                $editUser->bind_param("si", $userName, $uid);
                $editUser->execute();
    
                $editProfile = $this->connection->prepare('UPDATE user_profile SET first_name=?, last_name=? WHERE uid=?');
                $editProfile->bind_param("ssi", $firstName, $lastName, $uid);
                $editProfile->execute();
    
                $editRbac    = $this->connection->prepare('UPDATE rbac SET role=? WHERE uid=?');
                $editRbac->bind_param("ii", $role, $uid);
                $editRbac->execute();
     
                $response = array('Result' => "<strong>Success:</strong> Successfully Edited User ".$name."!", 'Status' => "alert alert-success");
                echo json_encode($response);

            }else{

                $encrypt     = password_hash($password, PASSWORD_DEFAULT);

                $editUser    = $this->connection->prepare('UPDATE users SET username=?, password=? WHERE uid=?');
                $editUser->bind_param("ssi", $userName, $encrypt, $uid);
                $editUser->execute();
    
                $editProfile = $this->connection->prepare('UPDATE user_profile SET first_name=?, last_name=? WHERE uid=?');
                $editProfile->bind_param("ssi", $firstName, $lastName, $uid);
                $editProfile->execute();
    
                $editRbac    = $this->connection->prepare('UPDATE rbac SET role=? WHERE uid=?');
                $editRbac->bind_param("ii", $role, $uid);
                $editRbac->execute();
     
                $response = array('Result' => "<strong>Success:</strong> Successfully Edited User ".$name."!", 'Status' => "alert alert-success");
                echo json_encode($response);

            }

       }

       //Edit own profile
       function editUserProfile($uid, $firstName, $lastName, $userName, $password){

            $this->uid = $uid;
            $name      = $this->getUsersName();
            $this->checkEditUserName($userName, $uid);
            $this->checkProfileFields($userName, $firstName, $lastName);
            
            if(!$password == TRUE){

                $editUser    = $this->connection->prepare('UPDATE users SET username=? WHERE uid=?');
                $editUser->bind_param("si", $userName, $uid);
                $editUser->execute();

                $editProfile = $this->connection->prepare('UPDATE user_profile SET first_name=?, last_name=? WHERE uid=?');
                $editProfile->bind_param("ssi", $firstName, $lastName, $uid);
                $editProfile->execute();
    
                $response = array('Result' => "<strong>Success:</strong> Successfully Edited Your Profile!", 'Status' => "alert alert-success");
                echo json_encode($response);

            }else{

                $encrypt     = password_hash($password, PASSWORD_DEFAULT);

                $editUser    = $this->connection->prepare('UPDATE users SET username=?, password=? WHERE uid=?');
                $editUser->bind_param("ssi", $userName, $encrypt, $uid);
                $editUser->execute();

                $editProfile = $this->connection->prepare('UPDATE user_profile SET first_name=?, last_name=? WHERE uid=?');
                $editProfile->bind_param("ssi", $firstName, $lastName, $uid);
                $editProfile->execute();
    
                $response = array('Result' => "<strong>Success:</strong> Successfully Edited Your Profile!", 'Status' => "alert alert-success");
                echo json_encode($response);

            }

       }

    }

?>