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
    }else if($data['edit_role'] == 0){
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
    <title>Edit Role</title>
</head>
<body>
    <?php
        include 'modules/includes/navbar.php';
    ?>    
    <div class="container mt-3 border shadow">
        <h2 class="text-center text-secondary mt-2">All Roles</h2>
        <?php
            include 'modules/includes/editRoleTable.php';
        ?>
    </div>    
</body>
<script>
    
    $(document).ready(function(){

        $('#rbac').attr("class", "nav-item dropdown active");
        $('#editRole').attr("class", "dropdown-item active");
        
    });

</script>
</html>