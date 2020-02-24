<?php

    session_start();
    require_once '../database/database.php';
    include '../rbac/class.rbac.php';
    include 'class.user.php';

    $uid   = $_SESSION['uid'];
    $role  = $_SESSION['uid'];
    $check = $_POST['id'];       
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
        $id   = $_POST['id'];       
        $name = $user->getUsersName($id);
        $rbac ->deleteUserRole($id);   
        $user ->deleteUser($id); 
        $user ->deleteUserProfile($id); 
        echo '<button type="button" class="close">&times;</button>
              <strong>Success:</strong> Successfully Deleted User '.$name.'!';  
    }
     
?>