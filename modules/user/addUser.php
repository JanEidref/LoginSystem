<?php

    session_start();
    include 'class.user.php';
    include '../rbac/class.rbac.php';

    $uid       = $_SESSION['uid'];
    $rbac      = new rbac($uid);
    $rbac      ->checkSession();
    $rbac      ->checkAccess();
    $role      = $rbac->getUserRoleNumber(); 

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

?>