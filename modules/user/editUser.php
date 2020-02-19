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
        $uid        = $_POST['uid'];
        $firstName  = $_POST['editFirstName'];
        $lastName   = $_POST['editLastName'];
        $userName   = $_POST['editUserName'];
        $password   = $_POST['newPassword'];
        $roleToEdit = $_POST['editRole'];
    
        try{
            $user = new User($uid);        
            $user->editUser($uid, $firstName, $lastName, $userName, $password, $roleToEdit);
        }catch (Exception $e){
            $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
            echo json_encode($response);              
        } 
    }



?>