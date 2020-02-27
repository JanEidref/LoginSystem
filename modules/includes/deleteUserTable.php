<?php

    $uid = $_SESSION['uid'];

    if(!$uid){

        session_start();
        $_SESSION['access'] = 2;
        header('Location: ../../index.php');
        exit();

    }

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

    $number  = 1;
    $user    = new User();
    $allUser = $user->getAllData();

    foreach($allUser as $data){

        if($uid <> $data['uid']){

            $fullName   = $data['first_name']." ".$data['last_name'];

            echo '  <tr>';
            echo '      <td class="text-center">'.$number.'</td>';
            echo '      <td class="text-center">'.$data['username'].'</td>';
            echo '      <td class="text-center">'.$fullName.'</td>';
            echo '      <td class="text-center">'.$data['role_name'].'</>';
            echo '      <td class="text-center"><button class="delete btn btn-danger" value="'.$data['uid'].'" name="delete">Delete</button></>';
            echo '  </tr>';

            $number++;

        }

    }

    echo '  </tbody>';
    echo '</table>';

?>