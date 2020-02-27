<?php
    session_start();
    require_once '../database/database.php';
    include '../rbac/class.rbac.php';

    $uid   = $_SESSION['uid'];
    $check = $_POST['roleId'];
    $rbac  = new Rbac();

    if(!$uid){
        header('Location: http://localhost/loginsystem/index.php');
        exit(); 
    }else if(!isset($check)){
        $_SESSION['access'] = 2;
        header('Location: http://localhost/loginsystem/index.php');
        exit();  
    }else{

        $id           = $_POST['roleId'];
        $roleName     = $_POST['editRoleName'];
        $roleLevel    = $_POST['editRoleLevel'];
        $oldRoleLevel = $_POST['oldRoleLevel'];

        try{
            $rbac     ->checkRoleFields($roleName, $roleLevel);
            $rbac     ->checkIfUsed($oldRoleLevel);
            $rbac     ->checkEditRoleName($id, $roleName);
            $rbac     ->checkEditRoleLevel($id, $roleLevel);
            $rbac     ->editRole($id, $roleName, $roleLevel);        
            $response = array('Result' => '<button type="button" class="close">&times;</button>
                                           <strong>Success:</strong> Successfully Edited Role!', 
                              'Status' => "alert alert-success alert-dismissable");
            echo json_encode($response);
        }catch (Exception $e){
            $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
            echo json_encode($response);
        }
    }

?>