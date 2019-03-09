<?php
    require '../private-client/initialize.php';
    /*
     * If the user tries to log in again it should be redirected
     * to its correct destination
     */
    if (isset($_SESSION['valid_user']) && isset($_SESSION['Role']))
        redirect($_SESSION['Role']);
  if(isset($_POST['Submit'])){
    //if the user tries to log in
    $username = $_POST['username'];
    $password = $_POST['password'];
    //connection with db and query the user input
    require(P.'credentials.php');
    $query = "SELECT `pass`, `role` FROM PERSON WHERE `username`='$username'";

    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0){
      $record = mysqli_fetch_assoc($result);
        if(password_verify($password, $record['pass'])){
            //if there is a valid password:
            $_SESSION['valid_user'] = $username;
            //add role to cookie
            $_SESSION['Role'] = $record['role'];
            //free the results and close the session
            mysqli_free_result($result);
            mysqli_close($db);
            //redirect according to the role
            redirect($_SESSION['Role']);
        }else{
            echo denyAccess(HOMEURL);
        }
    }else {
        require(CLIENT.'head.php');
      echo denyAccess(HOMEURL);
    }
  }
  else {
     $page_title = 'Log in'; //set title of page
     require_once (CLIENT.'head.php'); //html
    //Else load the login page
    require(CLIENT.'login.php');  //Load login form
    require(CLIENT . 'tidy-up.php');  //close tags
  }
?>