<?php
define("DEIMG", 'https://images.pexels.com/photos/116675/pexels-photo-116675.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');
  function getRow($data){
    return '<div class="row justify-content-around m-2">'.$data.'</div>';
  }

  function getColumn($element, $size, $times = 1){
    $result = '';
    for ($i=0; $i < $times; $i++) {
      $result .= '<div class="col-'.$size.' space-card">'.$element.'</div>';
    }
    return $result;
  }

  function getCard($img, $title, $table){

    return '<div class="card" style="width: 20rem;">'.
          '<img class="card-img-top img-thumbnail no-resize" '.
          'src="'.$img.'"> <div class="card-body">'.
          '<h5 class="card-title">'.$title.'</h5>'.
          $table.'</div></div>';
  }

  //create each row displaying
  function getTable($rows, $link){
    $button = getButton($link);
    return '<table class="spacing">'.$rows.'</table>'.$button;
  }

  //Create each row displaying information
  function getTableRows($info){
    $rowList = '';
    foreach ($info as $key => $value) {
      if(strcmp($key, 'Price') == 0){
        $rowList .= '<tr>'.
        '<td>'.$key.'</td>'.
        '<td>$'.$value.'</td>'.//add dollar sign
        '</tr>';
      }
      else {
        $rowList .= '<tr>'.
        '<td>'.$key.'</td>'.
        '<td>'.$value.'</td>'.
        '</tr>';
      }

    }
    return $rowList;
  }
?>
