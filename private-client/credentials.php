<?php
define("USERNAME", 'perdomoh_groot');
define("PASS", 'tomatosauce34');
define("DB", 'perdomoh_Coche');
define("H", 'localhost');

//Create connection to Data Base
$db = @mysqli_connect(H, USERNAME, PASS, DB);
if(!$db){
   die('Connect Error: ' . mysqli_connect_error());
}
?>
