<html>

<head>
 <title>Ein Blat</title>
</head>
<body>


<h2>{$leaveTitle}({$leaveID})</h2>


<form>
  <li>

   <table>
      <tr>
         <td> 
             <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="update"/>
         </td>
       </tr>
       <tr>
          <td>
             Title
          </td>
          <td>
              <input type="text" name="leaveTitle" value="{$leaveTitle}"/>
          </td>
          <td>
             Description
          </td>
          <td>
            <textarea name="leaveDescription">{$leaveDescription}</textarea>
          </td>
        </tr>
   </li>

   <input type="hidden" name="parentID" value="{$parentID}"/>
   <input type="hidden" name="leaveID" value="{$leaveID}"/>


</form>


        <li>
           <form action="hierarchie.php"> 
              
     	      <input type="hidden" name="parentID" value="{$parentID}">
              <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="{$parentLabel}"/>
           </form>
        </li>
</ul>