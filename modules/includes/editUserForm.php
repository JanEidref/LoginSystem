<?php

    $uid = $_SESSION['uid'];

    if(!$uid){

        session_start();
        $_SESSION['access'] = 2;
        header('Location: ../../main.php');
        exit();

    }

    $user = new User();

    $data = $user->getData($editId);

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


?>