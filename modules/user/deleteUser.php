<?php

    session_start();
    include 'class.user.php';
    include '../rbac/class.rbac.php';

    $uid  = $_SESSION['uid'];
    $rbac = new rbac($uid);
    $rbac ->checkSession();
    $rbac ->checkAccess();
    
    $id   = $_POST['id'];
    $user = new User($id);        
    $user ->deleteUser();        

?>