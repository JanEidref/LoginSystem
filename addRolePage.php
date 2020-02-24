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
    }else if($data['add_role'] == 0){
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
    <title>Add Role</title>
</head>
<body>
    <?php
        include 'modules/includes/navbar.php';
    ?>    
    <div class="container mt-3 border shadow">
        <h2 class="text-center text-secondary mt-2">Add Role</h2>
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="" id="alert">

                </div>
            </div>                    
        </div>
        <form class="mb-4" method="POST" id="addRoleForm">
            <div class="row">
                <div class="input-group mb-3 col-sm-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Role Name</span>
                    </div>
                    <input type="text" id="roleName" class="form-control" name="roleName" autocomplete="off">
                </div>
                <div class="input-group mb-3 col-sm-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Role Level</span>
                    </div>
                    <input type="number" min=1 id="roleLevel" class="form-control" name="roleLevel" autocomplete="off">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input type="submit" class="btn btn-block btn-dark" id="submit" name="submit" value="Add">
                </div>                        
            </div>
        </form>
    </div>    
</body>
<script>

    $(document).ready(function(){

        $('#rbac').attr("class", "nav-item dropdown active");
        $('#addRole').attr("class", "dropdown-item active");

        //add role
        $('#addRoleForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                type    : "POST",
                url     : 'modules/rbac/addRole.php',
                data    : $(this).serialize(),
                success : function(response){
                    var jsonData = JSON.parse(response);
                    $('#alert').show();
                    $('#alert').html(jsonData.Result);
                    $('#alert').attr("class", jsonData.Status);
                    $("#addRoleForm").load(location.href+" #addRoleForm>*","");
                }
            });
        });

        $(document).on("click", ".close", function(){

            $('#alert').hide();

        }); 

    });

</script>
</html>