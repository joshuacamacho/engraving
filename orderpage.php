<?php
	require_once("connect.php");
	require_once("core.php");
	if(isset($_GET['order']) && loggedin()){
		$ordernum=mysqli_real_escape_string($link,$_GET['order']);
		$query="SELECT * from orders WHERE orderid='".$ordernum."'";
		$result=$link->query($query);
		$orderinfo=mysqli_fetch_array($result);
		$query="SELECT * from users WHERE userid='".$orderinfo['userid']."'";
		$result=$link->query($query);
		$userinfo=mysqli_fetch_array($result);
		$query="SELECT * from items WHERE itemid='".$orderinfo['itemid']."'";
		$result=$link->query($query);
		$iteminfo=mysqli_fetch_array($result);
		if($orderinfo['userid']==$_SESSION['userid'] || isAdmin()){

		}else{
			header("location: ./");
		}
	}else{
		header("location: ./");
	}

	include_once("header.php");



?>
<div id="content">
    
   	  <div id="content_left">
        	<?php 
        		echo "Order for ";
        		echo "<div>".$userinfo['firstname']." ".$userinfo['lastname']."</div>";
        	?>

             
    	</div> 
    	<!-- end of ocntent left -->
        
        
        <div class="spacer">&nbsp;</div>
    </div>






<?php


	include_once("footer.php");

	

?>