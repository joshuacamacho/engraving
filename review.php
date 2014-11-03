<?php include_once("header.php") ?>

	<script type="text/javascript">
		//for input text box values only
		function getFormInfo(url){
			//split info at the "?"
			var info=url.split("?");//creates 'info' array
			//split the name value pairs at the second part of the 'info' array
			var nameValuePairs=info[1].split("&");
			//map info for object
			var obj=new Object();
			for(var i=0;i<nameValuePairs.length-1;i++){
				var map=nameValuePairs[i].split("=");
				name=map[0];
				value=map[1];
				obj[name]=value.replace("%40","@");	//replaces '%40' with '@'
			}
			return obj;
		}
	</script>


	<div id="content">
    
		<div id="content_left">
          
			<h1>"HOWDY!"</h1>
			<script type="text/javascript">
				//get info from form
				var $_GET=getFormInfo(location.href);
				
				//	Fix the comment content
				for(var i=0;i<$_GET['Comments'].length;i++){
					$_GET['Comments']=$_GET['Comments'].replace("+"," ");
				}
				for(var i=0;i<$_GET['Comments'].length;i++){
					$_GET['Comments']=$_GET['Comments'].replace("%3F","?");
				}
				for(var i=0;i<$_GET['Comments'].length;i++){
					$_GET['Comments']=$_GET['Comments'].replace("%21","!");
				}
				for(var i=0;i<$_GET['Comments'].length;i++){
					$_GET['Comments']=$_GET['Comments'].replace("%25","%");
				}
				for(var i=0;i<$_GET['Comments'].length;i++){
					$_GET['Comments']=$_GET['Comments'].replace("%24","$");
				}
				for(var i=0;i<$_GET['Comments'].length;i++){
					$_GET['Comments']=$_GET['Comments'].replace("%26","&");
				}
				for(var i=0;i<$_GET['Comments'].length;i++){
					$_GET['Comments']=$_GET['Comments'].replace("%27","'");
				}
				for(var i=0;i<$_GET['Comments'].length;i++){
					$_GET['Comments']=$_GET['Comments'].replace("%2C",",");
				}
				for(var i=0;i<$_GET['Comments'].length;i++){
					$_GET['Comments']=$_GET['Comments'].replace("%2D","-");
				}
				for(var i=0;i<$_GET['Comments'].length;i++){
					$_GET['Comments']=$_GET['Comments'].replace("%2E",".");
				}
				
				//	Fix the phone number
				$_GET['Phone']=$_GET['Phone'].replace("%28","(");
				$_GET['Phone']=$_GET['Phone'].replace("%29",")");
				$_GET['Phone']=$_GET['Phone'].replace("+"," ");
				
				//	Output the submitted data
				document.write('<div style="background-color:rgba(0,0,0,0.7)"><span id="whiteA">INFORMATION SUBMITTED</span><br/><br/>');
				for(var name in $_GET){
					document.write('<span id="whiteA">'+name+': '+$_GET[name]+'</span><br/>');	
				}
				document.write('</div>');
			</script>
			<?php
				$fn=$_GET['First_Name'];
				$ln=$_GET['Last_Name'];
				$ph=$_GET['Phone'];
				$em=$_GET['Email'];
				$co=$_GET['Comments'];
			?>
			<form name="" id="" action="mailto:contact@company.com" method="post" >
				<input type="hidden" value="<?php echo $fn;?>" />
				<input type="hidden" value="<?php echo $ln;?>" />
				<input type="hidden" value="<?php echo $ph;?>" />
				<input type="hidden" value="<?php echo $em;?>" />
				<input type="hidden" value="<?php echo $co;?>" />
				<br>
				<input type="submit" value="Send Email" />
			</form>
				<a href="contact.php"><button onclick="">Edit Email</button></a>
			
		</div> <!-- end of content right-->
        
        <div class="spacer">&nbsp;</div>
    </div>




     <?php include_once("footer.php");?>
