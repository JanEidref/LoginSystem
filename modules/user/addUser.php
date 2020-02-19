<?php

    session_start();
    include 'class.user.php';
    include '../rbac/class.rbac.php';

    $uid  = $_SESSION['uid'];
    $user = new User($uid);
    $rbac = new Rbac($uid);
    $role = $rbac->getUserRoleNumber();
    
    if(!$uid){
        header('Location: http://localhost/loginsystem/index.php');
        exit();          
    }else if($role > 1){
        $_SESSION['access'] = 2;
        header('Location: http://localhost/loginsystem/main.php');
        exit();               
    }else{

        $userName  = $_POST['userName'];
        $password  = $_POST['password']; 
        $firstName = $_POST['firstName']; 
        $lastName  = $_POST['lastName']; 
        $roleToAdd = $_POST['role']; 
        
        try{
            $user = new User(1);
            $user->addUSer($userName, $password, $firstName, $lastName, $roleToAdd);        
        }catch (Exception $e){
            $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
            echo json_encode($response);
        } 

    }      

?>