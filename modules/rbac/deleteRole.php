<?php
    session_start();
    include 'class.rbac.php';

    $uid  = $_SESSION['uid'];
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

        $roleLevel = $_POST['role'];

        try{
            $rbac     ->checkIfUsed($roleLevel);
            $rbac     ->deleteRole($roleLevel);
            $response = array('Result' => "<strong>Success:</strong> Successfully Deleted Role!", 'Status' => "alert alert-success");
            echo json_encode($response);
        }catch (Exception $e){
            $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
            echo json_encode($response);
        }
    }
    
?>