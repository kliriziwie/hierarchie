<html>

<head>
 <title>Bl&auml;tter</title>
</head>
<body>


<h2>{$parentLabel}({$parentID})</h2>


<form>
 

   <table>
      <tr>
         <td> 
             <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="new"/>
         </td>
       </tr>
       <tr>
          
          <td>
              <input type="text" name="newLeaveTitle" placeholder="title" />
          </td>
          <td>
            <textarea name="newLeaveDescription" placeholder="Description"></textarea>
          </td>
        </tr>
   </table>

   <input type="hidden" name="parentID" value="{$parentID}"/>


</form>



        <li>
           <form action="hierarchie.php"> 
              
     	      <input type="hidden" name="parentID" value="{$parentID}">
              <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="{$parentLabel}"/>
           </form>
        </li>
[$items]
	<li>
           <form action="oneLeave.php"> 
              <input style="height:100;bg-color:green" type="submit" name="action" value="{$title}:{$description}"/>
     	      <input type="hidden" name="parentID" value="{$parentID}">
     	      <input type="hidden" name="leaveID" value="{$leave_id}">
           </form>
        </li>

[/$items]