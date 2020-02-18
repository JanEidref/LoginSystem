<?php
    session_start();
    include 'modules/user/class.user.php';

    $uid = $_SESSION['uid'];

    if(!isset($uid)){
        header('Location: index.php');
        exit();
    }else{
        $user = new User($uid);
        $role = $user->getUserRoleNumber();
        $name = $user->getUsersName();
    }

    if($role > 1){
        $_SESSION['access'] = 2;
        header('Location: main.php');
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
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Delete Page</title>
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
            <li class="nav-item">
                <a class="nav-link" href="editPage.php">Edit User</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Delete</a>
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

            $number = 1;

            foreach($user->getAllFromUser() as $data){

                if($uid <> $data['uid']){

                    $id = new User($data['uid']);

                    echo '  <tr>';
                    echo '      <td class="text-center">'.$number.'</td>';
                    echo '      <td class="text-center">'.$data['username'].'</td>';
                    echo '      <td class="text-center">'.$id->getUsersName().'</td>';
                    echo '      <td class="text-center">'.$id->getUserRole().'</>';
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

        $(document).on("click", ".delete", function(){

            if (confirm("Are you sure?")) {
                $.ajax({
                    type     : "POST",
                    url      : 'modules/user/deleteUser.php',
                    data     : {id:$(this).val()},
                    success  : function(response){
                        $('#status').html(response);
                        $('#status').attr("class", "alert alert-success");
                        $("#dataTable")   .load(location.href+" #dataTable>*","");
                    }
                });
            }
            return false;            

        });

    });
</script>
</html>