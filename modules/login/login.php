<?php

    require_once '../database/database.php';    
    include '../user/class.user.php';
    include '../rbac/class.rbac.php';
    include 'class.login.php';

    $userName = $_POST['userName'];
    $password = $_POST['password'];

    $login  = new Login();
    $user   = new User();
    $rbac   = new Rbac();
    $result = $login -> checkLogin($userName, $password);
    $uid    = $user->getUid($userName);

    switch($result){

        case 1:
            session_start();
            $_SESSION['uid']    = $uid;
            $_SESSION['access'] = 1;
            $_SESSION['name']   = $user->getUsersName($uid);
            $_SESSION['role']   = $rbac->getUserRoleNumber($uid);
            header('Location: ../../main.php');
        break;

        case 2:
            session_start();
            $_SESSION['Error'] = "Wrong Password!";
            header('Location: ../../index.php');
        break;

        case 3:
            session_start();
            $_SESSION['Error'] = "No Such User!";
            header('Location: ../../index.php');
        break;

    }



?>