<?php
	require_once("connect.php");

	//log the user in if login form was used
	if(isset($_POST['email']) && isset($_POST['password'])){
			$email=mysqli_real_escape_string($link,$_POST['email']);
			$password=sha1(mysqli_real_escape_string($link,$_POST['password']));
			$query="SELECT password,userid FROM users WHERE email='".$email."'";
			$result = $link->query($query);
			while($row=mysqli_fetch_array($result)){
				if($password == $row['password']){
					session_start();
					$_SESSION['userid']=$row['userid'];
					header("Location: ./profile.php");
				}
			}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Timeless Pieces</title>
<meta name="keywords" content="watches, engraving, jewelry, business" />
<meta name="description" content="Company Name is an engraving company that can customize watches for personal and business use" />
<head>
	<link href="css/main_style.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery.jcarousel.pack.js" type="text/javascript"></script>
<script src="js/jquery-func.js" type="text/javascript"></script>
</head>

<?php


	echo "<div id='container'>
				<div id='top_panel'>
    	<div id='socialmedia'>
			<a href='#'><img src='images/twitter.png' alt='twitter icon' /></a>
            <a href='#'><img src='images/facebook.png' alt='facebook icon' /></a>
            <a href='#'><img src='images/instagram.png' alt='instagram icon' /></a>
            <a href='#'><img src='images/yelp.png' alt='yelp icon' /></a>
            
        </div>
        <!--space holder for shopping cart-->
        <div id='shopping_cart'>Shopping Cart <span>(<a href='#'>0 items</a>)</span></div>
</div>";

?>

<div id="menu_panel">
        <ul>
            <li><a href="./" class="page">Home</a></li>
            <li><a href="catalog.php">Catalog</a></li>
            <li><a href="about.php">About Us</a></li>  
            <li><a href="contact.php">Contact Us</a></li> 
                                 
        
  


<?php


	if(isset($_SESSION['userid'])){
		echo "<li><a href='profile.php'>Profile</a></li>
					<a href='cart.php'><li>Cart</li></a>
					<a href='logout.php'><li>Log Out</li></a>
					</ul>";
	}else{
	 		echo "<li><a href='register.php'>Register</a></li>
						</ul>";

			echo "
				<form action='' method='post'>
				<input type='text' name='email' placeholder='email'>
				<input type='password' name='password' placeholder='&#9679;&#9679;&#9679;&#9679;&#9679;'>
				<input type='submit' value='Login' class='loginbutton'>
				</form>
				
				
				";
				echo "</div>";

	  }
	  

?>

