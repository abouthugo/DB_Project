<?php $page_title = "Cars" ?>
<?php require('../../private-client/initialize.php');
require (CLIENT.'head.php');
checkLog();
makeNav($page_title);
?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-7">
        <?php
        $header1 = 'We\'ve got the best deals';
        echo h($header1, 50, 'bold')
        ?>
      </div>
    </div>
    <?php require(P.'credentials.php');
          /* THE SQL STATEMENTS */
          $sort = 'ORDER BY VIN ';
          $condition = 'WHERE Availability = "Y"';

          $queryTable = 'SELECT Mileage, Transmission, ';
          $queryTable .= 'Max_Passengers AS \'Number of Passenger\', ';
          $queryTable .= 'Base_price AS Price FROM VEHICLE ';
          $queryTable .= $condition.$sort;

          $queryName = 'SELECT Year, Make, Model FROM VEHICLE ';
          $queryName .= $condition.$sort;

          $queryPicture = 'SELECT Picture FROM VEHICLE ';
          $queryPicture .= $condition.$sort;

          $queryVIN = "SELECT VIN FROM VEHICLE $condition $sort";
            
          /************************/

          /*  Retreiving Information  */
          $resultTable = mysqli_query($db, $queryTable);
          $resultName = mysqli_query($db, $queryName);
          $resultPicture = mysqli_query($db, $queryPicture);
          $resultVIN = mysqli_query($db, $queryVIN);
          /************************/

          //See funcs.php to see how this function works
          //Summary: it prints the info according to the query results
          retrieveCards($resultName, $resultPicture, $resultTable, $resultVIN);

          //return resources
          mysqli_free_result($resultTable);
          mysqli_free_result($resultName);
          mysqli_free_result($resultPicture);
          //close the connection
          mysqli_close($db);
    ?>
  </div>

<?php require_once(CLIENT . 'tidy-up.php'); ?>
