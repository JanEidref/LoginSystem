<?php
    session_start();
    require_once '../database/database.php';
    include '../rbac/class.rbac.php';

    $uid   = $_SESSION['uid'];
    $check = $_POST['roleName'];
    $rbac  = new Rbac();


    if(!$uid){
        header('Location: http://localhost/loginsystem/index.php');
        exit(); 
    }else if(!isset($check)){
        $_SESSION['access'] = 2;
        header('Location: http://localhost/loginsystem/index.php');
        exit();  
    }else{

        $roleName  = $_POST['roleName'];
        $roleLevel = $_POST['roleLevel'];

        try{
            $rbac     ->checkRoleFields($roleName, $roleLevel);
            $rbac     ->checkRoleName($roleName);
            $rbac     ->checkRoleLevel($roleLevel);
            $rbac     ->addRole($roleName, $roleLevel);        
            $response = array('Result' => '<button type="button" class="close">&times;</button>
                                           <strong>Success:</strong> Successfully Added Role!', 
                              'Status' => "alert alert-success");
            echo json_encode($response);
        }catch (Exception $e){
            $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
            echo json_encode($response);
        }
    }

?>