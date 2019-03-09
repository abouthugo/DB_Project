<?php
if(isset($_GET['title']))
  $page_title = $_GET['title'];
require('../../private-client/initialize.php');
require(CLIENT.'head.php');
checkLog();
$min = strtotime("tomorrow");
$min = date("Y-m-d", $min); //todays date
$max = strtotime("+3 days");
$max = date('Y-m-d', $max); // 31 days from now

$dateCondition = 'min="'.$min.'" max="'.$max.'" ';
$submit = 'onclick="document.forms[\'show-form\'].action="'
?>
<div class="container">

<?php if(isset($_GET['picture']) && isset($_GET['price'])) : ?>
<?php echo "<h1>{$_GET['title']}</h1>";
if(isset($_GET['vin'])){
    $_SESSION['VIN'] = validateInput($_GET['vin']); // save vin for future reference
}
echo "<small class=\"text-muted\">\${$_GET['price']}/day</small><br>"; ?>
<?php echo getImage($_GET['picture']); ?>
<div class="col-4">
  <form action="process.php" method="post" id='show-form'>
      <div class="form-group mb-3">
        <label for="pickup">Select a date for pickup</label>
          <div class="col-7">
            <input class="form-control form-control-sm" type="date" name="pickup" value="" id="pickup" <?php echo $dateCondition;?> required>
          </div>
      </div>
      <div class="form-group mb-3">
        <label for="days">Select how many days(1 day minimum)</label>
        <div class="col-7">
          <input class="form-control form-control-sm" type="number" name="days" id="days" min="1" max="30" required>
        </div>
      </div>
      <div class="form-group mb-3">
        <label for="license">Enter your license number</label>
        <div class="col-7">
          <input class="form-control form-control-sm" type="text" name="license" id="license" pattern="\w{4,10}" required>
        </div>
      </div>
      <input class="collapse" type="text" name="booking" value="<?php echo booking(); ?>">
      <input class="collapse" type="text" name="user" value="<?php echo $_SESSION['valid_user']; ?>">
      <input class="collapse" type="text" name="car" value="<?php echo $_GET['vin']; ?>">
      <input class="collapse" type="text" name="price" value="<?php echo $_GET['price']; ?>">
      <input class="collapse" type="text" name="name" value="<?php echo $page_title; ?>">
      <button class="btn btn-dark" type="submit" name="submit" value="processing">Process Order</button>
      <button class="btn btn-warning" type="submit" name="save" value="saved">Save Order</button>
  </form>
</div>
<?php
$previous = 'javascript:history.go(-1)';
if(isset($_SERVER['HTTP_REFERER'])){
  $previous = $_SERVER['HTTP_REFERER'];
}
$class = 'class="fixed btn btn-outline-info "';

echo customLink($previous, $class, 'Go back');?>
<?php else : ?>
  <div class="row justify-content-center">
    <?php ediv(150); ?>
    <h1>Your request cannot be processed at this time</h1>
  </div>
  <div class="row justify-content-center">
    <?php echo getButton(HOMEURL.'client/cars.php', "Go back"); ?>
  </div>
<?php endif; ?>
</div>
<?php include(CLIENT . 'tidy-up.php'); ?>
