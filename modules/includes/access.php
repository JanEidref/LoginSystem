<?php

    $uid = $_SESSION['uid'];

    if(!$uid){

        session_start();
        $_SESSION['access'] = 2;
        header('Location: ../../main.php');
        exit();

    }

    $access = $_SESSION['access'];

    if($access > 1){
        echo '<div class="row">';
        echo '    <div class="col-sm-12">';
        echo '        <div class="alert alert-danger" id="addStatus">';
        echo '              <strong>Error:</strong> Access Denied!';
        echo '        </div>';  
        echo '    </div>';
        echo '</div>';
    }

?>