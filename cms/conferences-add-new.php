<?php require('inc-cms-pre-doctype.php'); ?>
<?php
$_SESSION['svSecurity'] = sha1(date('YmdHis'));
?>
<?php
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
            <h2>Add New Conference</h2>
          </div>

        </header>

        <!-- MAIN CONTENT SECTION -->
        <section id="main-content" class="base">

          <!--#################### ADD NEW FORM #########################-->

          <form id="form" class="form" action="conferences-add-process.php" method="post" enctype="multipart/form-data">

            <p><small>Please enter the details for the conference. </small></p>
            <p><small>The title and them fields are required, the rest of the details you can fill that in later.</small></p>

            <!-- EVENT TITLE -->
            <label>Conference Title</label>

            <!-- Displays warning message above empty field -->
            <?php echo errorMsg('ktitle', 'title'); ?>

            <input type="text" name="txtTitle" autocomplete="off" autofocus value="<?php echo displayTxt('ktitle'); ?>" required>

            <!-- THEME -->
            <label>Theme</label>

            <?php echo errorMsg('ktheme', 'theme'); ?>

            <input type="text" name="txtTheme" autocomplete="off" autofocus value="<?php echo displayTxt('ktheme'); ?>" required>

            <!-- DESCRIPTION -->
            <label>Details</label>
            <p><small>Extra details that has no field</small></p>

            <?php echo errorMsg('kdetails', 'details'); ?>

            <textarea name="txtDetails"><?php echo displayTxt('kdetails'); ?></textarea>

            <h3 class="accent">When <span class="fa fa-calendar"></span></h3>

            <!-- START DATE -->
            <label>Start Date </label>

            <?php echo errorMsg('kstartdate', 'start date'); ?>
            <input id="startdate" type="date" name="txtStartDate" value="<?php echo displayTxt('kstartdate'); ?>" min="<?php echo date('Y-m-d');?>" onblur="enddatemin()">

            <!-- END DATE -->
            <label>End Date</label>

            <?php echo errorMsg('kenddate', 'end date'); ?>
            <input id="enddate" type="date" name="txtEndDate" value="<?php echo displayTxt('kenddate'); ?>">

            <h3 class="accent">Where <span class="fa fa-map-marker"></span></h3>

            <!-- LOCATION -->
            <label>City </label>

            <?php echo errorMsg('kcity', 'city'); ?>
            <input type="text" name="txtCity" value="<?php echo displayTxt('kcity'); ?>">

            <label>Country </label>

            <?php echo errorMsg('kcountry', 'country'); ?>

            <!-- TODO:UX friendly country/city selector -->

            <select id="countrySelect" name="txtCountry" value="<?php echo displayTxt('kcountry'); ?>"></select>

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
