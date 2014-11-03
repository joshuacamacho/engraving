<?php include_once("header.php") ?>
<!--Validation Functions-->
		<head><script>
			function Validate_First_Name(){
				var x = document.forms["contForm"]["First_Name"].value;
				var re = new RegExp(/^\s*([A-Z][a-z]{1,}|[A-Z][a-z]{1,}([A-Z][a-z])?)([A-Z][a-z]{1,})?(([-\s][A-Z][a-z]{1,})|([A-Z][a-z]{1,}))?\s*$/);
				var m = re.exec(x);//m is for 'match'
				if (m==null){
					alert("Sorry, your first name was not entered correctly, please try again!");
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
					alert("Sorry, your last name was not entered correctly, please try again!");
					return false;
				}else{
					return true;
				}
			}
			
			function Validate_Phone(){
				var x = document.forms["contForm"]["Phone"].value;
				var re = new RegExp(/^\s*([(\s])?[1-9][0-9]{2}[-\s|)\s](\s)?[1-9][0-9]{2}[-\s][0-9]{4}\s*$/);
				var m = re.exec(x);
				if (m==null){
					alert("Please, enter a phone number in the form of (###) ###-####!");
					return false;
				}else{
					return true;
				}
			}
		
			function Validate_Email(){
				var x = document.forms["contForm"]["Email"].value;
				var re = new RegExp(/^\s*((.*\d)?(.*[a-z])?.{1,20})[@][a-z]{1,15}[.][a-z]{2,4}([.][a-z]{2,4})?\s*$/);
				var m = re.exec(x);
				if (m==null){
					alert("Please, enter a proper email!");
					return false;
				}else{
					return true;
				}
			}
			function validateForm(){
				if(!Validate_First_Name())return false;
				if(!Validate_Last_Name())return false;
				if(!Validate_Phone())return false;
				if(!Validate_Email())return false;
				return true;
			}
		</script></head>

  <div id="content">
    
   	  <div id="content_left">
               <!-- makes layout space -->          
            
             
             <h2 id="label">Contact Us</h2>
             <p>Aliquam tristique lacus in sapien. Suspendisse potenti. Ut sed pede. Nullam vitae tellus. Sed ultrices. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
             
             <h3>Mailing Address</h3>
        	<h4><strong>Office One</strong></h4>
            800-220 Fusce nec ante at odio, <br />
            In vitae lacus in purus, 66770<br />
            Diam a mollis tempor<br /><br />
            
			<strong>Phone:</strong> (951) 555-5555<br />
            <strong>Email:</strong> <a href="mailto:contact@company.com">contact@company.com</a><br />
            
            <div class="form_settings">
	<p>Fill out all Required Areas indicated with (*)
        <form action="review.php" onsubmit="return validateForm()" method="get" name="contForm">
	
    <p>*First Name: 
      <input name="First_Name" type="text" size="45" maxlength="33" /></p>
	<p>*Last Name: 
		<input name="Last_Name" type="text" size="45" maxlength="33" /></p>
    
    <p>*Phone Number: 
		<input name="Phone" size="45" maxlength="50" type="text" />
	</p>
	<p>*E-mail: 
		<input name="Email" type="text" size="45" maxlength="50" /></p><br />
        
    <p>*Please leave your comments, questions or concerns here</p>
    	<textarea name="Comments" id="Comments" cols="45" rows="5"></textarea></p>
	<p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="submit" value="submit" /></p>
	<p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="reset" name="reset" value="clear form" /></p>
    
        	</form>
        
       </div> 
                
                <!-- makes layout space -->          
             <div class="spacer_with_height">&nbsp;</div>
             
    	</div>
         
    	<!-- end of content left -->
        
        <div id="content_right">
        	<div class="right_section">
            	<h4 class="right_header">Search</h4>
                <div class="right_section_content">
                    <form method="get" action="#">
                            <input name="keyword" type="text" id="keyword"/>
                            <input type="submit" name="submit" class="button" value="Search" />
                  </form>
              </div>
            </div>
            
            <div class="right_section">
            	<h4 class="right_header">Engraving Products</h4>
                <div class="right_section_content">
                    <ul>
                        <li><a href="#">Men's Silver Watches</a></li>
                        <li><a href="#">Men's Gold Watches</a></li>
                        <li><a href="#">Women's Silver Watches</a></li>
                        <li><a href="#">Women's Gold Wathes</a></li>
                        <li><a href="#">Pocket Watches</a></li>
                       
                    </ul>
                </div>
            </div>

            
        </div> <!-- end of content right-->
        
        <div class="spacer">&nbsp;</div>
    </div>
    
     <?php include_once("footer.php");?>
</div>
 
  
</body>
</html>