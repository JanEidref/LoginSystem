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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Delete Page</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-secondary navbar-dark sticky-top">
        <?php
            echo '<a class="navbar-brand" href="profilePage.php">Hello, '.$name.'!</a>'; 
        ?> 
        <ul class="navbar-nav text-uppercase">
            <li class="nav-item">
                <a class="nav-link" href="main.php">Home</a>
            </li>
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    User Menu
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="addPage.php">Add User</a>
                    <a class="dropdown-item" href="editPage.php">Edit User</a>
                    <a class="dropdown-item active" href="#">Delete User</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    Rbac Menu
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="roles.php">View Role</a>
                    <a class="dropdown-item" href="addRolePage.php">Add Role</a>
                    <a class="dropdown-item" href="editRolePage.php">Edit Role</a>
                    <a class="dropdown-item" href="deleteRolePage.php">Delete Role</a>
                </div>
             </li>
        </ul>
        <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
        <a href="modules/login/logout.php" class="btn btn-dark">Logout</a>
        </li>
        </ul>
    </nav>
    
    <div class="container mt-3 border shadow">
        <h2 class="text-center text-secondary mt-2">Delete User</h2>
        <div class="row">
            <div class="col-sm-12">
                <div class="" id="status">

                </div>  
            </div>
        </div>        
        <?php
            echo '<table id="dataTable" class="table table-hover mt-2">';
            echo '  <thead class="thead-dark">';
            echo '      <tr>';
            echo '          <th class="text-center"></th>';
            echo '          <th class="text-center">Username</th>';
            echo '          <th class="text-center">Full Name</th>';
            echo '          <th class="text-center">Role</th>';
            echo '          <th class="text-center">Delete</th>';
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
                    echo '      <td class="text-center"><button class="delete btn btn-danger" value="'.$data['uid'].'" name="delete">Delete</button></>';
                    echo '  </tr>';

                    $number++;

                }

            }

            echo '  </tbody>';
            echo '</table>';
        ?>
    </div> 
    </div>    
</body>
<script>
    $(document).ready(function(){

        //delete user
        $(document).on("click", ".delete", function(){

            if (confirm("Are you sure you want to delete user?")) {
                $.ajax({
                    type     : "POST",
                    url      : 'modules/user/deleteUser.php',
                    data     : {id:$(this).val()},
                    success  : function(response){
                        $('#status').html(response);
                        $('#status').attr("class", "alert alert-success");
                        $("#dataTable").load(location.href+" #dataTable>*","");
                    }
                });
            }
            return false;            

        });

    });
</script>
</html>