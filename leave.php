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
                   "newLeaveTitle"    => "",
		   "newLeaveDescription" => "",
		   "action"      => ""
	  );


foreach ($myGlobals as $key => $value) {
  if(isset($_REQUEST[$key])) {
    $$key = $_REQUEST[$key];
  } else {
    $$key = $value;
  }

}
#print_r($_REQUEST);
#print_r($_SESSION);
#print_r($myGlobals);


if(!empty($action)) {

  if($action == "new") {
#  print "action $action";
    if( true or $_SESSION['handle'] ) {
      
      $sql = "INSERT INTO leaveTable SET  title= '$newLeaveTitle', description='".AddSlashes($newLeaveDescription)."',cat=$parentID";

      
    $result = sql_query($link,$sql);
    
# print "result $result";
   print sql_error($link);

    $_SESSION['handle']  = 0;
    } else {
#    print "no handle";
    }
  } else {
    $_SESSION['handle'] = 1;

  }

 } else {
  $_SESSION['handle'] = 1;

 }


if(!empty($parentID)) {

  $sql = "select label from catTree where id = $parentID";

#  print $sql;

  $parentLabel = getOne($sql);


  

 
 }

$sql = "select leave_id,title,description from leaveTable where cat = $parentID";
#print "$query";

$items = array();
$result = sql_query($link,$sql);

if($result) {

  while($row = sql_fetch_row($result)) {
    list($leave_id,$title, $description) = $row;
    
    $items[] = array("leave_id"    => $leave_id,
		     "title" => AddSlashes($title),
		     "description" => AddSlashes($description)
   );
  }
 } else {
  print sql_error();
 }


$ancestor_string = getAncestorString($parentID);

$params = array("items"    => $items,
                "handle"          => $_SESSION['handle'],
		"parentLabel"     => $parentLabel,
                "parentID"              => $parentID,
                "ancestor_string" => $ancestor_string,
     );

#print_r($params);

echo new div('leave.tpl', $params);

