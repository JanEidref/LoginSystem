<?php

    session_start();
    include 'class.user.php';

    $uid   = $_SESSION['uid'];
    $check = new User($uid);
    $role  = $check->getUserRoleNumber(); 

    if(!isset($uid)){
        header('Location: ../../index.php');
        exit();
    }else if($role > 1){
        $_SESSION['access'] = 2;
        header('Location: ../../main.php');
        exit();
    }else{
        $userName  = $_POST['userName'];
        $password  = $_POST['password']; 
        $firstName = $_POST['firstName']; 
        $lastName  = $_POST['lastName']; 
        $role      = $_POST['role']; 
    
        try{
            $user = new User(1);
            $user->addUSer($userName, $password, $firstName, $lastName, $role);        
        }catch (Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header('Location: ../../addPage.php');
        }       
    }

?>