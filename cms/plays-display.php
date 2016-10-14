<?php require('inc-cms-pre-doctype.php'); ?>
<?php
// Create SQL statement to fetch all records from tblcontactdetails
$sql_conferences = "SELECT * FROM tblconferences";

//Connect to MYSQL Server
require('inc-conn.php');

//Execute SQL statement
$rs_conferences = mysqli_query($vconn_wpi, $sql_conferences);

//Create associative Array
$rs_conferences_rows = mysqli_fetch_assoc($rs_conferences);

//Count the entries into the record set
$rs_conferences_rows_total = mysqli_num_rows($rs_conferences);

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
            <h2>Conferences</h2>
          </div>

        </header>

        <!-- MAIN CONTENT SECTION -->
        <section id="main-content" class="base">

          <?php if($rs_conferences_rows_total > 0) { ?>

          <?php do { ?>
            <div class="team-card" id="conferences<?php echo $rs_conferences_rows['eid']; ?>">

              <table cellspacing="0" class="tbldatadisplay">

                <tr class="tbl-heading">

                  <td colspan="5">
                    <strong><?php echo $rs_conferences_rows['ctitle']; ?></strong>
                  </td>
                  <td class=button-set >
                    <form method="post" action="conferences-update-display.php">
                      <button>Edit <span class="fa fa-pencil"></span></button>
                      <input type="hidden" name="txtId" value="<?php echo $rs_conferences_rows['cid'];?>">
                      <input type="hidden" name="txtSecurity" value="<?php echo $_SESSION['svSecurity']; ?>">
                    </form>

                    <button type="button" class="danger-btn" name="btnDel" data-security="<?php echo $_SESSION['svSecurity']; ?>" data-id="<?php echo $rs_conferences_rows['cid']; ?>" >Delete <span class="fa fa-trash-o"></span></button>
                  </td>

                </tr>
                <tr>
                  <td width="100" class="accent"><strong>Details</strong></td>
                  <td colspan="4">
                    <?php echo $rs_conferences_rows['cdetails']; ?>
                  </td>
                </tr>
                <tr>
                  <td width="100" class="accent"><strong>Theme</strong></td>
                  <td colspan="4">
                    <?php echo $rs_conferences_rows['ctheme']; ?>
                  </td>
                </tr>
                <tr>
                  <td class="accent"><strong>Date</strong></td>
                  <td colspan="4">
                  <?php echo $rs_conferences_rows['cstartdate'] . " - " . $rs_conferences_rows['cenddate']; ?>
                  </td>
                </tr>
                <tr>
                  <td class="accent"><strong>Location</strong></td>
                  <td colspan="4">
                  <?php echo $rs_conferences_rows['ccity'] . ", " . $rs_conferences_rows['ccountry']; ?>
                  </td>
                </tr>
                <tr>
                </tr>
                <tr>
                  <td class="accent"><strong>Event Url</strong></td>
                  <td colspan="4">
                    <a class="link" href="<?php echo $rs_conferences_rows['elink']; ?>" title="Link to event webpage"><?php echo $rs_conferences_rows['elink']; ?></a>

                  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4">
                    <small><i>Last Modified:  <?php echo $rs_conferences_rows['cmodified']; ?></i></small>
                  </td>
                </tr>

              </table>

            </div>

          <?php } while($rs_conferences_rows = mysqli_fetch_assoc($rs_conferences)) ?>

          <div class="clearfix"></div>

          <?php } else {?>

            <h2 class="accent">There are no conferences to display</h2>
            <p>Create a new event by navigating to <a href="conferences-add-new.php" title="Create a new event"><i>conferences > Add Conference</i></a>.

          <?php }?>

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
          url: 'conferences-delete-ajax-process.php',
          data: {
            'txtId': info.id,
            'txtSecurity': info.security
          },
          success: function(result) {

            if (result) {
              // Remove event record
              btn.parents('.team-card').remove();
              // Toast
              mw.deleteToast('Conference was deleted', '#main-content');
            } else {
              mw.deleteToast('Conference could not be deleted', '#main-content');
            }


          }
        });
      }

    });

    </script>
  </body>
</html>
