<?php require(P.'credentials.php');
//Inserting to db
array_push($t, "'$form_status'");
if(BookingInsertion($db, $t)):
?>
<?php
ediv(100);
echo centerRow("<h1>Your Order has been saved: </h1>");
$rows = [];
$style = ['padding-right: 40px;'];
array_push($rows, simpleRow('Booking Number:', $booking_no, $style));
array_push($rows, simpleRow('Car:', $_POST['name'], $style));
array_push($rows, simpleRow('Pickup date:', $pickup_date, $style));
$dropoff = date('Y-m-d', strtotime($pickup_date." + $days_rented days"));
array_push($rows, simpleRow('Drop off date:', $dropoff, $style));
array_push($rows, simpleRow('Driver\'s license:', $customer_license, $style));
array_push($rows, simpleRow('Cost:', '$'.number_format($cost), $style));?>
<?php echo centerRow('<table>'.implode($rows).'</table>');
echo centerRow(getButton(HOMEURL.'client/', "Go back home"));
?>
<?php else:
  echo centerRow('<h1>Something went wrong</h1>');
endif;
?>
