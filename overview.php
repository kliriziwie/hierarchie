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
		   
	  );


foreach ($myGlobals as $key => $value) {
  if(isset($_REQUEST[$key])) {
    $$key = $_REQUEST[$key];
  } else {
    $$key = $value;
  }

}

$tree_array = array(); 

treeToArray(0,array(),$tree_array);

//print_r($tree_array);

$tree_array = display($tree_array);

print_r($tree_aray);
$params = array("tree_array"    => $tree_array,
          );

#print_r($params);

echo new div('overview.tpl', $params);





function treeToArray($parent,$ancestors,&$tree_array,$indent = " ") {
	
	$sql = "SELECT id,label from catTree where parent = $parent";
	
	
	
	$indent .= "#";
	
	print "indent $indent $sql\n";
	$mysql_result = mysql_query($sql);
	
	$ancestors_sub = $ancestors;
	array_push($ancestors_sub,$parent);
	$found = 0;
	
	$result = array();
	
	while($data = mysql_fetch_array($mysql_result)) {
	   list($id,$label) = $data;
       print "$parent => $id/$label\n";
       $found = 1;
       treeToArray($id,$ancestors_sub,$tree_array,$indent);
	   
       for($i=0;$i< count($ancestors_sub);$i++) {
		$ancestors_sub[$i] = ' ';
	   }
    }

	
	if(!$found) {
		
		array_push($ancestors,$parent);
		
		array_push($tree_array,$ancestors);
	} 
}


function display($tree_array) {
	
	#print_r($tree_array);
	
	$max_length = 0;
	
	foreach($tree_array as $tree_row) {
		if(count($tree_row) > $max_length) {
			$max_length = count($tree_row);
	    }
	}
	$new_tree_array = array();
	foreach($tree_array as $tree_row) {
	    if(count($tree_row) < $max_length) {
		    for($i = count($tree_row);$i<=  $max_length;$i++) {  
		         $tree_row[] = '-';
		   }
		   
		   
		}
		$new_tree_array[] = $tree_row;	

    }
	$new_tree_hash = array();
	foreach($new_tree_array as $row) {
		
		$new_row = array();
		foreach($row as $cell) {
	
		    if($cell == '-' or $cell == ' ') {
			  $new_cell = array('id' => -1,
			                    'label'=>'&nbsp;',
			                    'label'=>'&nbsp;',
								'leaves' => array());
	        } else {
			   $sql = "SELECT label from catTree where id = $cell";
			   $label = getOne($sql);
			   $leaves = getLeaves($cell);
			   $new_cell = array('id' => $cell,
			              'label' => $label,
						  'leaves' => $leaves);
						  
			
			
	        }
	
			$new_row[] = $new_cell;
	    }
		$new_tree_hash[] = array('row' => $new_row);
		
		
		
	}
	
	//print_r($new_tree_hash);
	return $new_tree_hash;
}

function getLeaves($cat) {
	
	$sql = "SELECT leave_id,title,description from leaveTable where cat=$cat";
	
	
	$result = mysql_query($sql);
	
	if(!$result) {
	   return array();
	}
	$leaves = array();
	while($data = mysql_fetch_array($result)) {
		list($leave_id,$title,$description) = $data;
		
		$leaves[]= array('title' => $title,
		                 'description' => $description,
						 'leave_id'    => $leave_id);
		
    }
	
	return $leaves;
	
}