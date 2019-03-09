<?php require(P.'credentials.php');
//insert into booking table
if(!isset($continue)){
    //if is coming from continue don't do this
    array_push($t, "'$form_status'");
    BookingInsertion($db, $t); //inserts values into booking
}
ediv(100);
echo centerRow("<h1>Here is your order's summary: </h1>");
$rows = [];
$style = ['padding-right: 40px;'];
array_push($rows, simpleRow('Booking Number:', $booking_no, $style));
array_push($rows, simpleRow('Car:', $carname, $style));
array_push($rows, simpleRow('Pickup date:', $pickup_date, $style));
$dropoff = date('Y-m-d', strtotime($pickup_date." + $days_rented days"));
array_push($rows, simpleRow('Drop off date:', $dropoff, $style));
array_push($rows, simpleRow('Driver\'s license:', $customer_license, $style));
array_push($rows, simpleRow('Cost:', '$'.number_format($cost), $style));?>
<?php echo centerRow('<table>'.implode($rows).'</table>');?>
<?php
$button = '<input class="btn btn-outline-success" type="submit" name="pay" value="Pay now">';
$hide = hiddenInput('receipt', receipt());
$hide .= hiddenInput('booking', $booking_no);
$hide .= hiddenInput('paid', $cost);
$hide .= hiddenInput('date', date('Y-m-d'));

$form = '<form method="post" action="pay.php"> <div class="form-group mb-3">
    <label for="payment">Method of Payment:</label>
    <div class="col-7">
      <select class="form-control form-control-sm" name="payment" id="payment">
        <option value="amex">American Express</option>
        <option value="credit">Credit Card</option>
        <option value="paypal">Paypal</option>
      </select>
    </div>
  </div>'.$button.$hide.'
</form>';
echo centerRow(getColumn($form, 4));
?>
