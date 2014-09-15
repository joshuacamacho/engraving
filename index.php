<?php
	

	include("header.php");

?>

<div id="slider">
        <div id="slider-holder">
          <ul>
            <li><a href="#"><img src="images/slideshow.jpg" alt="" /></a></li>
            <li><a href="#"><img src="images/slideshow2.jpg" alt="" /></a></li>
            <li><a href="#"><img src="images/slideshow3.jpg" alt="" /></a></li>
            <li><a href="#"><img src="images/slideshow4.jpg" alt="" /></a></li>
          </ul>
        </div>
        <div id="slider-nav"> <a href="#" class="active">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> </div>
</div>

 <div id="content">
    
   	  <div id="content_left">
        	<h1>Welcome to Timeless Pieces Watch Engraving</h1>
          <p>Aliquam tristique lacus in sapien. Suspendisse potenti. Ut sed pede. Nullam vitae tellus. Sed ultrices. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc quis sem nec tellus blandit tincidunt. Aliquam tristique lacus in sapien. Suspendisse potenti. Ut sed pede. Nullam vitae tellus. Sed ultrices. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
               <!-- makes layout space -->          
             <div class="spacer_with_height">&nbsp;</div>
             
             <h2 id="label">New Products</h2>
             <div class="product_box">
             	<h3 class="product_name">Men's Silver Watch</h3>
                <img src="images/silvermen.jpg" alt="image" />
                <p>Aliquam tristique lacus in sapien. Suspendisse potenti.</p>
                <div class="price">PRICE:<span>$90.00</span></div>                           
             	<div class="buynow"><a href="shoppingcard.html">Buy Now</a></div><a href="#">Details</a>
             </div>
             <div class="product_box">
             	<h3 class="product_name">Men's Gold Watch</h3>
                <img src="images/goldmen.jpg" alt="image" />
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing.</p>
                <div class="price">PRICE:<span>$150.00</span></div>                           
             	<div class="buynow"><a href="shoppingcart.html">Buy Now</a></div><a href="#">Details</a>
             </div>
             <div class="product_box">
             	<h3 class="product_name">Women's Silver Watch</h3>
                <img src="images/silverwomen.jpg" alt="image" />
                <p>Suspendisse potenti. Ut sed pede. Nullam vitae tellus. </p>
                <div class="price">PRICE:<span>$80.00</span></div>                           
             	<div class="buynow"><a href="shoppingcard.html">Buy Now</a></div><a href="#">Details</a>
             </div>
             
			<div class="spacer_with_height">&nbsp;</div> <!-- makes layout space --> 
            <div class="product_box">
             	<h3 class="product_name">Women's Gold Watch</h3>
                <img src="images/goldwomen.jpg" alt="image" />
                <p>Aliquam tristique lacus in sapien. Suspendisse potenti.</p>
                <div class="price">PRICE:<span>$140.00</span></div>                           
             	<div class="buynow"><a href="shoppingcard.html">Buy Now</a></div><a href="#">Details</a>
        </div>
        <div class="product_box">
             	<h3 class="product_name"> Gold SPocket Watch</h3>
                <img src="images/goldpocket.jpg" alt="image" />
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing.</p>
                <div class="price">PRICE:<span>$190.00</span></div>                           
             	<div class="buynow"><a href="shoppingcart.html">Buy Now</a></div><a href="#">Details</a>
           </div>
    	</div> 
    	<!-- end of ocntent left -->
        
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






<?php


	include("footer.php");

	

?>