<?php require('inc-cms-pre-doctype.php'); ?>
<?php
$_SESSION['svSecurity'] = sha1(date('YmdHis'));
?>
<?php
//  GETTING YEAR FROM DB
require('inc-conn.php');

// Calls the file where the user defined function escapestring receives its instructions
require('inc-function-escapestring.php');

$sql_year = "SELECT cyear, cid FROM tblconferences";

$rs_year = mysqli_query($vconn_wpi, $sql_year);

$year_rs_rows = mysqli_fetch_assoc($rs_year);

// Function for printing out error messages
function errorMsg($keyName, $label) {

  // PHP checks whether certain keys have been returned with values in the GET Global Super Array, if it has then echo the value into the input field
  if(isset($_GET[$keyName]) && $_GET[$keyName] === '') {

    return "<div class='warning_msg'>Please enter " . $label . ".</div>";

  } //end if statement

} // End of function errorMsg

// Displays values already entered in for input field
function displayTxt($keyValue){

  if(isset($_GET[$keyValue]) && $_GET[$keyValue] !== '') {

    return $_GET[$keyValue];

  } //End if statement

} // End of function displayTxt

?>
<!DOCTYPE html>
<html>
  <head>
    <!-- Head contents -->
    <?php require('inc-cms-head-content.php'); ?>

  </head>
  <body>
    <!-- PAGE WRAPPER -->
    <div id="page-wrapper">

      <!-- SIDEBAR MAIN MENU -->
      <?php require('inc-cms-sidebar.php'); ?>

        <!-- RIGHT COLUMN MAIN CONTENT CONTAINER -->
      <section class="right-content-wrapper">

        <!-- HEADER -->
        <header class="base">

          <!-- Branding container -->
          <?php require('inc-cms-branding-container.php'); ?>

          <!-- Page title -->
          <div class="page-header">
            <h2>Create Gallery | 1 of 2</h2>
          </div>

        </header>

        <!-- MAIN CONTENT SECTION -->
        <section id="main-content" class="base">

          <!--#################### ADD NEW FORM #########################-->

          <form id="form" class="form" action="galleries-add-process.php" method="post" enctype="multipart/form-data">

            <h3 class="accent">Gallery settings</h3>

            <label>Title</label>
            <input type="text" name="txtTitle">

            <label>Description</label>
            <textarea name="txtDescription"></textarea>

            <label>Conference Year</label>

            <select name="txtYear" required>
              <?php  do {?>
                <option value="<?php echo $year_rs_rows['cid']; ?>"><?php echo $year_rs_rows['cyear']; ?></option>

                <?php } while($year_rs_rows = mysqli_fetch_assoc($rs_year)) ?>

            </select>

            <input type="hidden" name="txtSecurity" value="<?php echo $_SESSION['svSecurity']; ?>">


            <!-- Button set -->
            <div class="button-set">

              <!-- submit form -->
              <button type="submit" name="btnAddNew">Upload <span class="fa fa-arrow-right"></span></button>

              <a class="button danger-btn" href="events-display.php" name="btnCancel">Cancel <span class="fa fa-times"></span></a>

            </div>

          </form>

        </section>

      </section>
      <div class="clearfix"></div>

    </div>

    <script src="js/accordian.js"></script>
  </body>
</html>
