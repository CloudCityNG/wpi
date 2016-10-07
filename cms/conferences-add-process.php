<?php require('inc-cms-pre-doctype.php'); ?>
<?php
if(isset($_POST['txtSecurity']) && $_POST['txtSecurity'] === $_SESSION['svSecurity'] && $_SERVER['REQUEST_METHOD'] == 'POST') {
  // --------------- USER INPUT VALIDATION -------------------------
  include('inc-fn-sanitize.php');

  $errors = array();

  $vTitle = ucfirst(strtolower(sanitize('txtTitle')));
  $vDetails = ucfirst(sanitize('txtDetails'));
  $vTheme = ucfirst(sanitize('txtTheme'));
  $vEndDate = sanitize('txtEndDate');
  $vStartDate = sanitize('txtStartDate');
  $vCity = ucfirst(strtolower(sanitize('txtCity')));
  $vCountry = ucfirst(strtolower(sanitize('txtCountry')));

  // --------------------- CHECK VALIDATION -----------------------
  if($vTitle && $vDescription) {

    // Connect to mysql server
    require('inc-conn.php');

    // Calls the file where the user defined function escapestring receives its instructions
    require('inc-function-escapestring.php');

    // Connect to mysql server
    require('inc-conn.php');

    // The proper way to insert sql statement (SQL Injection)
    // The first specifier (%s) corresponds to the first escapestring function as so on and so forth
    $sql_insert = sprintf("INSERT INTO tblconferences (etitle, edescription, edate, elocation, etickets, elink, eimg) VALUES (%s, %s, %s, %s, %s, %s, %s)",
      escapestring($vconn_creativeangels, $vTitle, 'text'),
      escapestring($vconn_creativeangels, $vDescription, 'text'),
      escapestring($vconn_creativeangels, $vDate, 'text'),
      escapestring($vconn_creativeangels, $vLocation, 'text'),
      escapestring($vconn_creativeangels, $vTickets, 'text'),
      escapestring($vconn_creativeangels, $vLink, 'text'),
      escapestring($vconn_creativeangels, $vImg_str, 'text')
    );

    // Execute insert statement
    $vinsert_results = mysqli_query($vconn_creativeangels, $sql_insert);

    if($vinsert_results) {

      header('Location: events-display.php');
      exit();

    } else {

      header('Location: signout.php');
      exit();

    }

  } else {

    // Validation failed
    $qs = "?kval=failed";
    $qs .= "&ktitle=".urlencode($vTitle);
    $qs .= "&kdescription=".urlencode($vDescription);
    $qs .= "&kdate=".urlencode($vDate);
    $qs .= "&kimg=".urlencode($vImg_str);

    header('location: events-add-new.php' . $qs);
    exit();
  }


} else {

  // Initial security check failed
  header("Location: signout.php");
  exit();
}
?>
