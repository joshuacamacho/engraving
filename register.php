<?php
	include("header.php");
	if(
		isset($_POST['firstname']) &&
		isset($_POST['lastname']) &&
		isset($_POST['email']) &&
		isset($_POST['password'])
		){
			require_once("connect.php");
			$firstname=mysqli_real_escape_string($link,$_POST['firstname']);
			$lastname=mysqli_real_escape_string($link,$_POST['lastname']);
			$email=mysqli_real_escape_string($link,$_POST['email']);
			$password=sha1(mysqli_real_escape_string($link,$_POST['password']));

			$allvalid=true;
			$invalid="";
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				//IF EMAIL is valid form
				
				$query="SELECT email FROM users WHERE email='".$email."'";
				$result=$link->query($query);
				$row=$result->fetch_array();
				

				if(count($row)>0){
					//if email exists
					$allvalid=false;
					$invalid.=" This email already exists.";
				}
				else{
					//if email is unique and valid form
					 
				}



			}else{
				//if email is invalid form
				$allvalid=false;
				$invalid.=" Incorrect email form.";

			}



		 if($allvalid){
			 echo "Registered";
			 $date= date("Y-m-d H:i:s");
			 $query="INSERT INTO users (firstname,lastname,email,password,datejoined) VALUES ('".$firstname."','".$lastname."','".$email."','".$password."','".$date."')";
			 $result=$link->query($query);
			 if (!$result) {
			 $message  = 'Invalid query: ' . mysql_error() . "\n";
		   $message .= 'Whole query: ' . $query;
		   die($message);
		 	 }
		}else{
			echo $invalid;
		}

			
	}

	echo "<form action='register.php' method='post'>
				<label>First Name</label>
				<input type='text' name='firstname'>
				<label>Last Name</label>
				<input type='text' name='lastname'>
				<label>Email</label>
				<input type='text' name='email'>
				<label>Password</label>
				<input type='password' name='password'>
				<input type='submit'>
				</form>
	";
include("footer.php");
?>
