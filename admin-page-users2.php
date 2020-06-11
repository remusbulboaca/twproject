<?php require_once('includes/functions/function.php') ;
include ('includes/functions/config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin-page-users.css">
    <title>Admin Panel</title>
    <head>
</head>
<style>
    
    .dash{
        cursor:pointer;
    }
</style>
<body>

<?php if(admin()==true){
                       
                    }
                    else{
                        redirect('profile-personal-details.php');
                    }?>
    <div class="all">
        <div class="left">
            <div class="logo">
            <a href="">COLR <span>Admin panel</span></a>
            </div>
            <div class="menu_mobile">
            <div class="dash">
                    <h2 onclick="location.href='admin-panel.php' ">Dashboard</h2></div>
                <div class="dropdown">
                <button onclick="myFunction2()" class="dropbtn"> Members</button>
  <div id="myDropdown2" class="dropdown-content">
                <a href="admin-page-users.php">Users</a>
                <?php if(gm()==true){ ?>
                            <a href="admin-page-admins.php">Admins</a>
                            <?php } ?>
                            
                            <a href="">Add user</a>
                            <?php if(gm()==true){ ?>
                            <a href="admin-page-add-admin.php">Add admin</a>
                            <?php } ?>
                </div>
                </div> 
                
                <div class="dropdown">
  <button onclick="myFunction()" class="dropbtn">Products</button>
  <div id="myDropdown" class="dropdown-content">
  <a href="admin-view-products.php">View products</a>
                            <a href="admin-view-favorite.php">View favorites</a>
                            <a href="admin-pending-products.php">Pending</a>
  </div>
</div>

                <h2>Database</h2>
                
                </div>

                <div class="menu">
                    <div class="dash">
                    <h2 onclick="location.href='admin-panel.php' ">Dashboard</h2></div>
                    <h2>Members</h2>
                        <div class="members">
                            <a href="admin-page-users.php">Users</a>
                            <?php if(gm()==true){ ?>
                            <a href="admin-page-admins.php">Admins</a>
                            <?php } ?>
                            
                            <a href="">Add user</a>
                            <?php if(gm()==true){ ?>
                            <a href="admin-page-add-admin.php">Add admin</a>
                            <?php } ?>
                            
                        </div>
                    <h2>Products</h2>
                        <div class="products">
                        <a href="admin-view-products.php">View products</a>
                            <a href="admin-view-favorite.php">View favorites</a>
                            <a href="admin-pending-products.php">Pending</a>
                        </div>
                    <h2>Database</h2>
                        <div class="db">
                        <a href="admin-export.php">Export/Import database</a>
                        </div>
                </div>
        </div>

        <div class="right">
            
            <h1>users</h1>
            <div class="search">
            <input type="text" name="search" id="EchoInput" onblur="getInput(this.value)" placeholder="Search name">
            </div>
           
            
                  
            <?php
             
            $sql = "select * from users where admin='0'";
            $result = query($sql);
            confirm($result);
            ?>
            
            <div class="table-div">
            <?php  
            if(isset($_POST['submitDeleteBtn'])){
                $id=$_POST['keyToDelete'];
                delete_account_ajax($id);
            }
            ?>  
            <table id="table-data">
            <thead>
                    <tr>
                        <th>id</th>
                        <th>email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Validation Code</th>
                        <th>activeUser</th>
                        <th>Profile Image</th>
                        <th>Select </th>
                        <th>Delete </th>
                    </tr>
                    
                </thead> 
                <tbody>
                    <?php while($row=fetch_data($result)){
                    ?>
                    <tr>
                     <form action="" method="post" role="form">  
                    <td><?= $row['id'];?></td>
                    <td><?= $row['email'];?></td>
                    <td><?= $row['firstName'];?></td>
                    <td><?= $row['lastName'];?></td>
                    <td><?= $row['username'];?></td>
                    <td><?= $row['validationCode'];?></td>
                    <td><?= $row['activeUser'];?></td>
                    <td><?= $row['profileImage'];?></td>
                    <td>
                        <input type="checkbox" name="keyToDelete" value="<?php echo $row['id']; ?> required">
                    </td>
                    <td>
                        <input type="submit" name="submitDeleteBtn" id="submitDeleteBtn" class="btn">
                    </td>
                    </form> 
                    </tr>
                    <?php }?>
                </tbody>  
                
            </table>
            <div id='buttons' class="buttons"></div>
            </div>
            
        </div>
    </div>
</body>


<script type="text/javascript">
    function getInput(input) {
        const xhr=new XMLHttpRequest();
        xhr.onload=function(){
            
            const serverResponse=document.getElementById("table-data");
            serverResponse.innerHTML=this.responseText;
            document.getElementById("buttons").innerHTML = "";
            pagination(document.getElementById("table-data").rows.length);
        }

    xhr.open("POST","ajax-users.php");
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("name="+input)
    
    }




function pagination($rowCount1){
    document.getElementById("buttons").innerHTML = "";
// get the table element
var $table = document.getElementById("table-data"),
// number of rows per page
$n = 10,
// number of rows of the table
$rowCount = $rowCount1,
// get the first cell's tag name (in the first row)
$firstRow = $table.rows[0].firstElementChild.tagName,
// boolean var to check if table has a head row
$hasHead = ($firstRow === "th"),
// an array to hold each row
$tr = [],
// loop counters, to start count from rows[1] (2nd row) if the first row has a head tag
$i,$ii,$j = ($hasHead)?1:0,
// holds the first row if it has a (<TH>) & nothing if (<TD>)
$th = ($hasHead?$table.rows[(0)].outerHTML:"");
// count the number of pages
var $pageCount = Math.ceil($rowCount / $n);
// if we had one page only, then we have nothing to do ..
if ($pageCount > 1) {
	// assign each row outHTML (tag name & innerHTML) to the array
	for ($i = $j,$ii = 0; $i < $rowCount; $i++, $ii++)
		$tr[$ii] = $table.rows[$i].outerHTML;
	// create a div block to hold the buttons
	// the first sort, default page is the first one
	sort(1);
}

// ($p) is the selected page number. it will be generated when a user clicks a button
function sort($p) {
	/* create ($rows) a variable to hold the group of rows
	** to be displayed on the selected page,
	** ($s) the start point .. the first row in each page, Do The Math
	*/
	var $rows = $th,$s = (($n * $p)-$n);
	for ($i = $s; $i < ($s+$n) && $i < $tr.length; $i++)
		$rows += $tr[$i];
	
	// now the table has a processed group of rows ..
	$table.innerHTML = $rows;
	// create the pagination buttons
	document.getElementById("buttons").innerHTML = pageButtons($pageCount,$p);
	// CSS Stuff
	document.getElementById("id"+$p).setAttribute("class","active");
}


// ($pCount) : number of pages,($cur) : current page, the selected one ..
function pageButtons($pCount,$cur) {
	/* this variables will disable the "Prev" button on 1st page
	   and "next" button on the last one */
	var	$prevDis = ($cur == 1)?"disabled":"",
		$nextDis = ($cur == $pCount)?"disabled":"",
		/* this ($buttons) will hold every single button needed
		** it will creates each button and sets the onclick attribute
		** to the "sort" function with a special ($p) number..
		*/
		$buttons = "<input type='button' value='&lt;&lt; Prev' onclick='sort("+($cur - 1)+")' "+$prevDis+">";
	for ($i=1; $i<=$pCount;$i++)
		$buttons += "<input type='button' id='id"+$i+"'value='"+$i+"' onclick='sort("+$i+")'>";
	    $buttons += "<input type='button' value='Next &gt;&gt;' onclick='sort("+($cur + 1)+")' "+$nextDis+">";
	return $buttons;
}
}

    
    
    
</script>

<!--PAGINATION-->
<script type="text/javascript" src="admin-page-users.js"></script>
<!--DROPDOWN-->
<script type="text/javascript" src="js/dropdown.js"></script>



</html>