<?php require('inc-cms-pre-doctype.php'); ?>
<?php

  // Security check
  if(isset($_POST['txtSecurity']) && $_POST['txtSecurity'] === $_SESSION['svSecurity'] && isset($_POST['txtId'])) {

    $vId = $_POST['txtId'];

    //Connect to MYSQL Server
    require('inc-conn.php');
    require('inc-function-escapestring.php');

    $sql_delete = sprintf("DELETE FROM tblplays WHERE pid = %u",
    escapestring($vconn_wpi, $vId, 'int')
    );

    //Execute SQL statement
    $delete_result = mysqli_query($vconn_wpi, $sql_delete);

    if($delete_result) {

      echo true;
      exit();

    } else {

      echo false;
      exit();

    }

  } else {
    header('Location: signout.php');
    exit();

  }
?>
