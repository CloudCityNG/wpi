<ul id="main-menu" class="menu">

  <div class="main-header base">
    <h1><a href="cms-homepage.php">Creative Angels</a></h1>

  </div>

  <li><a class="opt-menu" href="cms-homepage.php">Dashboard</a></li>

  <li class="opt-menu">Website Settings</li>
  <ul class="submenu">
    <li><a class="opt-menu" href="about-details-display.php">View</a></li>
  </ul>

  <li class="opt-menu">User Accounts</li>
  <ul class="submenu">
    <li><a  class="opt-menu"href="admin-display.php">View</a></li>
    <?php if($_SESSION['svcaccesslevel'] === 'a') { ?>
      <li><a  class="opt-menu"href="admin-add-new.php">Add Users</a></li>
    <?php } ?>
  </ul>

  <li class="opt-menu">Conferences</li>
  <ul class="submenu">
    <li><a  class="opt-menu"href="conferences-display.php">View</a></li>
    <li><a  class="opt-menu"href="conferences-add-new.php">Add Conference</a></li>

  </ul>

  <li class="opt-menu"><a href="../signout.php">Log out</a></li>
  <!-- FOOTER -->
<?php // require('inc-cms-footer.php'); ?>
</ul>
