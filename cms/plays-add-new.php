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
            <h2>Add New Plays</h2>
          </div>

        </header>

        <!-- MAIN CONTENT SECTION -->
        <section id="main-content" class="base">

          <!--#################### ADD NEW FORM #########################-->

          <form id="form" class="form" action="plays-add-process.php" method="post" enctype="multipart/form-data">

            <p><small>Please enter the details for the play. </small></p>

            <!-- PLAY TITLE -->
            <label>Play Title</label>

            <!-- Displays warning message above empty field -->
            <?php echo errorMsg('ktitle', 'title'); ?>

            <input type="text" name="txtTitle" autocomplete="off" autofocus value="<?php echo displayTxt('ktitle'); ?>" required>

            <label>Conference Year</label>

            <select name="txtYear">
              <?php  do {?>
                <option value="<?php echo $year_rs_rows['cid']; ?>"><?php echo $year_rs_rows['cyear']; ?></option>

                <?php } while($year_rs_rows = mysqli_fetch_assoc($rs_year)) ?>

            </select>

            <!-- PLAY AUTHOR -->
            <label>Author First Name</label>

            <!-- Displays warning message above empty field -->
            <?php echo errorMsg('kaname', 'author first name'); ?>

            <input type="text" name="txtAuthName" autocomplete="off" autofocus value="<?php echo displayTxt('kaname'); ?>" required>

            <!-- PLAY Surname -->
            <label>Author Surname</label>

            <!-- Displays warning message above empty field -->
            <?php echo errorMsg('kaname', 'author surname'); ?>

            <input type="text" name="txtAuthsurname" autocomplete="off" autofocus value="<?php echo displayTxt('kasurname'); ?>" required>

            <!-- DESCRIPTION -->
            <label>Synopsis</label>
            <p><small>Just a brief introduction to the play</small></p>

            <?php echo errorMsg('ksynopsis', 'synopsis'); ?>

            <textarea name="txtSynopsis"><?php echo displayTxt('ksynopsis'); ?></textarea>


            <input type="hidden" name="txtSecurity" value="<?php echo $_SESSION['svSecurity']; ?>">


            <!-- Button set -->
            <div class="button-set">

              <!-- submit form -->
              <button type="submit" name="btnAddNew">Save <span class="fa fa-check"></span></button>

              <a class="button danger-btn" href="events-display.php" name="btnCancel">Cancel <span class="fa fa-times"></span></a>

            </div>

          </form>

        </section>

      </section>
      <div class="clearfix"></div>

    </div>

    <script src="js/accordian.js"></script>
    <script src="js/country-picker.js"></script>
    <script>

      function enddatemin(){
        let enddate = document.getElementById('enddate');
        let minVal = document.getElementById('startdate').value;

        enddate.min = minVal;
      }

    </script>
  </body>
</html>
