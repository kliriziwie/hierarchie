<html>

<head>
 <title>Hierarchie der Gedanken</title>
</head>
<body>


<h2>{$parentLabel}({$parentID})</h2>

<table>
   <tr>
        <!-- <td>
           <form> 
              
     	      <input type="hidden" name="parentID" value="{$grandparentID}">
              <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="Parent {$grandparentLabel}"/>
           </form>
        </td> -->
        <td>
            <form action="leave.php">
  
                <input type="hidden" name="parentID" value="{$parentID}"/>
                <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="Bl&auml;tter"/>

             </form>
	    </td>

        <td>
		  <form>
             <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="new"/> 
             <input name="newCat"></input>
		     <input type="hidden" name="parentID" value="{$parentID}" placeholder="New"/>
		  </form>
        </td>
     </tr>
</table>

	 

<table>
  <tr> 
[$ancestors]

    <td>
     <form> 
        <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="{$label}"/>
     	<input type="hidden" name="parentID" value="{$id}">
     	<input type="hidden" name="grandparentID" value="{$parentID}">
        <input type="hidden" name="grandparentLabel" value="{$parentLabel}">
     </form>
    </td>

[/$ancestors]

  </tr>
  
	<tr>
[$items]
	    <td>
           <form> 
              <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="{$label}"/>
     	      <input type="hidden" name="parentID" value="{$id}">
     	      <input type="hidden" name="grandparentID" value="{$parentID}">
              <input type="hidden" name="grandparentLabel" value="{$parentLabel}">
           </form>
        </td>

[/$items]
    </tr>
</table>