<?php require('inc-cms-pre-doctype.php'); ?>
<?php

//Connect to MYSQL Server
require('inc-conn.php');


// SELECT ALL galleries
$sql_galleries = "SELECT * FROM  tblgalleries JOIN tblconferences ON tblconferences.cid = tblgalleries.cid";

// YEARS QUERY
$sql_year ="SELECT cyear FROM tblconferences";
$rs_year = mysqli_query($vconn_wpi, $sql_galleries);
$rs_year_rows = mysqli_fetch_assoc($rs_year);
$rs_year_rows_total = mysqli_num_rows($rs_year);

// CHecks to see if results are filtered

if(isset($_POST['filter']) && $_POST['filter'] === 'true') {

  $conId = $_POST['txtYear'];

  $sql_galleries = "SELECT * FROM  tblgalleries JOIN tblconferences ON tblconferences.cid = tblgalleries.cid WHERE tblgalleries.cid = $conId";

}
  //Execute SQL statement
  $rs_galleries = mysqli_query($vconn_wpi, $sql_galleries);

  //Create associative Array
  $rs_galleries_rows = mysqli_fetch_assoc($rs_galleries);

  $rs_galleries_rows_total = mysqli_num_rows($rs_galleries);

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
            <h2>Galleries<h2>
          </div>

        </header>

        <!-- MAIN CONTENT SECTION -->
        <section id="main-content" class="base">

          <!-- FILTERS RESULTS -->
          <div class="filter">
            <h3>
            <?php if(isset($_POST['filter']) && $_POST['filter'] === 'true') {
              $conYear = $rs_galleries_rows['cyear'];

              echo $conYear;
            }?>
          </h3>
          <form action="galleries-display.php" method="post">
            <label>Conference</label>
            <select name="txtYear">
              <?php do { ?>
              <option value="<?php echo $rs_year_rows['cid']; ?>"><?php echo $rs_year_rows['cyear']; ?></option>

              <?php } while($rs_year_rows = mysqli_fetch_assoc($rs_year)) ?>
            </select>

            <input name="filter" type="hidden" value="true"></input>

            <input class="button" type="submit" value="Filter">

          </form>
        </div>

          <?php if($rs_galleries_rows_total > 0) { ?>

          <?php do { ?>
            <div class="team-card" id="galleries<?php echo $rs_galleries_rows['pid']; ?>">

              <table cellspacing="0" class="tbldatadisplay">

                <tr class="tbl-heading">

                  <td colspan="5">
                    <strong><?php echo $rs_galleries_rows['ptitle']; ?></strong>
                  </td>
                  <td class=button-set >
                    <form method="post" action="galleries-update-display.php">
                      <button>Edit <span class="fa fa-pencil"></span></button>
                      <input type="hidden" name="txtId" value="<?php echo $rs_galleries_rows['pid'];?>">
                      <input type="hidden" name="txtSecurity" value="<?php echo $_SESSION['svSecurity']; ?>">
                    </form>

                    <button type="button" class="danger-btn" name="btnDel" data-security="<?php echo $_SESSION['svSecurity']; ?>" data-id="<?php echo $rs_galleries_rows['cid']; ?>" >Delete <span class="fa fa-trash-o"></span></button>
                  </td>

                </tr>
                <tr>
                  <td width="100" class="accent"><strong>Author</strong></td>
                  <td colspan="4">
                    <?php echo $rs_galleries_rows['pauthorname'] . " " . $rs_galleries_rows['pauthorsurname']; ?>
                  </td>
                </tr>
                <tr>
                  <td width="100" class="accent"><strong>Synopsis</strong></td>
                  <td colspan="4">
                    <?php echo $rs_galleries_rows['psynopsis']; ?>
                  </td>
                </tr>

              </table>

            </div>

          <?php } while($rs_galleries_rows = mysqli_fetch_assoc($rs_galleries)) ?>

          <div class="clearfix"></div>

          <?php } else {?>

            <h2 class="accent">There are no galleries to display</h2>
            <p>Create a new event by navigating to <a href="galleries-add-new.php" title="Create a new event"><i>galleries > Add Conference</i></a>.

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
          url: 'galleries-delete-ajax-process.php',
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

    });

    </script>
  </body>
</html>
