<?php

/*  CONSTANTS  */
//Button is the same for all navbars
define("BUTTON", '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span></button>');

//Homepage should be set to your homepage
define("HOMEPAGE", 'index.php');

//This is an array of the tabs you have and their respective html
define("TABS", array("Cars"=>"cars.php",
"Reservations"=>"reservations.php",
"My Account"=>"account.php",
"Contact Us"=>"contact.php",
"Log Out"=>HOMEURL.'logout.php'));

//The $activeItem should be a string corresponding to the key of one of the entries in your TABS array
function makeNav($activeItem){
  $itemList=''; // This will hold the nav items
  //You can also think of this as key=>value
  foreach (TABS as $name=>$reference){
    //strcmp($str1, $str2) compares two strings and returns 0 if they are the same
    if(strcmp($activeItem, $name) == 0)
      $itemList .= createNavItem($name, $reference, 1);
    else {
      $itemList .= createNavItem($name, $reference, 0);
    }
  }
  //I believe that nothing should be changed here unless you picked a different theme
  echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">'.
  '<a class="navbar-brand" href="'.HOMEPAGE.'">Coche</a>'.BUTTON.
  '<div class="col-6 align-self-end"> <div class="collapse navbar-collapse" id="navbarNav">'.
  '<ul class="navbar-nav">'.$itemList.'</ul></div></div></nav>';
}

function createNavItem($name, $reference, $active){
  $navItem = '<li class="nav-item"><a class="nav-link';
  if($active){
    $navItem .= ' active " ';
  }else {
    $navItem .= '" ';
  }
  $navItem .= 'href="'.$reference.'">'.$name.'</a></li>';
  return $navItem;
}

 ?>
