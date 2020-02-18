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
        $id = $_POST['id'];
    
        $user = new User($id);        
        $user->deleteUser();        
    }


?>