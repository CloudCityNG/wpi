<?php require('inc-cms-pre-doctype.php'); ?>
<?php

//Connect to MYSQL Server
require('inc-conn.php');

// SELECT ALL IMAGES
$sql_photos = "SELECT * FROM  tblphotos";

// YEARS QUERY
$sql_year = "SELECT cyear, cid FROM tblconferences";
$rs_year = mysqli_query($vconn_wpi, $sql_year);
$rs_year_rows = mysqli_fetch_assoc($rs_year);
$rs_year_rows_total = mysqli_num_rows($rs_year);

// Checks to see if results are filtered

if(isset($_GET['filter']) && $_GET['filter'] === 'true') {

  $conId = $_GET['txtYear'];

  $sql_photos = "SELECT * FROM  tblphotos JOIN tblconferences ON tblconferences.cid = tblphotos.cid WHERE tblphotos.cid = $conId";

}
  //Execute SQL statement
  $rs_photos = mysqli_query($vconn_wpi, $sql_photos);

  //Create associative Array
  $rs_photos_rows = mysqli_fetch_assoc($rs_photos);

  $rs_photos_rows_total = mysqli_num_rows($rs_photos);

?>
<!DOCTYPE html>
<html>
  <head>
    <!-- Head contents -->
    <?php require('inc-cms-head-content.php'); ?>
    <script src="js/modal.js"></script>

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
            <h2>photos<h2>
          </div>

        </header>

        <!-- MAIN CONTENT SECTION -->
        <section id="main-content" class="base">

          <!-- FILTERS RESULTS -------------------------------------->
          <div class="filter">

            <h3>
            <?php if(isset($_GET['filter']) && $_GET['filter'] === 'true') {
              $conYear = $rs_photos_rows['cyear'];

              echo "Showing images for $conYear";
            }?>
          </h3>

          <form action="galleries-display.php" method="get">
            <label>Year</label>
            <select name="txtYear">

              <?php do { ?>
              <option value="<?php echo $rs_year_rows['cid']; ?>"><?php echo $rs_year_rows['cyear']; ?></option>

              <?php } while($rs_year_rows = mysqli_fetch_assoc($rs_year)) ?>

            </select>

            <input name="filter" type="hidden" value="true"></input>

            <input class="button" type="submit" value="Apply">
            <a href="galleries-display.php">Remove Filters</a>

          </form>
        </div>



        <!-- DISPLAY RESULTS ----------------------------------------->

          <?php if($rs_photos_rows_total > 0) { ?>

          <div class="photo-gallery">

          <?php do { ?>

            <div class="photo-details">
              <figure>

                <img src="../assets/uploads/galleries/large/<?php echo $rs_photos_rows['guri']; ?>">

              </figure>

              <div class="photo-caption">

                <?php if($rs_photos_rows['gcaption'] !== 'na' || $rs_photos_rows['gdescription'] !== 'na') {?>

                <h4>Caption</h4>
                <p><?php echo $rs_photos_rows['gcaption']; ?><p>

                <h4>Description</h4>
                <p><?php echo $rs_photos_rows['gdescription']; ?><p>
                <?php } ?>

                <div class="button-set">
                  <button name="imgEdit" data-id="<?php echo $rs_photos_rows['gid']; ?>" data-img="<?php echo $rs_photos_rows['guri']; ?>" data-caption="<?php echo $rs_photos_rows['gcaption']; ?>" data-description="<?php echo $rs_photos_rows['gdescription']; ?>">Edit</button>
                  <button class="danger-btn">Delete</button>
                </div>

            </div>

          </div>

          <?php } while($rs_photos_rows = mysqli_fetch_assoc($rs_photos)) ?>

          </div>

          <div class="clearfix"></div>

          <?php } else {?>

            <h2 class="accent">There are no photos to display</h2>
            <p>Create a new event by navigating to <a href="photos-add-new.php" title="Create a new event"><i>photos > Add Gallery</i></a>.

          <?php }?>



          <!-- SIDEBAR TO EDIT IMAGE CAPTION AND DESCRIPTION ---------------->

          <div id="editSidebar">

            <form class="form sidebar" action="galleries-edit-process.php" method="post">
              <h3 class="accent">Edit Image</h3>

              <figure>
                <img id="activeImg" src="">
              </figure>

              <label>Caption</label>
              <input id="activeCaption" type="text" name="txtCaption">

              <label>Description</label>
              <textarea id="activeDescription" name="txtDescription"></textarea>

              <input type="hidden" name="txtSecurity" value="<?php echo $_SESSION['svSecurity']; ?>">

              <input id="editId" type="hidden" name="txtId" value="">

              <div class="button-set">
                <input type="submit" value="Save">
                <span class="button danger-btn" name="cancelBtn">Cancel</span>
              </div>


            </form>

          </div>

        </section>

      </section>
      <div class="clearfix"></div>

    </div>

    <script src="js/accordian.js"></script>
    <script>

    $(document).ready(function() {

      $(':button[name="btnDel"]').click(function() {

        var btn = $(this);
        var info = btn.data();

        mw.delete('Deleting a record is a permanent action.\nDo you wish to proceed?', '#main-content', function(result) {

          if (result) {
            deleteRecord(info, btn);
          }

        });
      });

      function deleteRecord(info, btn) {
        $.ajax({
          type: 'POST',
          url: 'photos-delete-ajax-process.php',
          data: {
            'txtId': info.id,
            'txtSecurity': info.security
          },
          success: function(result) {

            if (result) {
              // Remove event record
              btn.parents('.team-card').remove();
              // Toast
              mw.deleteToast('Gallery was deleted', '#main-content');
            } else {
              mw.deleteToast('Gallery could not be deleted', '#main-content');
            }


          }
        });
      }


      $(':button[name="imgEdit"]').on('click', function() {
        var info = $(this).data();

        // assign values to elements
        $('#activeImg').attr('src', `../assets/uploads/galleries/large/${info.img}`);

        if(info.caption !== 'na') {
          $('#activeCaption').val(info.caption);
        }

        if(info.description !== 'na') {
          $('#activeDescription').html(info.description);
        }

        $('#editId').val(info.id);

        document.getElementById('editSidebar').style.right = 0;
      });

      $('span[name="cancelBtn"]').on('click', function() {
        document.getElementById('editSidebar').style.right = '-30%';

        // Empty input fields
          $('#activeCaption').val('');
          $('#activeDescription').html('');
          $('#editId').val('');
      });

    });

    </script>
  </body>
</html>
