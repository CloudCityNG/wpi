<?php require('inc-cms-pre-doctype.php'); ?>
<?php
if(isset($_POST['txtSecurity']) && $_POST['txtSecurity'] === $_SESSION['svSecurity'] && $_SERVER['REQUEST_METHOD'] == 'POST') {
  // --------------- USER INPUT VALIDATION -------------------------
  include('inc-fn-sanitize.php');

  $vTitle = ucfirst(strtolower(sanitize('txtTitle')));
  $vAName = ucfirst(sanitize('txtAuthName'));
  $vASurname = ucfirst(sanitize('txtAuthSurname'));
  $vSynopsis = ucfirst(sanitize('txtSynopsis'));
  $vConId = sanitize('txtYear', 'int');


  // --------------------- CHECK VALIDATION -----------------------
  if($vTitle && $vAName && $vASurname) {

    // Connect to mysql server
    require('inc-conn.php');

    // Calls the file where the user defined function escapestring receives its instructions
    require('inc-function-escapestring.php');

    // Connect to mysql server
    require('inc-conn.php');

    // Building query string
    $sql_insert = sprintf("INSERT INTO tblplays (ptitle, cid, pauthorname, pauthorsurname, psynopsis) VALUES (%s, %s, %s, %s, %s)",
      escapestring($vconn_wpi, $vTitle, 'text'),
      escapestring($vconn_wpi, $vConId, 'text'),
      escapestring($vconn_wpi, $vAName, 'text'),
      escapestring($vconn_wpi, $vASurname, 'text'),
      escapestring($vconn_wpi, $vSynopsis, 'text')
    );

    // Execute insert statement
    $vinsert_results = mysqli_query($vconn_wpi, $sql_insert);

    if($vinsert_results) {

      header('Location: plays-display.php');
      exit();

    } else {
      header('Location: signout.php');
      exit();

    }

  } else {

    // Validation failed
    $qs = "?kval=failed";
    $qs .= "&ktitle=".urlencode($vTitle);
    $qs .= "&kaname=".urlencode($vAName);
    $qs .= "&kasurname=".urlencode($vASurname);
    $qs .= "&ksynopsis=".urlencode($vSynopsis);

    header('location: plays-add-new.php' . $qs);
    exit();
  }


} else {
  header("Location: signout.php");
  exit();
}
?>
