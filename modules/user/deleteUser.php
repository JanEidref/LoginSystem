<?php

    session_start();
    include 'class.user.php';
    include '../rbac/class.rbac.php';

    $uid = $_SESSION['uid'];

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
        $id   = $_POST['id'];
        $user = new User($id);        
        $rbac = new Rbac($id);        
        $name = $user->getUsersName();
        $rbac ->deleteUserRole();   
        $user ->deleteUser(); 
        $user ->deleteUserProfile(); 
        echo "<strong>Success:</strong> Successfully Deleted User ".$name."!";  
    }
     
?>