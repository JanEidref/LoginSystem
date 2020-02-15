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
        $uid       = $_POST['uid'];
        $firstName = $_POST['editFirstName'];
        $lastName  = $_POST['editLastName'];
        $userName  = $_POST['editUserName'];
        $password  = $_POST['newPassword'];
        $role      = $_POST['editRole'];

        try{
            $user = new User($uid);        
            $user->editUser($uid, $firstName, $lastName, $userName, $password, $role);
        }catch (Exception $e){
            $_SESSION['error'] = $e->getMessage();
            header('Location: ../../editPage.php');               
        }       
    }

?>