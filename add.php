<?php 
require 'queries.php'; # Make sure you have the needed Class file
$myWizard = new wizard;
if(isset($_POST["btn_action"])){
	switch ( $_POST["btn_action"] ):
		case "Add Post":
			$Title = (!empty($_POST["Title"]) ? $_POST["Title"] : "");
			$Link = (!empty($_POST["Link"]) ? $_POST["Link"] : "");
			$Commentary = (!empty($_POST["Commentary"]) ? $_POST["Commentary"] : "");
			$Status = (!empty($_POST["Status"]) ? $_POST["Status"] : "");
			$Category[] = array();
			if (!empty($_POST["check_list"])) {
				foreach ($_POST["check_list"] as $catID) {
					$Category[] = $catID;
				}
			}
			
			if (!empty($_POST)) {
				
			$myWizard->addPost($Title, $Link, $Commentary, $Status, $Category);
			
			
			}
			#echo "got to switch";
			break;

		case "Delete":
			if ( !$_POST["ID"] ):
				header("location: index.php");
				exit;
			endif;

			$myWizard->deletePost($_POST["ID"]);
			break;
		
		case "Edit":
			if ( !$_POST["ID"] ):
				header("location: index.php");
				exit;
			endif;

			#$btn_value = "Edit To Do Item"; 
			#$action = "edit";

			$edit_Post = $myWizard->singlePost($_POST["ID"]);

			foreach( $edit_Post as $key => $value ):
				${$key} = $value;
			endforeach;
			
			break;
		case "Process Edit":
			
			#$btn_value = "Edit To Do Item"; 
			#$action = "edit";
			#foreach( $_POST as $key => $value ):
			#			${$key} = $value;
			#			
			#		#	if ( $value == "" ):
			#		#		$error++;
			#		#	endif;
			#		endforeach;
			$post_id = (!empty($_POST["post_id"]) ? $_POST["post_id"] : "");
			$post_title = (!empty($_POST["post_title"]) ? $_POST["post_title"] : "");
			$post_link = (!empty($_POST["post_link"]) ? $_POST["post_link"] : "");
			$post_commentary = (!empty($_POST["post_commentary"]) ? $_POST["post_commentary"] : "");
			$post_status = (!empty($_POST["post_status"]) ? $_POST["post_status"] : "");
			$post_category[] = array();
			if (!empty($_POST["check_list"])) {
				foreach ($_POST["check_list"] as $catID) {
					$post_category[] = $catID;
				}
			}
			
			$myWizard->editPost($post_id, $post_title, $post_link, $post_commentary, $post_status, $post_category);
			
			break;

		#case "High": 
		#case "Medium":
		#case "Low":
		#	if ( $_POST["priority"] == 1){
		#		$priority = 2;
		#	}
		#	else if ($_POST["priority"] == 2) {
		#		$priority = 3;
		#	}
		#	else if ($_POST["priority"] == 3) {
		#		$priority = 1;
		#	}
		#	
		#	$myList->updatePriority($_POST["ID"], $priority);
		#	break;
		#case "Incomplete":
		#case "Complete":
		#	if ( $_POST["complete"] == 0){
		#		$complete = 1;
		#	}
		#	else if ($_POST["complete"] == 1) {
		#		$complete = 0;
		#	}
		#	
		#	$myList->updateComplete($_POST["ID"], $complete);
		#	break;
#
		##default:
		#	#header("location: index.php");
		#	#break;
	endswitch;
}

# Process the form submission here
	#if ( !empty($_POST["form_action"]) ):
	#	foreach( $_POST as $key => $value ):
	#		${$key} = $value;
	#		
	#		if ( $value == "" ):
	#			$error++;
	#		endif;
	#	endforeach;
#
	#	if ($error == 0):
	#		switch ( $_POST["form_action"] ):
	#			case "add":
	#				$myShop->addpost($post_name, $post_color, $toxic, $quantity, $intended_effects, $side_effects);
	#				break;
#
	#			case "Edit":
	#				$myShop->editpost($post_id, $post_name, $post_color, $toxic, $quantity, $intended_effects, $side_effects);
	#				break;
	#		endswitch;
	#	endif;
	#endif;
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		
		<link rel="stylesheet" type="text/css" href="style.css">

		<title>Post Storeroom</title>
	</head>
	
	<body>
	<div class="maindiv">
		<p class="return"><a href="admin.php">&laquo; Back to Admin View</a></p>
		
		<h1>Edit Post</h1>
		
		<form name="storeroom" class="addform" method="post">
			
				<?php if ( isset($post_id) ): ?>
					<input type="hidden" name="post_id" value="<?=$post_id;?>" />
				<?php endif; ?>
				<div class="center">
					
					<span>Title:</span>
					<input type="text" name="post_title" value="<?=(isset($post_title)?$post_title:"");?>" />
				
					<span>Link:</span>
					<input type="text" name="post_link" value="<?=(isset($post_link)?$post_link:"");?>" />
				
					<span>Status:</span>
					<?php  
					echo "<select name=\"post_status\">";
					$myWizard->get_statusItems();
						# Storing the result gives us access to several specialized properties
						$myWizard->statusMYSQL->store_result();
#						# Bind the fields for each returned record to local variables that we name
						$myWizard->statusMYSQL->bind_result($id, $status);
						while( $myWizard->statusMYSQL->fetch() ):
							if (isset($post_status) && $post_status == $id) {
								echo "<option selected value=\"$id\">$status</option>";
							}
							else{
								echo "<option value=\"$id\">$status</option>";
							}	

						endwhile;
						$myWizard->statusMYSQL->close();
						echo "</select>";
					?>
				
					<span>Categories:</span>
					<?php 
						
						$myWizard->get_categoryItems();
						# Storing the result gives us access to several specialized properties
						$myWizard->categoryMYSQL->store_result();

						# Bind the fields for each returned record to local variables that we name
						$myWizard->categoryMYSQL->bind_result($id, $category);
						
																	
						while( $myWizard->categoryMYSQL->fetch() ) { 
							if (isset($post_category) && $myWizard->displayCheckBox($post_category, $id)) {
								echo "<input type=\"checkbox\" class='boxcheck' name=\"check_list[]\" checked value=\"$id\">$category</input>";
							}
							else{
								echo "<input type=\"checkbox\" class='boxcheck' name=\"check_list[]\" value=\"$id\">$category</input>";
							}
						};
						$myWizard->categoryMYSQL->close();
						
					?>
				
				</div>
				<p>
					<p class='commentarylabel'>Commentary:</p>
					<textarea type="text" class="commentary" name="post_commentary" ><?=(isset($post_commentary)?$post_commentary:"");?></textarea>
				</p>


				<input type="submit" name="btn_action" class="btn_action btn addsubmit" value="Process Edit" />
		</form>
		</div>
	</body>
</html>

