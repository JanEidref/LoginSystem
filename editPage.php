<?php
    session_start();
    include 'modules/user/class.user.php';
    include 'modules/rbac/class.rbac.php';

    $uid = $_SESSION['uid'];

    $user = new User($uid);
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
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Edit Page</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-secondary navbar-dark sticky-top">
        <?php
            echo '<a class="navbar-brand" href="#">Hello, '.$name.'!</a>'; 
        ?> 
        <ul class="navbar-nav text-uppercase">
            <li class="nav-item">
                <a class="nav-link" href="main.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="addPage.php">Add User</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Edit User</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="deletePage.php">Delete</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a href="modules/login/logout.php" class="btn btn-dark">Logout</a>
            </li>
        </ul>
    </nav>
    
    <div class="container mt-3 border shadow">
        <h2 class="text-center text-secondary mt-2">Edit User</h2>
        <?php

            echo '<table id="dataTable" class="table table-hover">';
            echo '  <thead class="thead-dark">';
            echo '      <tr>';
            echo '          <th class="text-center"></th>';
            echo '          <th class="text-center">Username</th>';
            echo '          <th class="text-center">Full Name</th>';
            echo '          <th class="text-center">Role</th>';
            echo '          <th class="text-center">Action</th>';
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
                    echo '      <td class="text-center"><a href="userData.php?uid='.$data['uid'].'" class="btn btn-primary">Edit</a></>';
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