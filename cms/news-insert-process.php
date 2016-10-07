<?php require('inc-cms-pre-doctype.php'); ?>
<?php require('inc-fn-img-upload.php'); ?>
<?php
if(isset($_POST['txtSecurity']) && $_POST['txtSecurity'] === $_SESSION['svSecurity']){

include_once('inc-fn-sanitize.php');

//====================== SANITIZATION and VALIDATION =======================
$vHeading = sanitize('txtHeading');
$vSummary= sanitize('txtSummary');
$vStatus = sanitize('txtStatus');
$vDate = sanitize('txtDate');

if(exists('txtBody', 'POST')) {
  $vBody = $_POST['txtBody'];
} else {
  $vBody = false;
}

// ------------------------ UPLOAD IMG -------------------------------------
include('inc-fn-img-upload.php');

// implode the array
$images_str = multi_img_upload('images', '../assets/uploads/news/large/');

if(!$images_str) {
  $images_str = 'na';
}

// ======================= VALIDATION FAILED ===============================
if(!$vHeading || !$vSummary || !$vBody) {

  $qs = '?kval=failed';
  $qs .= '&kheading=' . urlencode($vHeading);
  $qs .= '&ksummary=' . urlencode($vSummary);
  $qs .= '&kbody=' . urlencode($vBody);
  $qs .= '&kdate=' . urlencode($vDate);

  header('location: news-insert.php' . $qs);
  exit();

} else {
  // ====================== VALIDATION PASSED ===============================

  require('inc-conn.php');
  require('inc-function-escapestring.php');

  // insert query
  $sql_insert = sprintf("INSERT INTO tblnews (nheading, nsummary, nbody, ndatepublished, nstatus, nimages) VALUES (%s, %s, %s, %d, %s, %s)",
    escapestring($vconn_creativeangels, $vHeading, 'text'),
    escapestring($vconn_creativeangels, $vSummary, 'text'),
    escapestring($vconn_creativeangels, $vBody, 'text'),
    escapestring($vconn_creativeangels, $vDate, 'date'),
    escapestring($vconn_creativeangels, $vStatus, 'text'),
    escapestring($vconn_creativeangels, $images_str, 'text')
  );

  // Execute insert statement
  $vinsert_results = mysqli_query($vconn_creativeangels, $sql_insert);

  if($vinsert_results) {

    header('Location: news-display.php');
    exit();

  } else {
    header('Location: signout.php');
    exit();

  }

}

} else {

  header('location: signout.php');
  exit();
}
?>
