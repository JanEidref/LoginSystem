<?php
    session_start();
    include 'modules/database/database.php';
    include 'modules/user/class.user.php';
    include 'modules/rbac/class.rbac.php';

    $rbac   = new Rbac();
    $uid    = $_SESSION['uid'];
    $access = $_SESSION['access'];
    $name   = $_SESSION['name'];
    $role   = $_SESSION['role'];
    $editId = $_GET['uid'];
    $data   = $rbac->getAccess($role);

    if(!$uid){
        header('Location: http://localhost/loginsystem/index.php');
        exit();  
    }else if($data['edit_user'] == 0){
        $_SESSION['access'] = 2;
        header('Location: http://localhost/loginsystem/main.php');
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
    <title>Edit Page</title>
</head>
<body>
    <?php
        include 'modules/includes/navbar.php';
    ?>
    
    <div class="container mt-3 border shadow">
        <h2 class="text-center text-secondary mt-2">Edit User</h2>
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="" id="alert">

                </div>
            </div>                    
        </div>
        <?php            
            include 'modules/includes/editUserForm.php';
        ?>
        <div id="undo" class="mt-2 mb-2"><a href="editPage.php" class="undo btn btn block btn-danger" name="undo">Back</a></div>
    </div>    
</body>
<script>

    $(document).ready(function(){

        $('#user').attr("class", "nav-item dropdown active");
        $('#editUser').attr("class", "dropdown-item active");         

        //edit user
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