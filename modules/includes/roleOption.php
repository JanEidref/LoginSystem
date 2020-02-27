<?php

    $uid = $_SESSION['uid'];

    if(!$uid){

        session_start();
        $_SESSION['access'] = 2;
        header('Location: ../../index.php');
        exit();

    }

    $role = $_SESSION['role'];
    $rbac = new Rbac();

    $options = $rbac->getAllRoles();

    foreach($options as $data){

        if($data['role_level'] < $role){

            echo '<option value="'.$data['role_level'].'" disabled>'.$data['role_name'].'</option>';

        }else{

            echo '<option value="'.$data['role_level'].'">'.$data['role_name'].'</option>';

        }

    }

    
?>