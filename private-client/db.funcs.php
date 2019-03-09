<?php
/* Booking functions */
function BookingInsertion($db, $values){

  $insert = "INSERT INTO BOOKING VALUES";
  $vals = implode(", ", $values);
  $query = "$insert ($vals)";
  if(mysqli_query($db, $query) === TRUE){
    return 1;
  }else {
    return 0;
  }

}

function BookingDeletion($db, $key){

  $delete = "DELETE FROM BOOKING WHERE Booking_no = '$key'";
  if(mysqli_query($db, $delete) === TRUE){
    return 1;
  }else {
    return 0;
  }

}

function BookingUpdate($db, $column, $value, $key){
  $cond = "WHERE Booking_no='{$key}'";
  $update = "UPDATE BOOKING SET $column='{$value}' $cond";
  if(mysqli_query($db, $update) === TRUE){
    return 1;
  }else {
    return 0;
  }
}

/*  Bill functions  */
function BillInsertion($db, $values){
  $insert = 'INSERT INTO BILL VALUES';
  $vals = implode(", ", $values);
  $query = "$insert ($vals)";
  if(mysqli_query($db, $query) === TRUE){
    return 1;
  }else {
    return 0;
  }
}

/*  History functions */
function HistoryInsertion($db, $receipt, $customerid){
  $insert = "INSERT INTO HISTORY VALUES";
  $vals = "({$receipt}, '{$customerid}')";
  $query = "$insert $vals";
  // echo $query;
  if(mysqli_query($db, $query) === TRUE){
    return 1;
  }else {
    return 0;
  }
}


/* Functions for reservations page */
function getSavedItems($db){
  $name = "CONCAT(Year, ' ', Make, ' ', Model) AS Vehicle";
  $condition = "WHERE Customer_id = '{$_SESSION['valid_user']}' AND VIN = Car_selected";
  $condition .= " AND Form_status = 'saved' AND Availability='y'" ;
  $queryBooking = "SELECT $name, Booking_no AS `Booking ID`, Cost FROM VEHICLE, BOOKING $condition";
  return mysqli_query($db, $queryBooking);
}
/*  General methods  */

    function Update($db, $table, $record, $pk){
        //record should be an associative array
        //primary key is an index array
        //Table is the name of the table to modify
        //db is the db connection handler
        $values = [];
        $cond = 'WHERE '.$pk[0]."='{$pk[1]}'";
        foreach ($record as $k=>$v){
            array_push($values, "$k='$v'");
        }
        $values = implode(", ", $values);

        $update = "UPDATE $table SET $values $cond";
        if(mysqli_query($db, $update) === TRUE){
            return 1;
        }else {
            return 0;
        }
    }

 ?>
