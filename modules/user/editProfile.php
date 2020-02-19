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
            $user = new User($uid);        
            $user->editUserProfile($uid, $firstName, $lastName, $userName, $password);
        }catch (Exception $e){
            $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
            echo json_encode($response);              
        } 
    }

?>