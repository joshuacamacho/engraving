<?php
	require_once("connect.php");

	//log the user in if login form was used
	if(isset($_POST['email']) && isset($_POST['password'])){
			require_once("connect.php");
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



	echo "<div class='header'>
				<ul>
				<a href='./'><li>Home</li></a>
				<a href='catalog.php'><li>Catalog</l1></a>";
	if(isset($_SESSION['userid'])){
		echo "<a href='profile.php'><li>Profile</li></a>
					<a href='logout.php'><li>Log Out</l1></a>";
	}else{
	 		echo "<a href='register.php'><li>Register</li></a>
						</ul>
						</div>";

			echo "
				login
				<form action='' method='post'>
				<input type='text' name='email'>
				<input type='password' name='password'>
				<input type='submit'>
				</form>
	    ";
	  }

?>

