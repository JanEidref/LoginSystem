<?php

    $uid = $_SESSION['uid'];

    if(!$uid){

        session_start();
        $_SESSION['access'] = 2;
        header('Location: ../../main.php');
        exit();

    }

    $rbac = new Rbac();
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    $data = $rbac->getAccess($role);

    echo '<nav class="navbar navbar-expand-sm bg-secondary navbar-dark sticky-top">';            
    echo '<a class="navbar-brand" href="profilePage.php">Hello, '.$name.'!</a>';
    echo '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">';
    echo '<span class="navbar-toggler-icon"></span>';
    echo '</button>';
    echo '<div class="collapse navbar-collapse" id="navbarNavDropdown">';
    echo '<ul class="navbar-nav text-uppercase">';
    echo '  <li class="nav-item" id="home">';
    echo '      <a class="nav-link" href="main.php">Home</a>';
    echo '   </li>';
    echo '  <li class="nav-item dropdown" id="user">';
    echo '      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">';
    echo '          User Menu';
    echo '      </a>';
    echo '  <div class="dropdown-menu">';

    if($data['add_user'] == 1){
        echo '      <a class="dropdown-item" href="addPage.php" id="addUser">Add User</a>';
    }else{
        echo '      <a class="dropdown-item disabled" href="addPage.php" id="addUser">Add User</a>';
    }

    if($data['edit_user'] == 1){
        echo '      <a class="dropdown-item" href="editPage.php" id="editUser">Edit User</a>';
    }else{
        echo '      <a class="dropdown-item disabled" href="editPage.php" id="editUser">Edit User</a>';
    } 

    if($data['delete_user'] == 1){
        echo '      <a class="dropdown-item" href="deletePage.php" id="deleteUser">Delete User</a>';
    }else{
        echo '      <a class="dropdown-item disabled" href="deletePage.php" id="deleteUser">Delete User</a>';
    }  

    echo '  </div>';
    echo '  </li>';
    echo '  <li class="nav-item dropdown" id="rbac">';
    echo '      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">';
    echo '          Rbac Menu';
    echo '      </a>';
    echo '  <div class="dropdown-menu">';    

    if($data['add_role'] == 1){
        echo '      <a class="dropdown-item" href="roles.php" id="role">View Role</a>';
    }else{
        echo '      <a class="dropdown-item disabled" href="roles.php" id="role">View Role</a>';
    }

    if($data['add_role'] == 1){
        echo '      <a class="dropdown-item" href="addRolePage.php" id="addRole">Add Role</a>';
    }else{
        echo '      <a class="dropdown-item disabled" href="addRolePage.php" id="addRole">Add Role</a>';
    }

    if($data['edit_role'] == 1){
        echo '      <a class="dropdown-item" href="editRolePage.php" id="editRole">Edit Role</a>';
    }else{
        echo '      <a class="dropdown-item disabled" href="editRolePage.php" id="editRole">Edit Role</a>';
    } 

    if($data['delete_role'] == 1){
        echo '      <a class="dropdown-item" href="deleteRolePage.php" id="deleteRole">Delete Role</a>';
    }else{
        echo '      <a class="dropdown-item disabled" href="deleteRolePage.php" id="deleteRole">Delete Role</a>';
    } 

    echo '  </div>';
    echo '  </li>';
    echo '</ul>';
    echo '<ul class="navbar-nav ml-auto">';
    echo '    <li class="nav-item active">';
    echo '        <a href="modules/login/logout.php" class="btn btn-dark">Logout</a>';
    echo '    </li>';
    echo '</ul>';
    echo '</div>';
    echo '</nav>';

?> 

