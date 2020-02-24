<?php
    session_start();
    include 'modules/database/database.php';
    include 'modules/user/class.user.php';
    include 'modules/rbac/class.rbac.php';

    $rbac   = new Rbac();
    $uid    = $_SESSION['uid'];
    $name   = $_SESSION['name'];
    $role   = $_SESSION['role'];
    $data   = $rbac->getAccess($role);

    if(!$uid){
        $_SESSION['access'] = 2;
        header('Location: http://localhost/loginsystem/index.php');
        exit();  
    }else if($data['edit_role'] == 0){
        $_SESSION['access'] = 2;
        header('Location: http://localhost/loginsystem/index.php');
        exit(); 
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Edit Role</title>
</head>
<body>
    <?php
        include 'modules/includes/navbar.php';
    ?>    
    <div class="container mt-3 border shadow">
        <h2 class="text-center text-secondary mt-2">All Roles</h2>
        <?php

            echo '<table id="dataTable" class="table table-hover">';
            echo '  <thead class="thead-dark">';
            echo '      <tr>';
            echo '          <th class="text-center">Role Name</th>';
            echo '          <th class="text-center">Role Level</th>';
            echo '          <th class="text-center">Action</th>';
            echo '      </tr>';
            echo '  </thead>';
            echo '  <tbody>';

            $number  = 1;
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
    </div>    
</body>
<script>
    
    $(document).ready(function(){

        $('#rbac').attr("class", "nav-item dropdown active");
        $('#editRole').attr("class", "dropdown-item active");
        
    });

</script>
</html>