<?php
	include("header.php");
	require_once("connect.php");
	echo "<div id='content' class='catalogcontainer'>
				<div id='content_left'>";
	//get is set, display only one item
	if(isset($_GET['itemid'])&& !empty($_GET['itemid'])){
		$itemid=mysqli_real_escape_string($link,$_GET['itemid']);
		$query="SELECT * FROM items WHERE itemid='".$itemid."'";
		$result=$link->query($query);
		while($row=mysqli_fetch_array($result)){
			echo "<h3>".$row['name']."</h3>
						<img src='images/".$row['pictureurl']."'>
						<p>".$row['description']."</p>
						<p>$".sprintf('%01.2f', $row['price'])." per unit</p>";
			if(isset($_SESSION['userid']) && ($row['stocklevel']=='In Stock')){
				echo "Stock Level: ".$row['stocklevel']."					
							<form action='cart.php' method='post'>
							Quantity<select name='quantity'>
								<option value='10'>10</option>
								<option value='20'>20</option>
								<option value='30'>30</option>
								</select>
								<input type='hidden' name='itemid' value='".$itemid."'>
								

				";
				if($row['texteditor']==1){

					echo "<script src='ckeditor/ckeditor.js'></script>
            <textarea name='engravetext' id='editor1' rows='6' cols='8'>
                Your Engrave Text Here
            </textarea>
            <script>
                // Replace the <textarea id='editor'> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
        
					";
				}
				echo "<input type='submit' value='Add to cart'>
							</form>";
			}else if(isset($_SESSION['userid']) && $row['stocklevel']=='Sold Out'){
				echo "This item is currently out of stock.";
			}else if(isset($_SESSION['userid']) && $row['stocklevel']=='No longer sold'){
				echo "This item is no longer sold";
			}
			if(!loggedin()){
				echo "Login or <a href='register.php'>Register</a> to purchase";
			}
	}
	}else{//no get set display full catalog
		//pagination
		$query="SELECT COUNT(itemid) FROM items WHERE stocklevel='In Stock' OR stocklevel='Out of Stock' AND deleted='0'";
		$result=$link->query($query);
		$row=mysqli_fetch_row($result);
		//total row count
		$rows=$row[0];
		//the number of results displayed per page
		$page_rows = 9;
		// this is the page number of our last page
		$last=ceil($rows/$page_rows);
		// makes sure last cannot be less than one
		if($last<1) $last= 1;
		// establish $pagenum
		$pagenum = 1;
		// get pagenum from URL vars if it is present, else its = 1
		if(isset($_GET['pn'])){
			$pagenum = preg_replace('#[^0-9]#','',$_GET['pn']);
		}
		// this makes sure pagenum isnt below 1 or more than our $last page
		if($pagenum<1){
			$pagenum = 1;
		}else if ($pagenum > $last){
			$pagenum = $last;
		}
		$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;


		$query="SELECT * FROM items WHERE deleted='0' $limit";
		$result=$link->query($query);

		//pagination controls
		$paginationCtrls = '';
		// if there is more than one page of results
		if($last != 1){
			if( $pagenum > 1 ){
				$previous = $pagenum - 1;
				$paginationCtrls.="<a href='catalog.php?pn=".$previous."'><div><</div></a>";
				for($i = $pagenum - 3; $i < $pagenum; $i++){
					if($i > 0){
						$paginationCtrls.="<a href='catalog.php?pn=".$i."'><div>".$i."</div></a>";
					}
				}
			}
		}
		$paginationCtrls .= '<div><span>'.$pagenum.'</span></div>';
		// Render clickable number links that should appear on the right of the target page number
		for($i = $pagenum+1; $i <= $last; $i++){
			$paginationCtrls .= '<a href="catalog.php?pn='.$i.'"><div>'.$i.'</div></a>';
			if($i >= $pagenum+3){
				break;
			}
		}
		// This does the same as above, only checking if we are on the last page, and then generating the "Next"
	    if ($pagenum != $last) {
	        $next = $pagenum + 1;
	        $paginationCtrls .= '<a href="catalog.php?pn='.$next.'"><div>></div></a>';
	    }


	    echo "
	    <h2 id='label'>Catalog</h2>
	    <div class='pagination'>".$paginationCtrls."</div>";
		while($row=mysqli_fetch_array($result)){
			if($row['stocklevel']!='No longer sold'){
				echo "<div class='product_box'>
							<h3 class='product_name'>".$row['name']."</h3>
							<a href='catalog.php?itemid=".$row['itemid']."'>
							<img src='images/".$row['pictureurl']."' width='150px'></a>
							
							
							<p>".$row['description']."</p>
							<div class='price'>PRICE:<span>$".sprintf('%01.2f', $row['price'])."</span></div>
							<div class='buynow'><a href='catalog.php?itemid=".$row['itemid']."'>Buy Now</a></div>
							</div>
				";
			}	
		}
	}
	echo "</div></div>";
	include("footer.php");
?>