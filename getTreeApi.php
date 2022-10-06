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


$sql = "select id,label from catTree where parent=$parentID";

$mysql_result = mysqli_query($link, $sql);

$result = array();
	
while($data = mysqli_fetch_array($mysql_result)) {
	list($id,$label) = $data;
	
	$sql = "select count(*) from catTree where parent=$id";
	$count = getOne($sql);
	
	$hasChildren = false; 
	
	if($count) {
		$hasChildren = true;
    }
	
	
	$sql = "select count(*)  from leaveTable where cat = $id ";
	
	

   

     $count = getOne($sql);
	 
	 if($count) {
		$hasChildren = true;
    }
	
	//[{"Name":"Accordion","ChildrenUrl":"/api/demo-component-demos/Accordion/Accordion","HasChildren":true},
	
	$row = array(
	    //"text" => $label,
		"Name" => $label.'('.$id.')',
		"ChildrenUrl" => "getTreeApi.php?parentID=$id",
		"HasChildren" => $hasChildren,
		"id" => $id,
		"href" => "hierarchie.php?parentID=$id",
		"target" => "_blank",
		"kind" => "category",
		);
		
    array_push($result,$row);
	
}

$sql = "select count(*)  from leaveTable where cat = $parentID";



$count = getOne($sql);

if($count) {
	$row = array(
	    //"text" => $label,
		"Name" => "Bl&auml;tter",
		"ChildrenUrl" => "getLeaveApi.php?parentID=$parentID",
		"HasChildren" => "true",
		"id" => $parentID,
		"href" => "leave.php?parentID=$parentID&action=Blätter",
		"target" => "_blank",
		"kind" => "category",
		);
	array_push($result,$row);
}







print json_encode($result);
