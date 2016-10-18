<?php
// Function for printing out error messages
function errorMsg($keyName, $label) {

  // PHP checks whether certain keys have been returned with values in the GET Global Super Array, if it has then echo the value into the input field

  if(isset($_GET[$keyName]) && $_GET[$keyName] === '') {

    return "<div class='warning_msg'>Please enter " . $label . ".</div>";

  }

} // End of function errorMsg

// Displays values already entered in for input field
function prevInput($keyname){

  if($_GET[$keyValue] !== '') {

    return $_GET[$keyValue];

  }

} // End of function displayTxt

function setupInput($keyname, $dbname){

  if(isset($_GET[$keyname])) {
    echo prevInput($keyname);
  } elseif (isset($rs_news_rows[$dbname]) && $rs_news_rows[$dbname] !== 'na'){
    echo $rs_news_rows[$dbname];
  }
}



?>
