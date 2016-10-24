<?php require('inc-cms-pre-doctype.php'); ?>
<?php
if(isset($_POST['txtSecurity']) && $_POST['txtSecurity'] === $_SESSION['svSecurity'] && $_SERVER['REQUEST_METHOD'] == 'POST') {

  $error = array();

  // --------------- USER INPUT VALIDATION -------------------------
  include('inc-fn-sanitize.php');

  $vId = sanitize('txtId', 'int');
  $vCaption = sanitize('txtCaption');
  $vDescription = sanitize('txtDescription');


  // ---------------------- CHECK VALIDATION -----------------------
  if($vCaption && $vDescription ) {

    // Connect to mysql server
    require('inc-conn.php');

    // Calls the file where the user defined function escapestring receives its instructions
    require('inc-function-escapestring.php');

    // Connect to mysql server
    require('inc-conn.php');

      // Building query string
      $sql_update = sprintf("UPDATE tblphotos SET gcaption = %s, gdescription = %s WHERE gid = $vId",
        escapestring($vconn_wpi, $vCaption, 'text'),
        escapestring($vconn_wpi, $vDescription, 'text')
      );

      // Execute insert statement
      $vinsert_results = mysqli_query($vconn_wpi, $sql_update);


    if($vinsert_results) {

      header('Location: galleries-display.php');
      exit();

    } else {

      echo 'db';
      // header('Location: signout.php');
      exit();

    }

  } else {

    // Validation failed
    $qs = "?kval=failed";
    $qs .= "&kerrors=".urlencode($perror);

    header('location: galleries-add-new.php' . $qs);
    exit();
  }


} else {

  echo 'token';
  //header("Location: signout.php");
  exit();
}
?>
