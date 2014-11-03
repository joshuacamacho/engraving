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
				<input type="text" value="<?php echo $fn;?>" />
				<input type="hidden" value="<?php echo $ln;?>" />
				<input type="hidden" value="<?php echo $ph;?>" />
				<input type="text" value="<?php echo $em;?>" />
				<input type="hidden" value="<?php echo $co;?>" />
				<br>
				<input type="submit" value="Send Email" />
			</form>
				<a href="contact.php"><button onclick="">Edit Email</button></a>
			
		</div> <!-- end of content right-->
        
        <div class="spacer">&nbsp;</div>
    </div>




     <?php include_once("footer.php");?>
