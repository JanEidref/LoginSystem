<?php

    session_start();
    require_once '../database/database.php';
    include '../rbac/class.rbac.php';
    include 'class.user.php';

    $uid   = $_SESSION['uid'];
    $check = $_POST['uid'];
    $user  = new User();
    $rbac  = new Rbac();
    
    if(!$uid){
        $_SESSION['access'] = 2;
        header('Location: http://localhost/loginsystem/index.php');
        exit();          
    }else if(!isset($check)){
        $_SESSION['access'] = 2;
        header('Location: http://localhost/loginsystem/index.php');
        exit();               
    }else{
        $uid        = $_POST['uid'];
        $firstName  = $_POST['editFirstName'];
        $lastName   = $_POST['editLastName'];
        $userName   = $_POST['editUserName'];
        $password   = $_POST['newPassword'];
        $roleToEdit = $_POST['role'];
    
        try{ 
            $name     = $user->getUsersName($uid);        
            $rbac     ->checkIfSelected($roleToEdit);        
            $user     ->checkEditFields($userName, $firstName, $lastName);        
            $user     ->checkEditUserName($userName, $uid);        
            $rbac     ->editUserRole($uid, $roleToEdit);        
            $user     ->editUser($uid, $userName, $password);
            $user     ->editProfile($uid, $firstName, $lastName);
            $response = array('Result' => '<button type="button" class="close">&times;</button>
                                           <strong>Success:</strong> Successfully Edited User '.$name.'!', 
                              'Status' => "alert alert-success");
            echo json_encode($response);
        }catch (Exception $e){
            $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
            echo json_encode($response);              
        } 
    }

?>