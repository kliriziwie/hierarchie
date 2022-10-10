<?php 
include "taskFunktionen.php";

session_start();


$link = connectDb("hierarchie","hierarchieuser");
if(empty($link)) {
  die("no connection");
 }
 
 
$PHP_SELF = $_SERVER['PHP_SELF'];
$myGlobals = array(
		   "parentID"    => 0
	  );


foreach ($myGlobals as $key => $value) {
  if(isset($_REQUEST[$key])) {
    $$key = $_REQUEST[$key];
  } else {
    $$key = $value;
  }

}




$sql = "select leave_id,title from leaveTable where cat = $parentID";


$mysql_result = sql_query($link,$sql);

$result = array();
	
while($data = sql_fetch_array($mysql_result)) {
	list($leave_id,$title) = $data;
	
	$hasChildren = false;
	$row = array(
	    //"text" => $label,
		"Name" => $title.'('.$leave_id.')',
		"ChildrenUrl" => "getTreeApi.php?parentID=$leave_id",
		"HasChildren" => $hasChildren,
		"id" => $leave_id,
		"href" => "oneLeave.php?leaveID=$leave_id",
		"target" => "_blank",
		"kind" => "leave",
		);
		
   
		
    array_push($result,$row);
	
}


print json_encode($result);




