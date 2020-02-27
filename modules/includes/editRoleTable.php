<?php
 
    $uid = $_SESSION['uid'];

    if(!$uid){

        session_start();
        $_SESSION['access'] = 2;
        header('Location: ../../index.php');
        exit();

    }   

    echo '<table id="dataTable" class="table table-hover">';
    echo '  <thead class="thead-dark">';
    echo '      <tr>';
    echo '          <th class="text-center">Role Name</th>';
    echo '          <th class="text-center">Role Level</th>';
    echo '          <th class="text-center">Action</th>';
    echo '      </tr>';
    echo '  </thead>';
    echo '  <tbody>';

    $number   = 1;
    $rbac     = new Rbac(); 
    $allRoles = $rbac->getAllRoles();

    foreach($allRoles as $data){

        echo '  <tr>';
        echo '      <td class="text-center">'.$data['role_name'].'</td>';
        echo '      <td class="text-center">'.$data['role_level'].'</>';
        echo '      <td class="text-center"><a href="roleData.php?roleId='.$data['id'].'" class="edit btn btn-primary">Edit</a></button>';
        echo '  </tr>';

    }

    echo '  </tbody>';
    echo '</table>'; 
?>