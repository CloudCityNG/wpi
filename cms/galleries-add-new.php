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
            <h2>Add to Gallery</h2>
          </div>

        </header>

        <!-- MAIN CONTENT SECTION -->
        <section id="main-content" class="base">

          <!--#################### ADD NEW FORM #########################-->

          <form id="form" class="form" action="galleries-add-process.php" method="post" enctype="multipart/form-data">

            <!-- SELECT GALLERY -->

            <h3 class="accent">Gallery settings</h3>

            <label>Conference Year</label>

            <select name="txtYear" required>
              <?php  do {?>
                <option value="<?php echo $year_rs_rows['cid']; ?>"><?php echo $year_rs_rows['cyear']; ?></option>

                <?php } while($year_rs_rows = mysqli_fetch_assoc($rs_year)) ?>

            </select>

            <!-- ADD IMAGES -->

            <h3 class="accent">Upload Images <i class="fa fa-picture-o"></i></h3>

            <label>Select images to upload. Each image must be a jpeg file and smaller than 2MB</label>
            <input type="file" name="txtImg[]" onchange="displayImg();" autocomplete="off" autofocus required accept="image/jpeg, image/png" multiple >

            <div class="line"></div>

            <div>

              <?php if(isset($_GET['kerrors']) && $_GET['kerrors'] !== '') {

                $errorLog = explode(', ', $_GET['kerrors'] );
                ?>

                <ul>

                  <?php foreach ($errorLog as $value) {
                    echo "<li>$value</li>";
                  }?>

                </ul>

              <?php } ?>

            </div>
            <div id="preview"></div>

            <input type="hidden" name="txtSecurity" value="<?php echo $_SESSION['svSecurity']; ?>">
            <input type="hidden" name="txtId" value="<?php echo $vid; ?>">


            <input type="hidden" name="txtSecurity" value="<?php echo $_SESSION['svSecurity']; ?>">

            <!-- Button set -->
            <div class="button-set">

              <!-- submit form -->
              <button type="submit" name="btnAddNew">Save <span class="fa fa-check"></span></button>

              <a class="button danger-btn" href="galleries-display.php" name="btnCancel">Cancel <span class="fa fa-times"></span></a>

            </div>

          </form>

        </section>

      </section>
      <div class="clearfix"></div>

    </div>

    <script src="js/accordian.js"></script>
    <script>

      function displayImg() {

        // creates an array of all files selected by user
        var images = document.querySelector('input[name="txtImg[]"]').files;
        var preview = document.getElementById('preview');

          function readAndPreview(img) {
            console.log('meh');
            var reader = new FileReader();

            reader.addEventListener('load', function() {

              // creates new image object
              var image = new Image();

              image.height = 200;
              image.title = img.name;
              image.src = this.result;

              preview.appendChild(image);

            }, false);

            reader.readAsDataURL(img);

          }

        if (images) {
          [].forEach.call(images, readAndPreview);
        }

      }

    </script>
  </body>
</html>
