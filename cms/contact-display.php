<?php require('inc-cms-pre-doctype.php'); ?>
<?php require('inc-email-encryption-function.php'); ?>
<?php

    //Extract the id from the array.
    $vid = base64_decode($_GET['kid']);
    // Create SQL statement
    $sql_contact = "SELECT * FROM tblcontact WHERE cid=$vid";
    //Connect to MYSQL Server
    require('inc-conn.php');
    //Execute SQL statement
    $rs_contact = mysqli_query($vconn_wpi, $sql_contact);
    //Create associative Array
    $rs_contact_rows = mysqli_fetch_assoc($rs_contact);

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
            <h2>Contact Details > <strong><?php if ($vid === '1') { echo 'Durban'; } elseif ($vid === '2' ) { echo 'Cape Town'; } ?></strong></h2>
          </div>

        </header>

        <!-- MAIN CONTENT SECTION -->
        <section id="main-content" class="base">


          <table cellspacing="0" class="tbldatadisplay">

              <!--On all of these tds I placed an if statement that echos a "not Available" clause to avoid the page displaying "na" when the content is not available. This was optional, however this must not be displayed on the contact page of the contact us page on the front end of the website.-->
              <tr id="record<?php echo $rs_contact_rows['cid']; ?>">
              <td  class="accent" width=100><strong>Name:</strong></td>
              <td><?php echo $rs_contact_rows['ccontactpersonname'] . ' ' . $rs_contact_rows['ccontactpersonsurname']; ?></td>
              </tr>

              <tr>
              <td  class="accent"width=100><strong>Position:</strong></td>
              <td><?php if ($rs_contact_rows['ccontactpersontitle'] !== "na") { echo $rs_contact_rows['ccontactpersontitle']; } else { echo "Not Available"; } ?></td>
              </tr>

              <tr>
              <td  class="accent"width=100><strong>Office No:</strong></td>
              <td><?php if ($rs_contact_rows['clandline'] !== "na") { echo $rs_contact_rows['clandline']; } else { echo "Not Available"; } ?></td>
              </tr>

              <tr>
              <td  class="accent"width=100><strong>Cell No:</strong></td>
              <td><?php if ($rs_contact_rows['ccell'] !== "na") { echo $rs_contact_rows['ccell']; } else { echo "Not Available"; } ?></td>
              </tr>
              <tr>
             <td  class="accent"width=100><strong>Email:</strong></td>

             <!-- //Creating the e-mail link to display -->
             <td>
               <?php
              if ($rs_contact_rows['cemail'] !== 'na'){

                $email = $rs_contact_rows['cemail'];
                echo '<a href="mailto:' . escapeHex_email($email) . '">' . escapeHexEntity_email($email) . '</a>';

              } else {
                echo 'Not Available';
              }
              ?></td>
             </tr>

             <tr>
             <td class="accent"><strong>Address:</strong></td>
             <td>
                 <!--I wrote this if statement so that when there is no address available, only the relevant cit y is displayed. normally the code looked like this:

                 <?php echo $rs_contact_rows['caddress1'] . ', ' . $rs_contact_rows['caddress2'] . ', ' . $rs_contact_rows['caddress3'] . ', ' . $rs_contact_rows['csuburb'] . ', ' . $rs_contact_rows['ccity']; ?>
                 However if there is no address available the innerHTML of the td displays na, na, na, na. This if statement is to prevent that from displaying.
                 -->
                 <?php if ($rs_contact_rows['caddress1'] === 'na' || $rs_contact_rows['caddress2'] === 'na' || $rs_contact_rows['caddress3'] === 'na' || $rs_contact_rows['csuburb'] === 'na') {

                 echo $rs_contact_rows['ccity'];

                 } elseif ($rs_contact_rows['caddress1'] !== 'na' || $rs_contact_rows['caddress2'] !== 'na' || $rs_contact_rows['caddress3'] !== 'na' || $rs_contact_rows['csuburb'] !== 'na') {

                 echo $rs_contact_rows['caddress1'] . ', ' . $rs_contact_rows['caddress2'] . ', ' . $rs_contact_rows['caddress3'] . ', ' . $rs_contact_rows['csuburb'] . ', ' . $rs_contact_rows['ccity'];

                 } ?>
             </td>
           </tr>
         </table>

         <div class="button-set">

           <form method="get" action="contact-details-update-display.php">
             <button>Update</button>
             <input type="hidden" name="txtId" value="<?php echo $rs_contact_rows['cid'];?>">
             <input type="hidden" name="txtSecurity" value="<?php echo $_SESSION['svSecurity']; ?>">
           </form>

         </div>

         <p>
              <small><i>Last Modified:  <?php echo $rs_contact_rows['cmodified']; ?></i></small>
         </p>





        </section>

      </section>
      <div class="clearfix"></div>

    </div>

    <script src="js/accordian.js"></script>
    <script>

    // Display toast when update successful
    <?php if( isset($_GET['kupdate']) && $_GET['kupdate'] === 'success') {
      echo 'mw.successToast("Record has been updated","#main-content");';
    }
    ?>

    </script>
  </body>
</html>
