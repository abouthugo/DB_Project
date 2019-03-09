<?php
require_once('../private-client/initialize.php');
require (CLIENT.'head.php');
checkLog(); ?>
<div class="container">
<?php
if(isset($_SESSION['valid_user'])){
  unset($_SESSION['valid_user']);
  unset($_SESSION['VIN']);
  session_destroy();
  echo "<h2>Bye!</h2>";
  echo getBtn();
}else {
  echo "<h2>You never logged in.</h2>";
  echo getBtn();
}
?>
</div>

<?php include(CLIENT . 'tidy-up.php'); ?>
