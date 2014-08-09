<?php
	//log the user in if login form was used
	if(isset($_POST['email']) && isset($_POST['password'])){
			require_once("connect.php");
			$email=mysqli_real_escape_string($link,$_POST['email']);
			$password=mysqli_real_escape_string($link,$_POST['password']);
			$query="SELECT password FROM users WHERE email='".$email."'";
			$result = $link->query($query);
			while($row=mysqli_fetch_array($result)){
				if($password == $row['password']){
					echo "LOGIN COMPLETE";
				}
			}
	}



	echo "
				login
				<form action='./' method='post'>
				<input type='text' name='email'>
				<input type='password' name='password'>
				<input type='submit'>

	";

	echo "<a href='./register.php'>Register</a>"

?>