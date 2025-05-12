<html>

<head>
 <title>Duppletten</title>
</head>
<body>


<h2>Duppletten</h2>





     
[$items]
	<li>
           <form action="dubbes.php"> 
              {$leave_id}:{$title}:{$description}
     	      <input type="hidden" name="leaveID" value="{$leave_id}">
              <input style="height:100;bg-color:green" type="submit" name="action" value="Delete"/>
           </form>
        </li>

[/$items]