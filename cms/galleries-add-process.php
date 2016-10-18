<?php require('inc-cms-pre-doctype.php'); ?>
<?php
if(isset($_POST['txtSecurity']) && $_POST['txtSecurity'] === $_SESSION['svSecurity'] && $_SERVER['REQUEST_METHOD'] == 'POST') {
  // --------------- USER INPUT VALIDATION -------------------------
  include('inc-fn-sanitize.php');

  $vTitle = ucfirst(strtolower(sanitize('txtTitle')));
  $vConId = sanitize('txtYear', 'int');

  // ---------------------- CHECK VALIDATION -----------------------
  if($vTitle && $vConId) {

    // Connect to mysql server
    require('inc-conn.php');

    // Calls the file where the user defined function escapestring receives its instructions
    require('inc-function-escapestring.php');

    // Connect to mysql server
    require('inc-conn.php');

    // Building query string
    $sql_insert = sprintf("INSERT INTO tblphotos (gtitle, cid) VALUES (%s, %u)",
      escapestring($vconn_wpi, $vTitle, 'text'),
      escapestring($vconn_wpi, $vConId, 'int')
    );

    // Execute insert statement
    $vinsert_results = mysqli_query($vconn_wpi, $sql_insert);

    if($vinsert_results) {
      $qs = mysqli_insert_id($vconn_wpi);
      die($qs);
      header('Location: galleries-upload.php?');
      exit();

    } else {
      echo 'db';
      // header('Location: signout.php');
      exit();

    }

  } else {

    // Validation failed
    $qs = "?kval=failed";
    $qs .= "&ktitle=".urlencode($vTitle);

    header('location: galleries-add-new.php' . $qs);
    exit();
  }


} else {

  echo 'token';
  //header("Location: signout.php");
  exit();
}
?>
