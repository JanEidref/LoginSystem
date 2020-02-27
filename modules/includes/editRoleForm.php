<?php

    $uid    = $_SESSION['uid'];
    $editId = $_GET['roleId'];

    if(!$uid){

        session_start();
        $_SESSION['access'] = 2;
        header('Location: ../../index.php');
        exit();

    }
    
    $rbac = new Rbac();
    $data = $rbac -> getRoleData($editId);

    echo '<form class="mb-4" method="POST" id="editRoleForm">';
    echo '    <div class="row">';
    echo '        <input type="text" value="'.$data['id'].'" name="roleId" hidden>';
    echo '        <input type="text" value="'.$data['role_level'].'" name="oldRoleLevel" hidden>';
    echo '        <div class="input-group mb-3 col-sm-6">';
    echo '            <div class="input-group-prepend">';
    echo '                <span class="input-group-text">Role Name</span>';
    echo '            </div>';
    echo '            <input type="text" id="roleName" class="form-control" name="editRoleName" value="'.$data['role_name'].'" autocomplete="off">';
    echo '        </div>';
    echo '        <div class="input-group mb-3 col-sm-6">';
    echo '           <div class="input-group-prepend">';
    echo '                <span class="input-group-text">Role Level</span>';
    echo '            </div>';
    echo '            <input type="number" min=1 id="roleLevel" class="form-control" name="editRoleLevel" value="'.$data['role_level'].'" autocomplete="off">';
    echo '        </div>';
    echo '    </div>';
    echo '    <div class="row">';
    echo '        <div class="col-sm-12">';
    echo '            <input type="submit" class="btn btn-block btn-dark" id="submit" name="submit" value="Save">';
    echo '        </div>';                        
    echo '   </div>';
    echo '</form>';



?>