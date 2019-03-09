<?php
if(isset($_POST['searchText'])){
  $searchValue = htmlspecialchars($_POST['searchText']);
}
$searchField = $_POST['searchBy'];
?>
<div class="container">
<?php
  echo centerRow(h('Welcome to Coche', 60, 'normal'));
  echo centerRow(h('The new way to rent cars', 35));
  ediv(100);
  echo centerRow(h('Find the car of your dreams:', 25));
 ?>
  <div class="row justify-content-center">
    <form action="" method="post">
          <div class="form-inline">
            <div class="form-group mb-2">
              <input class="form-control moreSpace" type="text" name="searchText" value="<?php if(isset($searchValue)){echo $searchValue;} ?>" placeholder="Search">
            </div>
            <?php echo index_Select($searchField);//print the select form ?>
            <input class="btn btn-primary" type="submit" name="submit" value="Search">
          </div>
    </form>
  </div>

<?php
  if(isset($_POST['searchText']) && isset($_POST['searchBy'])){
    ediv(100);
    if(!get_magic_quotes_gpc()){
      $searchBy = validateInput($_POST['searchBy']);
      $searchText = validateInput($_POST['searchText']);
    }
    require(P.'credentials.php');
    $cond = "WHERE $searchBy LIKE '%$searchText%' AND Availability=\"y\"";
    $sort = "ORDER BY $searchBy";

    $queryName = 'SELECT Year, Make, Model FROM VEHICLE '.$cond." $sort";
    $resultName = mysqli_query($db, $queryName);
  

    $queryImg = 'SELECT Picture FROM VEHICLE '."$cond $sort";
    $resultImg = mysqli_query($db, $queryImg);
  
    $queryTable = 'SELECT Mileage, Transmission, ';
    $queryTable .= 'Max_Passengers AS \'Number of Passenger\', ';
    $queryTable .= 'Base_price AS Price FROM VEHICLE ';
    $queryTable .= "$cond $sort";
    
    $resultTable = mysqli_query($db, $queryTable);

    $queryVIN = "SELECT VIN FROM VEHICLE $cond $sort";
    $resultVIN = mysqli_query($db, $queryVIN);

    retrieveCards($resultName, $resultImg, $resultTable, $resultVIN);
  }

?>
</div>
