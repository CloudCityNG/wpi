<ul id="main-menu" class="menu">

  <div class="main-header base">
    <h1><a href="cms-homepage.php">Creative Angels</a></h1>

  </div>

  <li><a class="opt-menu" href="cms-homepage.php">Dashboard</a></li>

  <!-- Website configuration -->
  <li class="opt-menu">Website Settings</li>
  <ul class="submenu">
    <li><a class="opt-menu" href="about-details-display.php">View</a></li>
  </ul>

  <!-- User configuration -->
  <li class="opt-menu">User Accounts</li>
  <ul class="submenu">
    <li><a  class="opt-menu"href="admin-display.php">View</a></li>
    <?php if($_SESSION['svcaccesslevel'] === 'a') { ?>
      <li><a  class="opt-menu"href="admin-add-new.php">Add Users</a></li>
    <?php } ?>
  </ul>

  <!-- Conference archive -->
  <li class="opt-menu">Conferences</li>
  <ul class="submenu">
    <li><a  class="opt-menu"href="conferences-display.php">View</a></li>
    <li><a  class="opt-menu"href="conferences-add-new.php">Add Conference</a></li>
  </ul>

  <!-- Play archive -->
  <li class="opt-menu">Plays</li>
  <ul class="submenu">
    <li><a  class="opt-menu"href="plays-display.php">View</a></li>
    <li><a  class="opt-menu"href="plays-add-new.php">Add Play</a></li>
  </ul>

  <!-- Gallery archive -->
  <li class="opt-menu">Gallery</li>
  <ul class="submenu">
    <li><a  class="opt-menu"href="galleries-display.php">View</a></li>
    <li><a  class="opt-menu"href="galleries-add-new.php">Add to Gallery</a></li>
  </ul>

  <!-- Contact settings -->
  <li><a  class="opt-menu"href="contact-display.php">View</a></li>


  <li class="opt-menu"><a href="../signout.php">Log out</a></li>
  <!-- FOOTER -->
<?php // require('inc-cms-footer.php'); ?>
</ul>
