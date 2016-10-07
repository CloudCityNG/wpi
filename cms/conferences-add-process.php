<?php require('inc-cms-pre-doctype.php'); ?>
<?php
if(isset($_POST['txtSecurity']) && $_POST['txtSecurity'] === $_SESSION['svSecurity'] && $_SERVER['REQUEST_METHOD'] == 'POST') {
  // --------------- USER INPUT VALIDATION -------------------------
  include('inc-fn-sanitize.php');

  $vTitle = ucfirst(strtolower(sanitize('txtTitle')));
  $vDetails = ucfirst(sanitize('txtDetails'));
  $vTheme = ucfirst(sanitize('txtTheme'));
  $vEndDate = sanitize('txtEndDate');
  $vStartDate = sanitize('txtStartDate');
  $vCity = ucfirst(strtolower(sanitize('txtCity')));
  $vCountry = ucfirst(strtolower(sanitize('txtCountry')));

  // --------------------- CHECK VALIDATION -----------------------
  if($vTitle && $vTheme) {

    // Connect to mysql server
    require('inc-conn.php');

    // Calls the file where the user defined function escapestring receives its instructions
    require('inc-function-escapestring.php');

    // Connect to mysql server
    require('inc-conn.php');

    // The proper way to insert sql statement (SQL Injection)
    // The first specifier (%s) corresponds to the first escapestring function as so on and so forth
    $sql_insert = sprintf("INSERT INTO tblconferences (ctitle, cdetails, ctheme, cenddate, cstartdate, ccity, ccountry) VALUES (%s, %s, %s, %s, %s, %s, %s)",
      escapestring($vconn_wpi, $vTitle, 'text'),
      escapestring($vconn_wpi, $vDetails, 'text'),
      escapestring($vconn_wpi, $vTheme, 'text'),
      escapestring($vconn_wpi, $vEndDate, 'text'),
      escapestring($vconn_wpi, $vStartDate, 'text'),
      escapestring($vconn_wpi, $vCity, 'text'),
      escapestring($vconn_wpi, $vCountry, 'text')
    );
    echo $sql_insert;
    // Execute insert statement
    $vinsert_results = mysqli_query($vconn_wpi, $sql_insert);

    if($vinsert_results) {

      header('Location: conferences-display.php');
      exit();

    } else {
      echo 'db';
      //header('Location: signout.php');
      exit();

    }

  } else {

    // Validation failed
    $qs = "?kval=failed";
    $qs .= "&ktitle=".urlencode($vTitle);
    $qs .= "&kdetails=".urlencode($vDetails);
    $qs .= "&ktheme=".urlencode($vTheme);
    $qs .= "&kenddate=".urlencode($vEndDate);
    $qs .= "&kstartdate=".urlencode($vStartDate);
    $qs .= "&kcity=".urlencode($vCity);
    $qs .= "&kcountry=".urlencode($vCountry);

    header('location: conferences-add-new.php' . $qs);
    exit();
  }


} else {
  echo 'Token';
  // Initial security check failed
  //header("Location: signout.php");
  exit();
}
?>
