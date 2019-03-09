<?php $page_title = "Reservations" ?>
<?php require '../../private-client/initialize.php';?>
<?php
if(isset($_GET['del'])){
  //if user presses delete
  require(P.'credentials.php');
  $delete = 'DELETE FROM BOOKING WHERE Booking_no = "'.$_GET['del'].'"';
  if(mysqli_query($db, $delete) === TRUE){
    //if record is deleted
    mysqli_close($db);
    //close db connection and redirect
    header('Location: '.HOMEURL.'client/reservations.php');
  }else {
    //else close connection and exit the script with a message
    mysqli_close($db);
    echo "No such record";
    exit;
  }
}
require (CLIENT.'head.php');
checkLog();

makeNav($page_title);
?>
<div class="container saved">
<?php require(P.'credentials.php');?>
<?php
echo centerRow(h('Saved Vehicles:', 50, 'normal'));
$resultBooking = getSavedItems($db);
$n = mysqli_num_rows($resultBooking);
if($n>0){
    echo centerRow(savedTable($resultBooking));
}else {
  echo centerRow('<small class="text-muted">You haven\'t saved anything.</small>');
}
?>
</div>
<hr>
<div class="container history">
  <?php
    echo centerRow(h('History:', 50, 'normal'));
    $cond = "WHERE BILL.Receipt_no=HISTORY.Receipt_ref AND BOOKING.Booking_no=BILL.Booking_no ".
            "AND Car_selected=VIN AND Customer='{$_SESSION['valid_user']}'";
    $name = "CONCAT(Year, ' ', Make, ' ', Model) AS Name";
    $fields = 'Cost, Pickup_date AS Pickup, Days_rented AS Days, Receipt_ref AS Receipt';
    $select = "SELECT $name, $fields";
    $from = 'FROM VEHICLE, BOOKING, BILL, HISTORY';
    $query = "$select $from $cond";
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0):?>
 <?php
    while ($record = mysqli_fetch_assoc($result)){
        //Attrs = (Receipt, Name, Pickup, Days, Cost)
        $receipt = $record['Receipt'];
        $name = $record['Name'];
        $from = date('l, F j Y', strtotime($record['Pickup']));
        $days = $record['Days'];
        setlocale(LC_MONETARY, 'en_US');
        $price = money_format("%.2n ",$record['Cost']);
        $to = date('l, F j Y',strtotime($from." + $days days"));
        $details = "<p><strong>Receipt# </strong>$receipt<br>";
        $details .= "Car: $name <br>From: $from <br/> To: $to <br> Your total was: $price</p>";
        echo centerRow($details);
        echo '<hr/>';
    }
   ?>
    <?php else:
        $outputMessage = "<small class='text-muted'>You haven't bought anything yet.</small>";
        echo centerRow($outputMessage);
    endif;
  ?>
</div>
<?php require_once(CLIENT . 'tidy-up.php'); ?>
