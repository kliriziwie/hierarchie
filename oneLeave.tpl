<html>

<head>
 <title>{$ancestor_string}</title>
</head>
<body>


<h2>{$leaveTitle}({$leaveID})</h2>


 <form action="hierarchie.php"> 
              
     	      <input type="hidden" name="parentID" value="{$parentID}">
              <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="{$parentLabel}"/>
           </form>


<form action="oneLeave.php">
  

   <table>
      <tr>
         <td> 
             <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="update"/>
         </td>
       </tr>
       <tr>
          
          <td>
              <input type="text" name="leaveTitle" value="{$leaveTitle}"/>
          </td>
       </tr>
       <tr>
          <td>
            <textarea cols="80" rows="80" name="leaveDescription">{$leaveDescription}</textarea>
          </td>
        </tr>
  

   <input type="hidden" name="parentID" value="{$parentID}"/>
   <input type="hidden" name="leaveID" value="{$leaveID}"/>
   
   </table>


</form>


        
          
        
