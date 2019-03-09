<?php
require('../../private-client/initialize.php');
require (CLIENT.'head.php');
checkLog();
require(P.'credentials.php');
if(isset($_POST['pay'])){
  $v = [];
  //go though all the post elements
  array_push($v, "'".$_POST['receipt']."'");
  array_push($v, "'".$_POST['booking']."'");
  array_push($v, (int) $_POST['paid']);
  array_push($v, "'".$_POST['payment']."'");
  array_push($v, "'".$_POST['date']."'");
  if(BillInsertion($db, $v)){
    if(isset($_POST['booking'])){
      if(BookingUpdate($db, 'Form_status', 'PAID', $_POST['booking'])){
        HistoryInsertion($db, $v[0], $_SESSION['valid_user']);
          ediv(50);
          echo centerRow(h('Thank you for choosing Coche', 50, 'bold'));
          echo centerRow(getButton(HOMEURL.'client/', "Go Home"));
        if(isset($_SESSION['VIN'])){
            $vin = $_SESSION['VIN'];
            $pk = ['VIN', $vin]; //primary key for condition
            $record = ['Availability'=>'n'];//attribute(s) to update
            Update($db, 'VEHICLE', $record, $pk);

        }
      }
    }
  }else {
    echo "Your request could not be submitted at this time";
  }


}
require(CLIENT . 'tidy-up.php');
 ?>
