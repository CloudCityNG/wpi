<?php require('inc-cms-pre-doctype.php'); ?>
<?php
if(isset($_POST['txtSecurity']) && $_POST['txtSecurity'] === $_SESSION['svSecurity'] && $_SERVER['REQUEST_METHOD'] == 'POST') {

  $error = array();

  // --------------- USER INPUT VALIDATION -------------------------
  include('inc-fn-sanitize.php');

  $vConId = sanitize('txtYear', 'int');

  // ------------------------ IMAGE UPLOAD --------------------------
  include('inc-fn-img-upload.php');

  $vImg = multi_img_upload('txtImg', '../assets/uploads/galleries/large/');

  // ---------------------- CHECK VALIDATION -----------------------
  if($vConId && $vImg) {

    // Connect to mysql server
    require('inc-conn.php');

    // Calls the file where the user defined function escapestring receives its instructions
    require('inc-function-escapestring.php');

    // Connect to mysql server
    require('inc-conn.php');

    // convert string to array
    $vNewImg_arr = explode(', ', $vImg);

    // foreach value in image array insert into database
    foreach($vNewImg_arr as $value) {

      // Building query string
      $sql_insert = sprintf("INSERT INTO tblphotos (guri, cid) VALUES (%s, %u)",
        escapestring($vconn_wpi, $value, 'text'),
        escapestring($vconn_wpi, $vConId, 'int')
      );

      // Execute insert statement
      $vinsert_results = mysqli_query($vconn_wpi, $sql_insert);

    } // end of foreach


    if($vinsert_results) {

      header('Location: galleries-display.php');
      exit();

    } else {

      echo 'db';
      // header('Location: signout.php');
      exit();

    }

  } else {

    $perror = implode(', ', $error);
    
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
