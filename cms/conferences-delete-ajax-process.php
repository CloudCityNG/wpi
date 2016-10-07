<?php require('inc-cms-pre-doctype.php'); ?>
<?php

  // Security check
  if(isset($_POST['txtSecurity']) && $_POST['txtSecurity'] === $_SESSION['svSecurity'] && isset($_POST['txtId'])) {

    $vId = $_POST['txtId'];

    //Connect to MYSQL Server
    require('inc-conn.php');
    require('inc-function-escapestring.php');

    $sql_delete = sprintf("DELETE FROM tblconferences WHERE eid = %u",
    escapestring($vconn_wpi, $vId, 'int')
    );

    //Execute SQL statement
    $delete_result = mysqli_query($vconn_wpi, $sql_delete);

    if($delete_result) {

      echo "record deleted";
      exit();

    } else {

      echo 'Record could not be deleted';
      exit();

    }

  } else {
    header('Location: signout.php');
    exit();

  }
?>
