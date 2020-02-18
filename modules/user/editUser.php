<?php

    session_start();
    include 'class.user.php';
    include '../rbac/class.rbac.php';

    $uid       = $_SESSION['uid'];
    $rbac      = new rbac($uid);
    $rbac      ->checkSession();
    $rbac      ->checkAccess();
    $role      = $rbac->getUserRoleNumber(); 

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

?>