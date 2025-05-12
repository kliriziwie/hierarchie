<html>

<head>
 <title>{$ancestor_string}</title>
</head>
<body>


<h2>{$parentLabel}({$parentID})</h2>

    <form>
         <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="edit"/> 
         <input name="parentLabel" value="{$parentLabel}"></input>
		 <textarea name="description" rows="10" cols>{$description}</textarea>
                 
                 Old <input name="old" type="checkbox" value="1" {$oldFlag} >
		 
		 <input type="hidden" name="parentID" value="{$parentID}">
    
    </form>

<table>
   <tr>
        <!-- <td>
           <form> 
              
     	      <input type="hidden" name="parentID" value="{$parentID}">
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
		     <input type="hidden" name="parentID" value="{$parentID}" />
		  </form>
        </td>
		<td>
		  Suche auf den Blättern
		
		</td>
		<td>
		  <form action="search.php">
		     <input name="search"></input>
		     <input type="hidden" name="parentID" value="{$parentID}" />
			 <input type="submit" value="Suche">
			 
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

<a href="tree.php">Baum</a>