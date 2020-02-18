<?php
    session_start();
    include 'modules/user/class.user.php';
    include 'modules/rbac/class.rbac.php';

    $uid    = $_SESSION['uid'];
    $access = $_SESSION['access'];

    $user = new User($uid);
    $rbac = new Rbac($uid);
    $rbac ->checkSession();
    $role = $rbac->getUserRoleNumber();
    $name = $user->getUsersName();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Main Page</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-secondary navbar-dark sticky-top">
        <?php
            echo '<a class="navbar-brand" href="#">Hello, '.$name.'!</a>';
            
            if($role > 1){
                echo '<ul class="navbar-nav text-uppercase">';
                echo '  <li class="nav-item active">';
                echo '      <a class="nav-link" href="#">Home</a>';
                echo '    </li>';
                echo '    <li class="nav-item">';
                echo '        <a class="nav-link disabled" href="addPage.php">Add User</a>';
                echo '    </li>';
                echo '    <li class="nav-item">';
                echo '        <a class="nav-link disabled" href="editPage.php">Edit User</a>';
                echo '    </li>';
                echo '    <li class="nav-item">';
                echo '        <a class="nav-link disabled" href="deletePage.php">Delete</a>';
                echo '    </li>';
                echo '</ul>';
                echo '<ul class="navbar-nav ml-auto">';
                echo '    <li class="nav-item active">';
                echo '        <a href="modules/login/logout.php" class="btn btn-dark">Logout</a>';
                echo '    </li>';
                echo '</ul>';
            }else{
                echo '<ul class="navbar-nav text-uppercase">';
                echo '  <li class="nav-item active">';
                echo '      <a class="nav-link" href="#">Home</a>';
                echo '    </li>';
                echo '    <li class="nav-item">';
                echo '        <a class="nav-link" href="addPage.php">Add User</a>';
                echo '    </li>';
                echo '    <li class="nav-item">';
                echo '        <a class="nav-link" href="editPage.php">Edit User</a>';
                echo '    </li>';
                echo '    <li class="nav-item">';
                echo '        <a class="nav-link" href="deletePage.php">Delete</a>';
                echo '    </li>';
                echo '</ul>';
                echo '<ul class="navbar-nav ml-auto">';
                echo '    <li class="nav-item active">';
                echo '        <a href="modules/login/logout.php" class="btn btn-dark">Logout</a>';
                echo '    </li>';
                echo '</ul>';
            }
        ?> 

    </nav>
    
    <div class="container mt-3 border shadow">
        <h2 class="text-center text-secondary mt-2">All Users</h2>
        <?php

            if($access > 1){
                echo '<div class="row">';
                echo '    <div class="col-sm-12">';
                echo '        <div class="alert alert-danger" id="addStatus">';
                echo '              <strong>Error:</strong> Access Denied!';
                echo '        </div>';  
                echo '    </div>';
                echo '</div>';
            }

            echo '<table id="dataTable" class="table table-hover mt-2">';
            echo '  <thead class="thead-dark">';
            echo '      <tr>';
            echo '          <th class="text-center"></th>';
            echo '          <th class="text-center">Username</th>';
            echo '          <th class="text-center">Full Name</th>';
            echo '          <th class="text-center">Role</th>';
            echo '      </tr>';
            echo '  </thead>';
            echo '  <tbody>';

            $number = 1;

            foreach($user->getAllFromUser() as $data){

                if($uid <> $data['uid']){

                    $id = new User($data['uid']);

                    echo '  <tr>';
                    echo '      <td class="text-center">'.$number.'</td>';
                    echo '      <td class="text-center">'.$data['username'].'</td>';
                    echo '      <td class="text-center">'.$id->getUsersName().'</td>';
                    echo '      <td class="text-center">'.$id->getUserRole().'</>';
                    echo '  </tr>';

                    $number++;

                }

            }

            echo '  </tbody>';
            echo '</table>';
        ?>
    </div>    
</body>
</html>