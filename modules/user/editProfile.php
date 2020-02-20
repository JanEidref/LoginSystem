<?php

    session_start();
    include 'class.user.php';

    $uid  = $_SESSION['uid'];
    $user = new User($uid);
    
    if(!$uid){
        header('Location: http://localhost/loginsystem/index.php');
        exit();          
    }else{
        $uid        = $_POST['uid'];
        $firstName  = $_POST['editFirstName'];
        $lastName   = $_POST['editLastName'];
        $userName   = $_POST['editUserName'];
        $password   = $_POST['newPassword'];
    
        try{     
            $name     = $user->getUsersName();
            $user     ->checkEditFields($userName, $firstName, $lastName);
            $user     ->checkEditUserName($userName, $uid);
            $user     ->editUser($uid, $userName, $password);
            $user     ->editProfile($uid, $firstName, $lastName);
            $response = array('Result' => "<strong>Success:</strong> Successfully Edited Your Profile!", 'Status' => "alert alert-success");
            echo json_encode($response);
        }catch (Exception $e){
            $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
            echo json_encode($response);              
        } 
    }

?>