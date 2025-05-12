<?php 

include "div.php";
include "taskFunktionen.php";

session_start();


$link = connectDb("hierarchie","hierarchieuser");
if(empty($link)) {
  die("no connection");
 }
$PHP_SELF = $_SERVER['PHP_SELF'];
$myGlobals = array(
		   "parentID"    => 0,
		   "search" => "r",
		   "action"      => "",
		  
	  );


foreach ($myGlobals as $key => $value) {
  if(isset($_REQUEST[$key])) {
    $$key = $_REQUEST[$key];
  } else {
    $$key = $value;
  }

}

$sql = "select leave_id,title,description from leaveTable where title like '%$search%' or description like '%$search%'";



$result = sql_query($link,$sql);

$items = array();

if($result) {
	
	
	while($row = sql_fetch_row($result)) {
    list($leave_id,$title,$description) = $row;
	
	$items[] = array(
	      'leave_id' => $leave_id,
		  'title' => $title,
		  'description' => htmlentities($description),
		  );
	
	

    };
	
	
} else {
	print "no result";
}



$params = array('items' => $items);

echo new div('search.tpl', $params);