<?php $page_title = "Processing order";
require('../../private-client/initialize.php');
require(CLIENT.'head.php');
?>
<?php if(isset($_GET['fromSaved'])):?>
    <?php
    $booking = validateInput($_GET['booking']);
    require(P.'credentials.php');
    $columns = 'Pickup_date AS Pickup, Customer_license AS License'.
            ', Days_rented AS Days';
    $cond = "WHERE Booking_no='$booking'";
    $query = "SELECT $columns FROM BOOKING $cond";
    $result = mysqli_query($db, $query);
    $record = mysqli_fetch_assoc($result); //there should only be one record
    //define
    $booking_no = $booking;
    $carname = validateInput($_GET['name']);
    $pickup_date = $record['Pickup'];
    $days_rented = $record['Days'];
    $customer_license = $record['License'];
    $cost = (int) validateInput($_GET['cost']);

    //Update Form_status
    $rec = ['Form_status'=>'PROCESSING'];
    $pk = ['Booking_no',$booking_no];
    Update($db, 'BOOKING', $rec, $pk);

    mysqli_free_result($result);
    mysqli_close($db);
    $continue = "yes"; //used to skip some code in process-submit.php
    //call process-submit to proceed to payment
    include(CLIENT . 'process-submit.php');
    ?>
<?php else: ?>
    <div class="container">
      <?php
      $booking_no = validateInput($_POST['booking']);
      $carname = validateInput($_POST['name']);
      $customer_id = validateInput($_POST['user']);
      $car_selected = validateInput($_POST['car']);
      $days_rented = (int) validateInput($_POST['days']);
      $cost = (int)validateInput($_POST['price']) *  $days_rented;
      $pickup_date = validateInput($_POST['pickup']);
      $customer_license = validateInput($_POST['license']);

      /* PREPARING DATA FOR SQL INSERTION */
      $t[0] = "'$booking_no'";
      array_push($t, "'$customer_id'");
      array_push($t, "'$car_selected'");
      array_push($t, "$days_rented");
      array_push($t, "$cost");
      array_push($t, "'$pickup_date'");
      array_push($t, "'$customer_license'");
      ?>
    <?php if(isset($_POST['save'])):?>
        <?php $form_status = validateInput($_POST['save']);
        include(CLIENT . 'process-save.php');
        ?>
        <?php elseif(isset($_POST['submit'])): ?>
        <?php $form_status = validateInput($_POST['submit']);
        include(CLIENT . 'process-submit.php');
        ?>
    <?php else : ?>
        <h1>Your request cannot be processed at this time</h1>
        <?php
        echo getButton(HOMEURL.'client/', "Go home");
    endif; ?>
    </div>
<?php endif;
require(CLIENT.'tidy-up.php');
?>