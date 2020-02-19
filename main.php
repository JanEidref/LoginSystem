<?php
    session_start();
    include 'modules/user/class.user.php';
    include 'modules/rbac/class.rbac.php';

    $uid    = $_SESSION['uid'];
    $access = $_SESSION['access'];

    $user = new User($uid);
    $rbac = new Rbac($uid);

    if(!$uid){
        header('Location: http://localhost/loginsystem/index.php');
        exit();  
    }else{
        $role = $rbac->getUserRoleNumber();
        $name = $user->getUsersName();
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
    <title>Main Page</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-secondary navbar-dark sticky-top">
        <?php
            echo '<a class="navbar-brand" href="profilePage.php">Hello, '.$name.'!</a>';
            
            switch($role){

                case 1:
                    echo '<ul class="navbar-nav text-uppercase">';
                    echo '  <li class="nav-item active">';
                    echo '      <a class="nav-link" href="#">Home</a>';
                    echo '   </li>';
                    echo '  <li class="nav-item dropdown">';
                    echo '      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">';
                    echo '          User Menu';
                    echo '      </a>';
                    echo '  <div class="dropdown-menu">';
                    echo '      <a class="dropdown-item" href="addPage.php">Add User</a>';
                    echo '      <a class="dropdown-item" href="editPage.php">Edit User</a>';
                    echo '      <a class="dropdown-item" href="deletePage.php">Delete User</a>';
                    echo '  </div>';
                    echo '  </li>';
                    echo '  <li class="nav-item dropdown">';
                    echo '      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">';
                    echo '          Rbac Menu';
                    echo '      </a>';
                    echo '  <div class="dropdown-menu">';
                    echo '      <a class="dropdown-item" href="roles.php">View Role</a>';
                    echo '      <a class="dropdown-item" href="addRolePage.php">Add Role</a>';
                    echo '      <a class="dropdown-item" href="#">Edit Role</a>';
                    echo '      <a class="dropdown-item" href="#">Delete Role</a>';
                    echo '  </div>';
                    echo '  </li>';
                    echo '</ul>';
                    echo '<ul class="navbar-nav ml-auto">';
                    echo '    <li class="nav-item active">';
                    echo '        <a href="modules/login/logout.php" class="btn btn-dark">Logout</a>';
                    echo '    </li>';
                    echo '</ul>';
                    break;

                case 2:
                    echo '<ul class="navbar-nav text-uppercase">';
                    echo '  <li class="nav-item active">';
                    echo '      <a class="nav-link" href="#">Home</a>';
                    echo '   </li>';
                    echo '  <li class="nav-item dropdown">';
                    echo '      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">';
                    echo '          User Menu';
                    echo '      </a>';
                    echo '  <div class="dropdown-menu">';
                    echo '      <a class="dropdown-item" href="addPage.php">Add User</a>';
                    echo '      <a class="dropdown-item disabled" href="editPage.php">Edit User</a>';
                    echo '      <a class="dropdown-item disabled" href="deletePage.php">Delete User</a>';
                    echo '  </div>';
                    echo '  </li>';
                    echo '  <li class="nav-item dropdown">';
                    echo '      <a class="nav-link dropdown-toggle disabled" href="#" id="navbardrop" data-toggle="dropdown">';
                    echo '          Rbac Menu';
                    echo '      </a>';
                    echo '  <div class="dropdown-menu">';
                    echo '      <a class="dropdown-item" href="#">View Role</a>';
                    echo '      <a class="dropdown-item" href="#">Add Role</a>';
                    echo '      <a class="dropdown-item" href="#">Edit Role</a>';
                    echo '      <a class="dropdown-item" href="#">Delete Role</a>';
                    echo '  </div>';
                    echo '  </li>';
                    echo '</ul>';;
                    echo '<ul class="navbar-nav ml-auto">';
                    echo '    <li class="nav-item active">';
                    echo '        <a href="modules/login/logout.php" class="btn btn-dark">Logout</a>';
                    echo '    </li>';
                    echo '</ul>';
                    break;

                default:
                    echo '<ul class="navbar-nav text-uppercase">';
                    echo '  <li class="nav-item active">';
                    echo '      <a class="nav-link" href="#">Home</a>';
                    echo '   </li>';
                    echo '  <li class="nav-item dropdown">';
                    echo '      <a class="nav-link dropdown-toggle disabled" href="#" id="navbardrop" data-toggle="dropdown">';
                    echo '          User Menu';
                    echo '      </a>';
                    echo '  <div class="dropdown-menu">';
                    echo '      <a class="dropdown-item" href="addPage.php">Add User</a>';
                    echo '      <a class="dropdown-item" href="editPage.php">Edit User</a>';
                    echo '      <a class="dropdown-item" href="deletePage.php">Delete User</a>';
                    echo '  </div>';
                    echo '  </li>';
                    echo '  <li class="nav-item dropdown">';
                    echo '      <a class="nav-link dropdown-toggle disabled" href="#" id="navbardrop" data-toggle="dropdown">';
                    echo '          Rbac Menu';
                    echo '      </a>';
                    echo '  <div class="dropdown-menu">';
                    echo '      <a class="dropdown-item" href="#">View Role</a>';
                    echo '      <a class="dropdown-item" href="#">Add Role</a>';
                    echo '      <a class="dropdown-item" href="#">Edit Role</a>';
                    echo '      <a class="dropdown-item" href="#">Delete Role</a>';
                    echo '  </div>';
                    echo '  </li>';
                    echo '</ul>';
                    echo '<ul class="navbar-nav ml-auto">';
                    echo '    <li class="nav-item active">';
                    echo '        <a href="modules/login/logout.php" class="btn btn-dark">Logout</a>';
                    echo '    </li>';
                    echo '</ul>';
                    break;

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

            $number  = 1;
            $allUser = $user->getAllData();

            foreach($allUser as $data){

                if($uid <> $data['uid']){

                    $fullName   = $data['first_name']." ".$data['last_name'];

                    echo '  <tr>';
                    echo '      <td class="text-center">'.$number.'</td>';
                    echo '      <td class="text-center">'.$data['username'].'</td>';
                    echo '      <td class="text-center">'.$fullName.'</td>';
                    echo '      <td class="text-center">'.$data['role_name'].'</>';
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