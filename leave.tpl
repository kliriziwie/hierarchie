<html>

    <head>
        <title>Bl&auml;tter von {$ancestor_string}</title>
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

        <form action="hierarchie.php"> 

            <input type="hidden" name="parentID" value="{$parentID}">
            <input style="height:100;width:100;bg-color:green" type="submit" name="action" value="{$parentLabel}"/>
        </form>
        
        
        <table>
        [$items]
        
        <tr>
            <td>
                {$title}  
            </td>
            <td>
               
                 <pre>
			   {$description}
                 </pre>
                  <a href="oneLeave.php?parentID={$parentID}&leaveID={$leave_id}">Edit</a>
            </td>
            
        </tr>
    
       
    

        [/$items]
        </table>

        