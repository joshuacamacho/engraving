<?php
	

	include_once("header.php");

?>

<div id="slider">
        <div id="slider-holder">
          <ul>
            <li><a href="#"><img src="images/slideshow.jpg" alt="" /></a></li>
            <li><a href="#"><img src="images/slideshow2.jpg" alt="" /></a></li>
            <!--<li><a href="#"><img src="images/slideshow3.jpg" alt="" /></a></li>
            <li><a href="#"><img src="images/slideshow4.jpg" alt="" /></a></li>-->
          </ul>
        </div>
        <div id="slider-nav"> <a href="#" class="active">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> </div>
</div>

 <div id="content">
    
   	  <div id="content_left">
        	<h1>Welcome to Rock Solid Business Cards</h1>
          <p>Aliquam tristique lacus in sapien. Suspendisse potenti. Ut sed pede. Nullam vitae tellus. Sed ultrices. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc quis sem nec tellus blandit tincidunt. Aliquam tristique lacus in sapien. Suspendisse potenti. Ut sed pede. Nullam vitae tellus. Sed ultrices. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
               <!-- makes layout space -->          
             <div class="spacer_with_height">&nbsp;</div>
             
             <h2 id="label">New Products</h2>

             <?php 
                $query=("SELECT * FROM items WHERE stocklevel='In Stock' ORDER BY itemid DESC LIMIT 4");
                $result=$link->query($query);
                while($row=mysqli_fetch_assoc($result)){
                    echo "<div class='product_box'>
                        <h3 class='product_name'>".$row['name']."</h3>
                        <a href='catalog.php?itemid=".$row['itemid']."'>
                            <img src='images/".$row['pictureurl']."' width='200px' alt='image' />
                        </a>
                        <p>".$row['description']."</p>
                        <div class='price'>PRICE:<span>$".sprintf('%01.2f', $row['price'])."</span></div>                           
                        <div class='buynow'><a href='catalog.php?itemid=".$row['itemid']."'>Buy Now</a></div>
                        </div>";
                }
             ?>


             
    	</div> 
    	<!-- end of ocntent left -->
        
        
        <div class="spacer">&nbsp;</div>
    </div>






<?php


	include_once("footer.php");

	

?>