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
				name=map[0].replace("_"," ");	// Removes the underscore "_" from the 'name'
				value=map[1];
				obj[name]=value;
			}
			return obj;
		}	
		function adjustCharacters(field){
			for(var i=0;i<$_GET[field].length;i++){
				$_GET[field]=$_GET[field].replace("+"," ");
				$_GET[field]=$_GET[field].replace("%20"," ");
				$_GET[field]=$_GET[field].replace("%21","!");
				$_GET[field]=$_GET[field].replace("%22","\"");
				$_GET[field]=$_GET[field].replace("%23","#");
				$_GET[field]=$_GET[field].replace("%24","$");
				$_GET[field]=$_GET[field].replace("%25","%");
				$_GET[field]=$_GET[field].replace("%26","&");
				$_GET[field]=$_GET[field].replace("%27","'");
				$_GET[field]=$_GET[field].replace("%28","(");
				$_GET[field]=$_GET[field].replace("%29",")");
				$_GET[field]=$_GET[field].replace("%2A","*");
				$_GET[field]=$_GET[field].replace("%2B","+");
				$_GET[field]=$_GET[field].replace("%2C",",");
				$_GET[field]=$_GET[field].replace("%2D","-");
				$_GET[field]=$_GET[field].replace("%2E",".");
				$_GET[field]=$_GET[field].replace("%2F","/");
				$_GET[field]=$_GET[field].replace("%3A",":");
				$_GET[field]=$_GET[field].replace("%3B",";");
				$_GET[field]=$_GET[field].replace("%3C","<");
				$_GET[field]=$_GET[field].replace("%3D","=");
				$_GET[field]=$_GET[field].replace("%3E",">");
				$_GET[field]=$_GET[field].replace("%3F","?");
				$_GET[field]=$_GET[field].replace("%40","@");
				$_GET[field]=$_GET[field].replace("%5B","[");
				$_GET[field]=$_GET[field].replace("%5C","\\");
				$_GET[field]=$_GET[field].replace("%5D","]");
				$_GET[field]=$_GET[field].replace("%5E","^");
				$_GET[field]=$_GET[field].replace("%5F","_");
				$_GET[field]=$_GET[field].replace("%60","`");
				$_GET[field]=$_GET[field].replace("%7B","{");
				$_GET[field]=$_GET[field].replace("%7C","|");
				$_GET[field]=$_GET[field].replace("%7D","}");
				$_GET[field]=$_GET[field].replace("%7E","~");
			}
		}	
	</script>


	<div id="content">
    
		<div id="content_left">
          
			<script type="text/javascript">
				//get info from form
				var $_GET=getFormInfo(location.href);
				
				//	Fix the characters
				adjustCharacters('First Name');
				adjustCharacters('Last Name');
				adjustCharacters('Email');
				adjustCharacters('Phone');
				adjustCharacters('Comments');
				
				
				//	Output the submitted data
				document.write('<div style="background-color:rgba(0,0,0,0.7)"><span id="whiteA">REVIEW YOUR EMAIL BEFORE SENDING</span><br/><br/>');
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
			
			<!-- Sends the email -->
			<form name="" id="" action="mailto:contact@company.com" >
				<input type="hidden" value="<?php echo $fn;?>" />
				<input type="hidden" value="<?php echo $ln;?>" />
				<input type="hidden" value="<?php echo $ph;?>" />
				<input type="hidden" value="<?php echo $em;?>" />
				<input type="hidden" value="<?php echo $co;?>" />
				<br>
				<input type="submit" value="Send Email" />
			</form>
			
			<?php
				$rfn=$_GET['First_Name'];
				$rln=$_GET['Last_Name'];
				$rph=$_GET['Phone'];
				$rem=$_GET['Email'];
				$rco=$_GET['Comments'];
			?>
			
			<!-- Goes back to the contact page -->
			<form name="" id="" action="contact.php" method="get" > <!-- Why wont this 'get' method work! -->
				<input type="hidden" value="<?php echo $rfn;?>" />
				<input type="hidden" value="<?php echo $rln;?>" />
				<input type="hidden" value="<?php echo $rph;?>" />
				<input type="hidden" value="<?php echo $rem;?>" />
				<input type="hidden" value="<?php echo $rco;?>" />
				<br>
				<input type="submit" value="Edit Email" />
			</form>
			
		</div> <!-- end of content right-->
        
        <div class="spacer">&nbsp;</div>
    </div>




     <?php include_once("footer.php");?>
