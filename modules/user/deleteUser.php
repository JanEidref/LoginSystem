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
    }else if($data['delete_user'] == 0){
        $_SESSION['access'] = 2;
        header('Location: http://localhost/loginsystem/main.php');
        exit();               
    }else{
        $id   = $_POST['id'];       
        $name = $user->getUsersName($id);
        $rbac ->deleteUserRole($id);   
        $user ->deleteUser($id); 
        $user ->deleteUserProfile($id); 
        echo "<strong>Success:</strong> Successfully Deleted User ".$name."!";  
    }
     
?>