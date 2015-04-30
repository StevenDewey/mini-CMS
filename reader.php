<?php 
require_once 'queries.php'; # Make sure you have the needed Class file
$myWizard = new wizard;
$display_Post;
	if(isset($_GET["btn_action"])){
		switch ( $_GET["btn_action"] ):
			case "By Title":
			$myWizard->sort = "title";
			if (isset($_GET["ID"])) {
				$display_Post = $myWizard->singlePostCategoryString($_GET["ID"]);
			}
			else if (isset($_GET["postID"])) {
				$display_Post = $myWizard->singlePostCategoryString($_GET["postID"]);
			}
			foreach( $display_Post as $key => $value ):
					${$key} = $value;
			endforeach;

			break;
			case "By Category":
			$myWizard->sort = "category";
			if (isset($_GET["ID"])) {
				$display_Post = $myWizard->singlePostCategoryString($_GET["ID"]);
			}
			else if (isset($_GET["postID"])) {
				$display_Post = $myWizard->singlePostCategoryString($_GET["postID"]);
			}
			foreach( $display_Post as $key => $value ):
					${$key} = $value;
			endforeach;
			break;
			default:
				if (isset($_GET["ID"])) {
					$display_Post = $myWizard->singlePostCategoryString($_GET["ID"]);
				}
				else if (isset($_GET["postID"])) {
					$display_Post = $myWizard->singlePostCategoryString($_GET["postID"]);
				}
				if (isset($_GET["sortingOrder"])) {
					if ($_GET["sortingOrder"] == "By Title") {
						$myWizard->sort = "title";
					}
					else if ($_GET["sortingOrder"] == "By Category") {
						$myWizard->sort = "category";
					}
				}

				$display_Post = $myWizard->singlePostCategoryString($_GET["ID"]);

				foreach( $display_Post as $key => $value ):
					${$key} = $value;
				endforeach;
			break;
		endswitch;
	}
	

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<nav>
 	<a href="index.php"><h1>Digital Humanities... What is that?</h1></a>
 	<ul>
 		<li><a href="reader.php">Reader</a></li>
 		<li><a href="admin.php">Admin</a></li>
 	</ul>
 </nav>
	 <div class="maindiv">

		<div class="leftSideBar">
			<?php  
			if ($myWizard->sort == "title") {
				if (isset($_GET["sortingOrder"])) {
					$sortingOrder = $_GET["sortingOrder"];
				}
				else{
					$sortingOrder = $_GET["btn_action"];
				}
				$myWizard->allPostsTitle();

				# Storing the result gives us access to several specialized properties
				$myWizard->posts->store_result();

				# Bind the fields for each returned record to local variables that we name
				$myWizard->posts->bind_result($id,$title,$link,$commentary,$status,$category);

			}
			else if ($myWizard->sort == "category") {
				if (isset($_GET["sortingOrder"])) {
					$sortingOrder = $_GET["sortingOrder"];
				}
				else{
					$sortingOrder = $_GET["btn_action"];
				}
				$myWizard->allPostsCategory();

				# Storing the result gives us access to several specialized properties
				$myWizard->posts->store_result();

				# Bind the fields for each returned record to local variables that we name
				$myWizard->posts->bind_result($id,$title,$link,$commentary,$status,$category);

			}
			else{
				$myWizard->allPosts();

				# Storing the result gives us access to several specialized properties
				$myWizard->posts->store_result();

				# Bind the fields for each returned record to local variables that we name
				$myWizard->posts->bind_result($id,$title,$link,$commentary,$status,$category);

				$display_extras = false;

			}
			if (isset($_GET["ID"])) {
				$post_ID = $_GET['ID'];
				$display_extras = true;
			}
			else if (isset($_GET["postID"])) {
				$post_ID = $_GET['postID'];
				$display_extras = true;
			}
			
			echo "<h2>Recent Posts - Categories</h2>";
			echo "<h3 class='inline'>Sort:</h3>";
			echo "<form action='reader.php' class='form' method='get'>
				<input type='hidden' name='postID' value='$post_ID' />
					<input type='submit' class='sortform' name='btn_action' value='By Title'/>
				</form>
				";
			echo "<form action='reader.php' class='form' method='get'>
				<input type='hidden' name='postID' value='$post_ID'/>
					<input type='submit' id='sortCat' class='sortform' name='btn_action' value='By Category'/>
				</form>
				";
		#	$parameter = explode("&", $_SERVER['QUERY_STRING']);
		#	foreach ($parameter as $key => $value) {
		#		echo  "$key - $value";
		#	}
			echo "<div class='sidebar'>";
			while( $myWizard->posts->fetch() ):
				$catArray =  explode(',', $category);
				echo "
					
						<div class='lineItem '>
							<div class='titleBTN'>
								<form action='reader.php' class='form' method='get'>
									<input type='hidden' name='ID' value='$id' />
									<input type='hidden' name='sortingOrder' value='$sortingOrder' />
									<input type='submit' class='btn "; 
							if (isset($_GET["ID"])) {
								if ($_GET["ID"] == $id) {
									echo "currentTitle";
								}
								
							}
							else if (isset($_GET["postID"])) {
								if ($_GET["postID"] == $id) {
									echo "currentTitle";
								}
							}
						echo "' name='btn_action' value='$title'/>
								</form>
							</div>
							<div class='categoryUL'>
								<ul class='tags'>"; 
								foreach ($catArray as $catName) {
									echo "<li>$catName</li>";
								}
					echo "		</ul>
							</div>
						</div>		
					";			
					
			endwhile;
			echo "</div>";
				$myWizard->posts->close();
				
			?>
		</div>
		<div class="content">
			<h1><?=(isset($post_title)?$post_title:"Click on a Title on the Left");?></h1>
			<div class="catTagsContent">
				<div class="catTags1">
				<? 
					if ($display_extras) {
						echo "<h3>Categories:</h3>";
					} 
				?>
				</div>
				<div class="catTags2">
				<ul class="tags2">
					<?php 
						if(isset($post_category)){
							foreach ($post_category as $catID) {
							echo "<li>$catID</li>";
							
							}
						}
					?>
				</ul>
				</div>
			</div>

			<p class="readerCommentary"><?=(isset($post_commentary)?$post_commentary:"");?></p>
			<em><p>
				<? 
					if ($display_extras) {
						echo "(For more information, Click Here: ";
					} 
				?>
			<a href="<?=(isset($post_link)?$post_link:"");?>"><?=(isset($post_link)?$post_link:"");?></a><? 
					if ($display_extras) {
						echo ")";
					} 
				?></p></em>
								
		</div>
	 </div>

</body>
</html>
