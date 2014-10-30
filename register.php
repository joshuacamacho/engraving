<?php
	include("header.php");
	
?>
<head><script>
			function Validate_First_Name(){
				var x = document.forms["contForm"]["First_Name"].value;
				var re = new RegExp(/^\s*[A-Z][a-z]{1,15}([A-Z][a-z]{1,10})?(([-\s][A-Z][a-z]{1,15})|([A-Z][a-z]{1,15}))?\s*$/);
				var m = re.exec(x);//m is for 'match'
				if (m==null){
					alert("Sorry, Something went wrong please fill in your First name correctly!");
					return false;
				}else{
					return true;
				}
			}
			function Validate_Last_Name(){
				var x = document.forms["contForm"]["Last_Name"].value;
				var re = new RegExp(/^\s*(([A-Z][a-z]{1,15})([-][A-Z][a-z]{1,15})?.*(\s+[A-Z][a-z]{1,10})?|([A-Z][a-z'][a-zA-Z][a-z]{1,15}))\s*$/);
				var m = re.exec(x);
				if (m==null){
					alert("Sorry, Something went wrong please fill in your Last name correctly!");
					return false;
				}else{
					return true;
				}
			}
			function Validate_User_Name(){
				var x = document.forms["contForm"]["User_Name"].value;
				var re = new RegExp(/^\s*(([A-Z][a-z]{1,15})([-][A-Z][a-z]{1,15})?.*(\s+[A-Z][a-z]{1,10})?|([A-Z][a-z'][a-zA-Z][a-z]{1,15}))\s*$/);
				var m = re.exec(x);
				if (m==null){
					alert("Sorry, Something went wrong please fill in your Username correctly!");
					return false;
				}else{
					return true;
				}
			}
			function Validate_Street(){
				var x = document.forms["contForm"]["Street"].value;
				var re = new RegExp(/^\s*([1-9]|[1-9][0-9]|[1-9][0-9]{2,9})\s+[A-Z][a-z]{1,15}.*(\s+[A-Z][a-z]{1,15})?\s+[A-Z][a-z]{1,10}([.])?\s*$/);
				var m = re.exec(x);
				if (m==null){
					alert("Sorry, Something went wrong please fill in your correct Street Number and Name!");
					return false;
				}else{
					return true;
				}
			}
			function Validate_City(){
				var x = document.forms["contForm"]["City"].value;
				var re = new RegExp(/^\s*[A-Z][a-z]{2,15}.*(\s+[A-Z][a-z]{2,15})?\s*$/);
				var m = re.exec(x);
				if (m==null){
					alert("Sorry, Something went wrong please fill in your City correctly!");
					return false;
				}else{
					return true;
				}
			}
			function Validate_Zip(){
				var x = document.forms["contForm"]["Zip"].value;
				var re = new RegExp(/^\s*[0-9]{5}([-\s][0-9]{4})?\s*$/);
				var m = re.exec(x);
				if (m==null){
					alert("Please fill in the correct Zipcode format! 5- or 9-digit (e.g. 12345 or 12345-6789)!");
					return false;
				}else{
					return true;
				}
			}
			function Validate_Home_Phone(){
				var x = document.forms["contForm"]["Home_Phone"].value;
				var re = new RegExp(/^\s*([(\s])?[1-9][0-9]{2}[-\s|)\s](\s)?[1-9][0-9]{2}[-\s][0-9]{4}\s*$/);
				var m = re.exec(x);
				if (m==null){
					alert("Please, enter your correct Home Phone number!");
					return false;
				}else{
					return true;
				}
			}
			function Validate_Cellphone(){
				var x = document.forms["contForm"]["Cellphone"].value;
				var re = new RegExp(/^\s*([(\s])?[1-9][0-9]{2}[-\s|)\s](\s)?[1-9][0-9]{2}[-\s][0-9]{4}\s*$/);
				var m = re.exec(x);
				if (m==null){
					alert("Please, enter your correct Cell Phone number!");
					return false;
				}else{
					return true;
				}
			}
			function Validate_Email(){
				var x = document.forms["contForm"]["Email"].value;
				var re = new RegExp(/^\s*((.*\d)?(.*[a-z])?.{5,20})[@][a-z]{4,15}[.][a-z]{2,4}([.][a-z]{2,4})?\s*$/);
				var m = re.exec(x);
				if (m==null){
					alert("Please, enter your correct Email address!");
					return false;
				}else{
					return true;
				}
			}
			
			function validateForm(){
				if(!Validate_First_Name())return false;
				if(!Validate_Last_Name())return false;
				
				if(!Validate_Email())return false;
				
				
				return true;
			}
		</script>
</head>

<?php
	$isinvalid=false;
	$invalid="";
	if(
		isset($_POST['firstname']) && !empty($_POST['firstname']) &&
		isset($_POST['lastname']) && !empty($_POST['lastname']) &&
		isset($_POST['regemail']) && !empty($_POST['regemail']) &&
		isset($_POST['regpassword']) && !empty($_POST['regpassword'])
		){
			require_once("connect.php");
			$firstname=htmlentities(mysqli_real_escape_string($link,$_POST['firstname']));
			$lastname=htmlentities(mysqli_real_escape_string($link,$_POST['lastname']));
			$email=htmlentities(mysqli_real_escape_string($link,$_POST['regemail']));
			$password=sha1(htmlentities(mysqli_real_escape_string($link,$_POST['regpassword'])));

			$allvalid=true;
			
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				//IF EMAIL is valid form
				
				$query="SELECT email FROM users WHERE email='".$email."'";
				$result=$link->query($query);
				$row=$result->fetch_array();
				

				if(count($row)>0){
					//if email exists
					$allvalid=false;
					//$invalid.=" This email already exists.";
				}
				else{
					//if email is unique and valid form
					 
				}
			}else{
				//if email is invalid form
				$allvalid=false;
				//$invalid.=" Incorrect email form.";

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
			 
			 $isinvalid=false;
		}else{
			$isinvalid=true;
			
		}

			
	}
	if(isset($_POST['firstname'])){
		if(empty($_POST['firstname'])){
			$isinvalid=true;
			$invalid .= "<li>Missing Firstname</li>";
		}else{
			$postfirstname=$_POST['firstname'];
		}
	}
	if(isset($_POST['lastname'])){
		if (empty($_POST['lastname'])){
			$isinvalid=true;
			$invalid .= "<li>Missing Lastname</li>";
		}else{
			$postlastname=$_POST['lastname'];
		}
	}
	if(isset($_POST['regemail'])){
		if(empty($_POST['regemail'])){
			$isinvalid=true;
			$invalid .= "<li>Missing Email</li>";
		}else{
			//$postemailname=$_POST['regemail'];
		}
	}
	if(isset($_POST['regpassword']) && empty($_POST['regpassword'])){
		$isinvalid=true;
		$invalid .= "<li>Missing Password</li>";
	}
	
	if(isset($_POST['regemail']) && !empty($_POST['regemail'])){
		$email=mysqli_real_escape_string($link,$_POST['regemail']);
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		//IF EMAIL is valid form
		
		$query="SELECT email FROM users WHERE email='".$email."'";
		$result=$link->query($query);
		$row=$result->fetch_array();
		

		if(count($row)>0){
			//if email exists
			$isinvalid=true;
			$invalid.="<li>This email already exists</li>";
		}
		else{
			//if email is unique and valid form
			 $postemail=$_POST['regemail'];
		}
	}else{
		//if email is invalid form
		$allvalid=true;
		$invalid.="<li>Incorrect email form</li>";

	}
}
	
	
	echo "
	<div id='content'>
	";
	
	
	
	
	if(!empty($invalid)){
		
		echo "<ul>".$invalid."</ul>";
		
	}
	
	
	
	?>
	
	
	<h2 id="label">Create User Account</h2>
   <div class="form_settings">
	<p>Fill out all Required Areas indicated with (*)</p>
    <form action="register.php" onsubmit="return validateForm()" method="post" name="contForm">
	
    <p>*First Name: 
      <input name="firstname" type="text" size="50" maxlength="33" 
	  <?php if($isinvalid && isset($postfirstname) && !empty($postfirstname)) echo "value='".$postfirstname."' "; ?> /></p>
	<p>*Last Name: 
		<input name="lastname" type="text" size="50" maxlength="33" 
	    <?php if($isinvalid && isset($postlastname) && !empty($postlastname)) echo "value='".$postlastname."' "; ?>
		/></p>
    <p>*E-mail: 
		<input name="regemail" type="text" size="50" maxlength="50" 
		<?php if($isinvalid && isset($postemail) && !empty($postemail)) echo "value='".$postemail."' "; ?>
		/></p>
    <p>*Password: 
		<input name="regpassword" size="50" maxlength="50" type="password" />
	</p>
	
				
     
	<p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="submit" value="submit" /></p>
	<p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="reset" name="reset" value="clear form" /></p>
        	</form>
	
	
	
	
	</div></div>
	
	
	<?php
	
	
	
	/*
	
	echo "<form action='register.php' method='post'>
				<label>First Name</label>
				<input type='text' name='firstname' ";
	if($isinvalid && isset($postfirstname) && !empty($postfirstname)) echo "value='".$postfirstname."' ";
	echo ">";
	echo		"<label>Last Name</label>
				<input type='text' name='lastname' ";
	if($isinvalid && isset($postlastname) && !empty($postlastname)) echo "value='".$postlastname."' ";			
				
	echo		">
				<label>Email</label>
				<input type='text' name='regemail'>
				<label>Password</label>
				<input type='password' name='regpassword'>
				<input type='submit'>
				</form>
				</div>
				
				
	";*/
include("footer.php");
?>
