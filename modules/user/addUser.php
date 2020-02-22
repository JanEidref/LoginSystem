<?php

    session_start();
    require_once '../database/database.php';
    include '../rbac/class.rbac.php';
    include 'class.user.php';

    $uid  = $_SESSION['uid'];
    $role = $_SESSION['uid'];
    $user = new User($uid);
    $rbac = new Rbac($uid);
    $data = $rbac->getAccess($role);
    
    if(!$uid){
        header('Location: http://localhost/loginsystem/index.php');
        exit();          
    }else if($data['add_user'] == 0){
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
            $user     ->checkFields($userName, $password, $firstName, $lastName);
            $user     ->checkUserName($userName);        
            $rbac     ->checkIfSelected($roleToAdd);
            $user     ->addUSer($userName, $password);  
            $user     ->addUserProfile($firstName, $lastName);  
            $rbac     ->addUSerRole($roleToAdd);
            $response = array('Result' => "<strong>Success:</strong> Successfully Added User!", 'Status' => "alert alert-success");
            echo json_encode($response);      
        }catch (Exception $e){
            $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
            echo json_encode($response);
        } 

    }      

?>