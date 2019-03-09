<?php
/* List of functions utilized in the making of this project*/

function redirect($role){
    switch ($role){
        case 1:
            header('Location: '.HOMEURL.'owner/');
            break;
        case 2:
            header('Location: '.HOMEURL.'db_admin/');
            break;
        case 3:
            header('Location: '.HOMEURL.'employee/');
            break;
        case 4:
            header('Location: '.HOMEURL.'client/');
            break;
        default:
            echo "Check data type";
    }
}

/* Return a message for when access is denied */
function denyAccess($link = HOMEURL){
  return '<div class="container">
  <h1>ACCESS DENIED</h1>
  <a class="btn btn-dark" href="'.$link.'"
  role="button">Go Back</a> </div>';
}

/* Return a message for when access is granted */
function grantAccess($someReference, $user = 'User'){
  return '<div class="container">
  <h1>Welcome '.$user.' !</h1>
  <a class="btn btn-dark" href="'.$someReference.'"
  role="button">Log Out</a> </div>';
}

/* Returns a button with default arguments if not specified*/
function getBtn($link = HOMEURL, $name = 'Go to login'){
  return '<a class="btn btn-dark" href="'.$link.'">'.$name.'</a>';
}

/*  This function validates that the user has logged in  */
function checkLog(){
  if(!isset($_SESSION['valid_user']) || $_SESSION['Role']!=4){
    /* if user has not logged in */
    echo denyAccess();
    exit;
  }

}

/*  This function validates login from main index page to the
 *  appropriate index.
 */
function indexAcces(){
  if(isset($_POST['username']) && isset($_POST['password'])){
      // echo "Post is set";
      //if the user come from log in
      $userID = validateInput($_POST['username']);
      $userPass = validateInput($_POST['password']);
      //connection with db and query the user input
      require(P.'credentials.php');
      $query = 'SELECT * FROM PERSON '.
      "WHERE Username ='$userID' AND ".
      "Pass = '$userPass'";
      $result = mysqli_query($db, $query);
      if(mysqli_num_rows($result) > 0){
          $record = mysqli_fetch_assoc($result);
        //add userID to cookie if found in the DB
        $_SESSION['valid_user'] = $userID;
        $_SESSION['Role'] = $record["Role"];
        //free the results and close the session
        mysqli_free_result($result);
        mysqli_close($db);
      } else{
        // LOAD DENY MESSAGE
        echo denyAccess();
        exit;
      }
  }elseif (!isset($_SESSION['valid_user'])) {
      //if there is no credentials inside the cookies
      echo denyAccess();
      exit;
  }
}


/*  Wrap something around a centered row  */
function centerRow($data){
  return '<div class="row justify-content-center">
  '.$data.'</div>';
}

/*  Wrap some text around p tags */
function h($text, $size, $weight = 'light'){
  return '<p  class="font-weight-'.$weight.'" style="font-size: '.$size.'px;">'."$text</p>";
}

/*  Get an empty div for spacing  */
function ediv($height){
  echo '<div class="w-100 p-3" style="height:'.$height.'px;"></div>';
}

/*  Protect against XSS */
  function validateInput($input){
    return htmlspecialchars($input);
  }

  /*  Print the select group for the client index page*/
  function index_Select($selected = 'Search By'){
    //Selected is the option to be selected when page loads
    //The options for this form
    $options = ["Search By", "Year", "Make", "Model"];
    $opt = '';
    for ($i=0; $i < count($options) ; $i++) {
      if(strcmp($selected, $options[$i]) == 0){
        $opt .= index_option($options[$i], 1);
      } else {
        $opt .= index_option($options[$i], 0);
      }
    }
    return '<div class="form-group mx-sm-3 mb-2">'.
      '<select name="searchBy" class="form-control">'.$opt.'</select></div>';
  }

  function index_option($option, $flag){
    if ($flag) {
      $theResult = "<option value=\"$option\" selected >$option</option>";
    }else {
      $theResult = "<option value=\"$option\">$option</option>";
    }

    return $theResult;
  }

  function retrieveCards($name, $picture, $specs, $VIN){
    $counter = 0;
    $row = [];
    while ($recordTable = mysqli_fetch_assoc($specs)) {
      //while there is a record store them in record*
      // Get the records:
      $recordName = mysqli_fetch_row($name);
      //make array into a string
      $recordName = implode(" ", $recordName);

      $recordPicture = mysqli_fetch_row($picture);
      //retrieve the image's path
      $recordPicture =  HOMEURL.implode($recordPicture);

      $VINnumber = mysqli_fetch_row($VIN);
      $VINnumber = implode($VINnumber);

      //Information to transfer to the process page
      $info["title"] = $recordName;
      $info["picture"] = $recordPicture;
      $info["price"] = $recordTable["Price"];
      $info["vin"] = $VINnumber;


      /* The following arrays only have 3 elements, every time
       * they get their third element assigned the row array will
       * be printed out. What's being accomplished here is that
       * the data is being wrapped with html code that produces
       * the table.
      */
      $i = $counter % 3;
      $tableRows[$i] = getTableRows($recordTable);
      //http_build_query transfors an array into transferrable $_GET stuff
      $table[$i] = getTable($tableRows[$i], 'show.php?'.http_build_query($info));
      $card[$i] = getCard($recordPicture, $recordName, $table[$i]);
      $column[$i] = getColumn($card[$i], 4, 1);
      $counter++;
      if($counter % 3 == 0){
        //When we got 3 columns ready push to row array
        //implode returns the contents of an array as a
        //string.
        array_push($row,getRow(implode(' ', $column)));

        //Reason why i empty the column array  is because
        //later on if the column is set it means that there
        //are some elements that have not been added to the
        //row array and thus we need to add them
        unset($column);
      }

    }
    if(isset($column)){
      //push the remaining columns to the row
      array_push($row, getRow(implode('', $column)));
    }

    //output the rows and their content
    for($c = 0; $c < count($row); $c++){
      echo $row[$c];
    }
  }

  function savedTable($results, $db = ''){
    $row = [];
    $style = 'style="padding-right: 35px;" ';
    $s = $style.' class="font-weight-bold"';
    $del_class = 'class="btn btn-outline-danger"';
    $proc_class = 'class="btn btn-outline-primary"';
    $continue = ['fromSaved'=>1]; //array to pass information
    array_push($row, tr(td('Name', $s).td('Booking number',$s).td('Cost',$s)));
    while($record = mysqli_fetch_assoc($results)){
      foreach ($record as $key => $value) {
        if(strcmp('Cost', $key) == 0){
          setlocale(LC_MONETARY, 'en_US');
          $value = money_format('%.2n',$value);
        }
        $content[$key] = td($value, $style);
        $continue['name'] = $record['Vehicle'];
        $continue['booking'] = $record['Booking ID'];
        $continue['cost'] = $record['Cost'];
      }
      $deleteBtn = HOMEURL.'/client/reservations.php?del='.$record['Booking ID'];
      $processBtn = HOMEURL.'client/process.php?'.http_build_query($continue);
      $content['delete'] = td(customLink($deleteBtn, $del_class,'Delete'));
      $content['process'] = td(customLink($processBtn, $proc_class,'Continue Order'));
      array_push($row, tr(implode(" ", $content)));
    }
    return table(implode("", $row));
  }

  function historyTable($results){
    while($record = mysqli_fetch_assoc($results)){
        foreach($record as $k=>$v) {
            echo "$k: $v <hr/>";
        }
    }
  }

  function customLink($ref, $op='', $msg='Click me'){
    return "<a $op href=\"$ref\">$msg</a>";
  }

  function td($data, $op = ''){
    return "<td $op> $data </td>";
  }

  function tr($data, $op = ''){
    return "<tr $op> $data </tr>";
  }

  function table($data, $opt = ''){
    return "<table $opt> $data </table>";
  }

  /*  Returns an image. You need to feed it a location where the image is*/
  function getImage($link){
    return "<img class=\"img-thumbnail no-resize \" src=\"$link\">";
  }

  /*  Returns a button. Parameters are the link where it will go and what the button will say */
  function getButton($link, $message = 'Rent Now'){
    return '<a href="'.$link.'" class="btn btn-dark">'.$message.'</a>';
  }

  /* Function to generate a random booking number*/
  function booking(){
    return RandomNums(4).'-'.RandomNums(5);
  }

  /* Generates a random receipt number */
  function receipt(){
    return RandomNums(2).RandomLetters(3).RandomNums(3).RandomLetters(2);
  }
  /* Generates a string of random numbers, you specified the length of the string */
  function RandomNums($howMany){
    $result ="";
    for ($i=0; $i < $howMany; $i++) {
      $result .= rand(0,9);
    }
    return $result;
  }

  /* Generates a string of n random characters  */
  function RandomLetters($n){
    //n reflects the number of random letters to be returned
    $rLetters = '';
    for ($i=0; $i < $n; $i++) {
      $rLetters .= chr(rand(65,90));
    }
    return $rLetters;
  }
  /*  Generates a simple row  */
  function simpleRow($k, $v, $styles = ['']){
    return '<tr><td style="'.implode(" ", $styles).'">'.$k.'</td><td>'.$v.'</td</tr>';
  }

  function hiddenInput($name, $value){
    return '<input class="collapse" type="text" name="'.$name.'" value="'.$value.'">';
  }
 ?>
