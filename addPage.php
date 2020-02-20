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
    }else if($role > 2){
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
    <title>Add Page</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-secondary navbar-dark sticky-top">
        <?php
            echo '<a class="navbar-brand" href="profilePage.php">Hello, '.$name.'!</a>'; 

            switch($role){

                case 1:
                    echo '<ul class="navbar-nav text-uppercase">';
                    echo '  <li class="nav-item">';
                    echo '      <a class="nav-link" href="main.php">Home</a>';
                    echo '   </li>';
                    echo '  <li class="nav-item dropdown active">';
                    echo '      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">';
                    echo '          User Menu';
                    echo '      </a>';
                    echo '  <div class="dropdown-menu">';
                    echo '      <a class="dropdown-item active" href="#">Add User</a>';
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
                    echo '      <a class="dropdown-item" href="editRolePage.php">Edit Role</a>';
                    echo '      <a class="dropdown-item" href="deleteRolePage.php">Delete Role</a>';
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
                    echo '  <li class="nav-item">';
                    echo '      <a class="nav-link" href="main.php">Home</a>';
                    echo '   </li>';
                    echo '  <li class="nav-item dropdown active">';
                    echo '      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">';
                    echo '          User Menu';
                    echo '      </a>';
                    echo '  <div class="dropdown-menu">';
                    echo '      <a class="dropdown-item active" href="#">Add User</a>';
                    echo '      <a class="dropdown-item disabled" href="#">Edit User</a>';
                    echo '      <a class="dropdown-item disabled" href="#">Delete User</a>';
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

                default:
                    echo '<ul class="navbar-nav text-uppercase">';
                    echo '  <li class="nav-item">';
                    echo '      <a class="nav-link" href="main.php">Home</a>';
                    echo '   </li>';
                    echo '  <li class="nav-item dropdown active">';
                    echo '      <a class="nav-link dropdown-toggle disabled" href="#" id="navbardrop" data-toggle="dropdown">';
                    echo '          User Menu';
                    echo '      </a>';
                    echo '  <div class="dropdown-menu">';
                    echo '      <a class="dropdown-item active" href="#">Add User</a>';
                    echo '      <a class="dropdown-item" href="#">Edit User</a>';
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
                        <?php
                            $options = $rbac->getAllRoles();
                            if($role > 1){

                                foreach($options as $data){

                                    if($data['role_level'] == 1){

                                        echo '<option value="'.$data['role_level'].'" disabled>'.$data['role_name'].'</option>';

                                    }else{

                                        echo '<option value="'.$data['role_level'].'">'.$data['role_name'].'</option>';

                                    }
    
    
                                }

                            }else{

                                foreach($options as $data){

                                    echo '<option value="'.$data['role_level'].'">'.$data['role_name'].'</option>';    
    
                                }

                            }                            
                        ?>
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

        //add user
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