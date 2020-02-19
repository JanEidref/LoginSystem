<?php
    session_start();
    include 'modules/user/class.user.php';
    include 'modules/rbac/class.rbac.php';

    $uid    = $_SESSION['uid'];
    $editId = $_GET['uid'];

    $user   = new User($uid);
    $rbac   = new Rbac($uid);
    $role   = $rbac->getUserRoleNumber();
    
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
    <title>Edit Page</title>
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
                    <a class="dropdown-item active" href="#">Edit User</a>
                    <a class="dropdown-item" href="deletePage.php">Delete User</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    Rbac Menu
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="roles.php">View Role</a>
                    <a class="dropdown-item" href="addRolePage.php">Add Role</a>
                    <a class="dropdown-item" href="#">Edit Role</a>
                    <a class="dropdown-item" href="#">Delete Role</a>
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
        <h2 class="text-center text-secondary mt-2">Edit User</h2>
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="" id="alert">

                </div>
            </div>                    
        </div>
        <?php
            
            $edit = new User($editId);
            
            foreach($edit->getData() as $data){
                echo '<form method="POST" id="editUserForm">';
                echo '   <h5 id="editName" class="text-primary text-center"></h5>';
                echo '    <input type="text" id="uid" name="uid" value="'.$editId.'" hidden>';
                echo '    <div class="input-group mb-3">';
                echo '        <div class="input-group-prepend">';
                echo '            <span class="input-group-text">Name</span>';
                echo '        </div>';
                echo '        <input type="text" id="editFirstName" class="form-control" value="'.$data['first_name'].'" name="editFirstName"  placeholder="First Name"  autocomplete="off">';
                echo '        <input type="text" id="editLastName" class="form-control" value="'.$data['last_name'].'"  name="editLastName" placeholder="Last Name" autocomplete="off">';
                echo '    </div>';
                echo '    <div class="input-group mb-3">';
                echo '        <div class="input-group-prepend">';
                echo '            <span class="input-group-text">Username</span>';
                echo '        </div>';
                echo '        <input type="text" id="editUserName" value="'.$data['username'].'"  class="form-control" name="editUserName" autocomplete="off">';
                echo '        <div class="input-group-prepend">';
                echo '            <span class="input-group-text">Password</span>';
                echo '        </div>';
                echo '        <input type="password" id="editPassword" class="form-control" name="newPassword" placeholder="Input only if you want to change password!" autocomplete="off">';
                echo '    </div>';
                echo '    <div class="row">';
                echo '      <div id="selectEdit" class="col-sm-6">';
                echo '          <select class="browser-default custom-select" name="role">';
                echo '              <option value="0" selected>--User Roles--</option>';
                $option = $rbac->getAllRoles();
                foreach($option as $roleData){

                    if($data['role'] == $roleData['role_level']){

                        echo '<option value="'.$roleData['role_level'].'" selected>'.$roleData['role_name'].'</option>';

                    }else{

                        echo '<option value="'.$roleData['role_level'].'">'.$roleData['role_name'].'</option>';

                    }

                }
                echo '          </select>';
                echo '        </div>';
                echo '        <div class="col-sm-6">';
                echo '            <input type="submit" class="btn btn-block btn-dark" id="editSubmit" name="editSubmit" value="Edit">';
                echo '        </div>';        
                echo '    </div>';
                echo '</form>';
            }
        ?>
        <div id="undo" class="mt-2 mb-2"><a href="editPage.php" class="undo btn btn block btn-danger" name="undo">Back</a></div>
    </div>    
</body>
<script>

    $(document).ready(function(){

        //edit user function
        $('#editUserForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                type    : "POST",
                url     : 'modules/user/editUser.php',
                data    : $(this).serialize(),
                success : function(response){
                    var jsonData = JSON.parse(response);
                    $('#alert').html(jsonData.Result);
                    $('#alert').attr("class", jsonData.Status);
                    $("#editUserForm").load(location.href+" #editUserForm>*","");
                }
            });
        });

    });
    
</script>
</html>