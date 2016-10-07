<?php require("inc-cms-pre-doctype.php"); ?>
<?php
$_SESSION['svSecurity'] = sha1(date('YmdHis'));
?>
<?php
  // Create SQL statement
  $sql_news = "SELECT * FROM tblnews ORDER BY ncreated ASC";

  //Connect to MYSQL Server
  require('inc-conn.php');

  //Execute SQL statement
  $rs_news = mysqli_query($vconn_creativeangels, $sql_news);

  //Create associative Array
  $rs_news_rows = mysqli_fetch_assoc($rs_news);

  //Count the entries into the record set
  $rs_news_rows_total = mysqli_num_rows($rs_news);
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
            <h2>News Articles</h2>
          </div>

        </header>

        <!-- MAIN CONTENT SECTION -->
        <section id="main-content" class="base">

          <?php if($rs_news_rows_total > 0) { ?>

          <?php do { ?>
            <div class="team-card" id="events<?php echo $rs_news_rows['nid']; ?>">

              <table cellspacing="0" class="tbldatadisplay">

                <tr class="tbl-heading">

                  <td >
                    <strong><?php echo $rs_news_rows['nheading']; ?></strong>
                  </td>

                  <td class=button-set colspan="4">
                    <!-- View -->
                    <form method="post" action="news-details-display.php">
                      <input type="hidden" name="txtId" value="<?php echo $rs_news_rows['nid']; ?>">
                      <input type="hidden" name="txtSecurity" value="<?php echo $_SESSION['svSecurity']; ?>">
                      <input class="button" type="submit" value="View">
                    </form>

                    <!-- Edit -->
                    <form method="get" action="news-update-display.php">
                      <input type="hidden" name="txtId" value="<?php echo $rs_news_rows['nid']; ?>">
                      <input type="hidden" name="txtSecurity" value="<?php echo $_SESSION['svSecurity']; ?>">
                      <button class="button" type="submit">Edit <span class="fa fa-pencil"></span></button>
                    </form>

                    <!-- Publish -->
                    <button type="button" name="pubBtn" data-status="<?php echo $rs_news_rows['nstatus']; ?>" data-sec="<?php echo $_SESSION['svSecurity']; ?>" data-id="<?php echo $rs_news_rows['nid']; ?>"><?php if($rs_news_rows['nstatus'] === 'i'){echo 'Publish <span class="fa fa-upload"></span>';} else {echo 'Archive <span class="fa fa-trash-o"></span>';} ?> </button>
                  </td>

                </tr>
                <tr>
                  <td colspan="4">
                    <?php echo $rs_news_rows['nsummary']; ?>
                  </td>
                </tr>
                <tr>
                  <td colspan="4">
                  <?php echo $rs_news_rows['ndate']; ?>
                  </td>
                </tr>
                <tr>
                  <td colspan="4">
                    <small><i>Last Modified:  <?php echo $rs_news_rows['nmodified']; ?></i></small>
                  </td>
                </tr>

              </table>

            </div>

          <?php } while($rs_news_rows = mysqli_fetch_assoc($rs_news)) ?>

          <div class="clearfix"></div>

          <?php } else {?>

            <h2 class="accent">There are no news articles to display</h2>
            <p>Create a new article by navigating to <a href="news-add-new.php" title="Create a new news article"><i>News > Add New</i></a>.

          <?php }?>

        </section>

      </section>
      <div class="clearfix"></div>

    </div>

    <script src="js/accordian.js"></script>
    <script>

    $(document).ready(function() {

      $(':button[name="pubBtn"]').on('click', function() {

        var btn = $(this);
        var info = btn.data();

        if(info.status === 'i') {
          info.status = 'a';
        } else if(info.status === 'a') {
          info.status = 'i';
        }

        $.ajax({
          type: 'POST',
          url: 'news-ajax-publish-process.php',
          data: {
            'txtSecurity': info.sec,
            'txtId': info.id,
            'txtStatus': info.status
          },
          success: function(result) {

            if (result === 'success') {

              if(info.status === 'i') {
                btn.val('Publish');
              } else if(info.status === 'a') {
                btn.val('Archive');
              }
            }

          }
        });
      });

    });

    </script>
  </body>
</html>
