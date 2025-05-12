<?php 
include "taskFunktionen.php";

session_start();


$link = connectDb("hierarchie","hierarchieuser");
if(empty($link)) {
  die("no connection");
 }
 
 
$PHP_SELF = $_SERVER['PHP_SELF'];
$myGlobals = array(
		   "targetId"    => 0,
		   "sourceId"    => 0,
	  );


foreach ($myGlobals as $key => $value) {
  if(isset($_REQUEST[$key])) {
    $$key = $_REQUEST[$key];
  } else {
    $$key = $value;
  }

}

$sql = "SELECT leave_id from leaveTable where leave_id = $sourceId";

$sourceId = getOne($sql);

if(empty($sourceId)) {
	die("SourceID  nicht da");;
}

$sql = "SELECT id from catTree where id = $targetId";
$targetID = getOne($sql);

if(empty($targetId)) {

	die("targetID nicht da");
}

$sql = "UPDATE leaveTable SET cat =$targetId WHERE leave_id = $sourceId";

mysqli_query($link, $sql);

