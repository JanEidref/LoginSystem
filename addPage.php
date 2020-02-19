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
    <title>Add Page</title>
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
            <li class="nav-item active">
                <a class="nav-link" href="#">Add User</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="editPage.php">Edit User</a>
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
        <h2 class="text-center text-secondary mt-2">Add User</h2>
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="" id="alert">

                </div>
            </div>                    
        </div>
        <form class="mb-4" method="POST" id="addUserForm">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Username</span>
                </div>
                <input type="text" id="userName" class="form-control" name="userName" autocomplete="off">
                <div class="input-group-prepend">
                    <span class="input-group-text">Password</span>
                </div>
                <input type="password" id="password" class="form-control" name="password" autocomplete="off">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Name</span>
                </div>
                <input type="text" id="firstName" class="form-control" name="firstName"  placeholder="First Name"  autocomplete="off">
                <input type="text" id="lastName" class="form-control" name="lastName" placeholder="Last Name" autocomplete="off">
            </div>
            <div class="row">
                <div id="selectAdd" class="col-sm-6">
                    <select class="browser-default custom-select" name="role">
                        <option value="0" selected>--User Roles--</option>
                        <option value="1">Admin</option>
                        <option value="2">Guest</option>
                    </select> 
                </div>
                <div class="col-sm-6">
                    <input type="submit" class="btn btn-block btn-dark" id="submit" name="submit" value="Add">
                </div>                        
            </div>
        </form>
    </div>    
</body>
<script>

    $(document).ready(function(){

        //add user function
        $('#addUserForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                type    : "POST",
                url     : 'modules/user/addUser.php',
                data    : $(this).serialize(),
                success : function(response){
                    var jsonData = JSON.parse(response);
                    $('#alert').html(jsonData.Result);
                    $('#alert').attr("class", jsonData.Status);
                    $("#addUserForm").load(location.href+" #addUserForm>*","");
                }
            });
        });

    });

</script>
</html>