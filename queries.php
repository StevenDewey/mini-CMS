<?php  

	
	class wizard {
		
			public $display_Post;
			public $sort;
			public $statusMYSQL;
			private $statusArray;
			private $postsArray;
			public $categoryMYSQL;
			private $alignmentARRAY;
			public $posts;
			private $database;

			public function __construct() {
			# New mysqli Object for database communication
			$this->database = new mysqli("localhost","tardissh_sdew","3701!","tardissh_dewey");

			# Kill the page is there was a problem with the database connection
			if ( $this->database->connect_error ):
				die( "Connection Error! Error: " . $this->database->connect_error );
			endif;
			}

			public function displayCheckBox($catIDArray, $id){
				foreach ($catIDArray as $catID) {
					if ($catID == $id) {
						return true;
					}
				}
				return false;
			}
			public function get_statusItems(){
			 $query_statusItems = "
				SELECT 
					id, name
				FROM
					status
				
			";
			if ( $this->statusMYSQL = $this->database->prepare($query_statusItems) ):
				$this->statusMYSQL->execute();
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
			
			#$this->get_statusItems();
			## Storing the result gives us access to several specialized properties
			#$this->statusMYSQL->store_result();
			## Bind the fields for each returned record to local variables that we name
			#$this->statusMYSQL->bind_result($id, $status);
			#while( $this->statusMYSQL->fetch() ) { 
			#	$this->statusArray = array_merge($this->statusArray, array($id,$status)); 
			#	#echo "this happened!!!!";
			#};
			#$this->statusMYSQL->close();
			}

			public function get_categoryItems(){
			 $query_specialtyItems = "
				SELECT 
					id ,name
				FROM
					category
				
			";
			if ( $this->categoryMYSQL = $this->database->prepare($query_specialtyItems) ):
				$this->categoryMYSQL->execute();
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
		
			}
		#	public function get_links(){
		#	 $query_statusItems = "
		#		SELECT 
		#			id, link
		#		FROM
		#			post
		#		
		#	";
		#	if ( $this->statusMYSQL = $this->database->prepare($query_statusItems) ):
		#		$this->statusMYSQL->execute();
		#	else:
		#		die ( "<p class='error'>There was a problem executing your query</p>" );
		#	endif;
		#	
		#	}
			public function singlePostCategoryString($id){
				$query_onePostItem = "
				SELECT 
					post.id, post.title, post.link, post.commentary, status.id, group_concat(category.name) as `Category`
				FROM
					post
					LEFT JOIN 
						status
							ON post.statusID = status.id
					LEFT JOIN 
						PostCategory
							ON	post.id = PostCategory.postID
					LEFT JOIN 
						category 
							ON	category.id = PostCategory.categoryID
					WHERE 
						post.id =?
					GROUP BY post.id
					
			";

			# If the query from above prepares properly, execute it
			# Else, show an error message
			if ( $post = $this->database->prepare($query_onePostItem) ):
				$post->bind_param(
				 	'i',
				 	$id
				 );
				$post->execute();
				$post->bind_result($post_id,$title,$link,$commentary,$status,$category);
				 
				 $post->fetch();
				 
				 $postInfo["post_id"] = $post_id;
 				 $postInfo["post_title"] = $title;
 				 $postInfo["post_link"] = $link;
 				 $postInfo["post_commentary"] = $commentary;
 				 $postInfo["post_status"] = $status;
				 $postInfo["post_category"] = explode(',', $category);
								 
				 $post->close();
				 
				 return $postInfo;
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
			}
			public function singlePost($id){
				$query_onePostItem = "
				SELECT 
					post.id, post.title, post.link, post.commentary, status.id, group_concat(category.id) as `Category`
				FROM
					post
					LEFT JOIN 
						status
							ON post.statusID = status.id
					LEFT JOIN 
						PostCategory
							ON	post.id = PostCategory.postID
					LEFT JOIN 
						category 
							ON	category.id = PostCategory.categoryID
					WHERE 
						post.id =?
					GROUP BY post.id
					
			";

			# If the query from above prepares properly, execute it
			# Else, show an error message
			if ( $post = $this->database->prepare($query_onePostItem) ):
				$post->bind_param(
				 	'i',
				 	$id
				 );
				$post->execute();
				$post->bind_result($post_id,$title,$link,$commentary,$status,$category);
				 
				 $post->fetch();
				 
				 $postInfo["post_id"] = $post_id;
 				 $postInfo["post_title"] = $title;
 				 $postInfo["post_link"] = $link;
 				 $postInfo["post_commentary"] = $commentary;
 				 $postInfo["post_status"] = $status;
				 $postInfo["post_category"] = explode(',', $category);
								 
				 $post->close();
				 
				 return $postInfo;
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
			}
	
			# Pre-define our select query
			public function allPosts() {
				$query_allPostItems = "
				SELECT 
					post.id, post.title, post.link, post.commentary, status.name, group_concat(category.name SEPARATOR ', ') as `Category`
				FROM
					post
					LEFT JOIN 
						status
							ON post.statusID = status.id
					LEFT JOIN 
						PostCategory
							ON	post.id = PostCategory.postID
					LEFT JOIN 
						category 
							ON	category.id = PostCategory.categoryID
					GROUP BY post.id
					
			";

			# If the query from above prepares properly, execute it
			# Else, show an error message
			if ( $this->posts = $this->database->prepare($query_allPostItems) ):
				$this->posts->execute();
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
			#$this->allPosts();
#
			## Storing the result gives us access to several specialized properties
			#$this->wizards->store_result();
#
			## Bind the fields for each returned record to local variables that we name
			#$this->wizards->bind_result($id,$title,$status,$category);
			#while( $this->wizards->fetch() ) { 
			#	$this->postsArray = array($id,$title,$status,$category); 
			#	#echo "this happened!!!!";
			#};
			#$this->wizards->close();

		}
		public function allPostsTitle() {
				$query_allPostItems = "
				SELECT 
					post.id, post.title, post.link, post.commentary, status.name, group_concat(category.name SEPARATOR ',') as `Category`
				FROM
					post
					LEFT JOIN 
						status
							ON post.statusID = status.id
					LEFT JOIN 
						PostCategory
							ON	post.id = PostCategory.postID
					LEFT JOIN 
						category 
							ON	category.id = PostCategory.categoryID
					GROUP BY post.id
					ORDER BY post.title
					
			";

			# If the query from above prepares properly, execute it
			# Else, show an error message
			if ( $this->posts = $this->database->prepare($query_allPostItems) ):
				$this->posts->execute();
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
			
		}
		public function allPostsCategory() {
				$query_allPostItems = "
				SELECT 
					post.id, post.title, post.link, post.commentary, status.name, group_concat(category.name SEPARATOR ', ') as `Category`
				FROM
					post
					LEFT JOIN 
						status
							ON post.statusID = status.id
					LEFT JOIN 
						PostCategory
							ON	post.id = PostCategory.postID
					LEFT JOIN 
						category 
							ON	category.id = PostCategory.categoryID
					GROUP BY post.id
					ORDER BY category.name
					
			";

			# If the query from above prepares properly, execute it
			# Else, show an error message
			if ( $this->posts = $this->database->prepare($query_allPostItems) ):
				$this->posts->execute();
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
			
		}

		public function displayWizards() {
			$this->allPosts();

			# Storing the result gives us access to several specialized properties
			$this->posts->store_result();

			# Bind the fields for each returned record to local variables that we name
			$this->posts->bind_result($id,$title,$link,$commentary,$status,$category);
			 #If the database is empty, show a message accordingly
			if ( $this->posts->num_rows == 0 ):
				echo "
					<table>
						<tr>
							<td colspan='6' class='error'>
								<p>No potions currently found in stock at this time.</p>
							</td>
						</tr>
						<tr>
							<td colspan='6'>
								<form action='store-room.php' method='post'>
									<input type='hidden' name='activity' value='add_potion' />

									<input type='submit' name='btn_add' class='btn_action' value='Add To Do Item' />
								</form>
							</td>
						</tr>
					</table>
				";
			else:
				# Show all the potions
				echo "
			<div class='maindiv'>
			<h1>Current Posts</h1>
					<table class='table table-hover'>
						<thead>
						<tr>
							<th>ID</th>
							<th>Title</th>
							<th>Status</th>
							<th>Category</th>
							<th>Edit | Delete</th>
							
						</tr>
						</thead>
						<tbody>
				";
				#foreach ($this->postsArray as list($id,$title,$status,$category)) {
				#	echo "
				#		<tr class=''>
				#			<td class=''>$id</td>
				#			<td class=''>$title</td>
				#			<td class=''>$status</td>
				#			<td class=''>$category</td>	
				#			<td class=''><button>Edit</button><button>Delete</button></td>						
				#		</tr>";
				#}
				# Grabbing one potion record at a time display its respective information
				while( $this->posts->fetch() ):
						
					echo "
						<tr>";
							echo "<td>$id</td>";
							echo "<td>$title</td>";
							echo "<td>$status</td>";
							echo "<td>$category</td>";	
							echo "<td>
								<form action='add.php' class='form' method='post'>
									<input type='hidden' name='ID' value='$id' />
									<input type='submit' class='btn' name='btn_action' value='Edit'/>
								</form>	
								<form action='add.php' class='form' method='post'>
									<input type='hidden' name='ID' value='$id' />
									<input type='submit' class='btn' name='btn_action' value='Delete'/>
								</form>";
													
						echo "</tr>";
				endwhile;
				 #Close out the prepared statement
				

				echo "
					</tbody>
				</table>
			</form>";
			$this->posts->close();
				echo "<h1>Add Post</h1>
				<form action='add.php' class='addform' method='post'>";
				echo "<div class='center'>";
					echo "<span>Title:</span><input placeholder=\"Title\" id=\"addTitle\" class=\"default\" type=\"text\" name=\"Title\"/>";
					echo "<span>Link:</span><input placeholder=\"Link\" id=\"addLink\" class=\"default\" type=\"text\" name=\"Link\"/>";
					echo "<span>Status:</span><select name=\"Status\">";

						
						$this->get_statusItems();
						# Storing the result gives us access to several specialized properties
						$this->statusMYSQL->store_result();
#						# Bind the fields for each returned record to local variables that we name
						$this->statusMYSQL->bind_result($id, $status);
						while( $this->statusMYSQL->fetch() ):
							echo "<option value=\"$id\">$status</option>";
						endwhile;
						$this->statusMYSQL->close();
						#for ($i=0; $i < count($this->statusArray) ; $i++) { 
						#	echo "<option value='$id'>$status</option>";
						#}
						
						echo "</select>
												
						";
						$this->get_categoryItems();
						# Storing the result gives us access to several specialized properties
						$this->categoryMYSQL->store_result();

						# Bind the fields for each returned record to local variables that we name
						$this->categoryMYSQL->bind_result($id, $category);
						echo "<span>Categories:</span>";
						#echo "<div class='checkbox'>";											
						while( $this->categoryMYSQL->fetch() ) { 
							echo "<input class='boxcheck' type=\"checkbox\" name=\"check_list[]\" value='$id'><span>$category</span></input>";
						};
						$this->categoryMYSQL->close();
						echo "</div>";
						echo "<p class='commentarylabel'>Commentary:</p><textarea class='commentary' id=\"addCommentary\" class=\"default\" name=\"Commentary\"></textarea>";
						echo "
						<input class='btn addsubmit' type=\"submit\" name='btn_action' value=\"Add Post\"/>
						</div>";
			endif;
		}

		public function addPost($Title, $Link, $Commentary, $Status, $Category) {
			
			#echo "got to function";
			# Template for our insert query
			$insert_query = "
				INSERT INTO
					post
					(title, link, commentary, statusID)
				VALUES
					(?, ?, ?, ?)
			";

			# If the query prepares properly, send the record in to the database
			if ( $newPost = $this->database->prepare($insert_query) ):
				
				# First argument is the data types for each piece of information
				# Second argument is the data itself
				$newPost->bind_param(
					'sssi',
					$Title, $Link, $Commentary, $Status
				);
				
				$newPost->execute();
				
				# Close out the prepared statement
				$newPost->close();
			else:
				die ( "<p class='error'>There was a problem executing your query1</p>" );
			endif;
				# Return the index page, using the GET to supply a message
				#header("location: index.php?success=add");
			foreach ($Category as $catID) {
							
					$insert_query2 = "
					INSERT INTO
						PostCategory
						(postID, categoryID)
					VALUES
						((select MAX(id) from post), ?)
				";

				# If the query prepares properly, send the record in to the database
				if ( $newPostCategory = $this->database->prepare($insert_query2) ):
					
					# First argument is the data types for each piece of information
					# Second argument is the data itself
					$newPostCategory->bind_param(
						'i',
						$catID
					);
					
					$newPostCategory->execute();
					
					# Close out the prepared statement
					$newPostCategory->close();
				else:
					die ( "<p class='error'>There was a problem executing your query2</p>" );
				endif;
			}
				# Return the index page, using the GET to supply a message
			header("location: admin.php");
			#header("refresh: 0;"); 
			#echo "potentially ran query";
		}
		public function editPost($id, $Title, $Link, $Commentary, $Status, $Category) {
			
			#echo "got to function";
			# Template for our insert query
			$update_query = "
				UPDATE
					post
				SET
					title=?,
					link=?,
					commentary=?,
					statusID=?
				WHERE
					id=?
				LIMIT 1
			";

			# If the query prepares properly, send the record in to the database
			if ( $post_update = $this->database->prepare($update_query) ):
				
				# First argument is the data types for each piece of information
				# Second argument is the data itself
				$post_update->bind_param(
					'sssii',
					$Title, $Link, $Commentary, $Status, $id
				);
				
				$post_update->execute();
				
				# Close out the prepared statement
				$post_update->close();
			else:
				die ( "<p class='error'>There was a problem executing your query1</p>" );
			endif;
				# Return the index page, using the GET to supply a message
				#header("location: index.php?success=add");

				$delete_query = "
				DELETE FROM
					PostCategory
				WHERE
					postID=?
			";

			# If the query prepares properly, send the record in to the database
			if ( $deletePostCategory = $this->database->prepare($delete_query) ):
				
				# First argument is the data types for each piece of information
				# Second argument is the data itself
				$deletePostCategory->bind_param(
					'i',
					$id
				);
				
				$deletePostCategory->execute();
				
				# Close out the prepared statement
				$deletePostCategory->close();
			else:
				die ( "<p class='error'>There was a problem executing your query2</p>" );
			endif;
				# Return the index page, using the GET to supply a message
			
			foreach ($Category as $catID) {
							
					$insert_query = "
					INSERT INTO
						PostCategory
						(postID, categoryID)
					VALUES
						(?, ?)
				";

				# If the query prepares properly, send the record in to the database
				if ( $newPostCategory = $this->database->prepare($insert_query) ):
					
					# First argument is the data types for each piece of information
					# Second argument is the data itself
					$newPostCategory->bind_param(
						'ii',
						$id,$catID
					);
					
					$newPostCategory->execute();
					
					# Close out the prepared statement
					$newPostCategory->close();
				else:
					die ( "<p class='error'>There was a problem executing your query2</p>" );
				endif;
			}

			header("location: admin.php");
			#header("refresh: 0;"); 
			#echo "potentially ran query";
		}

		public function deletePost($postID) {
			
			#echo "got to function";
			# Template for our insert query
			$delete_query = "
				DELETE FROM
					post
				WHERE
					id=?
				LIMIT 1";

			# If the query prepares properly, send the record in to the database
			if ( $deletePost = $this->database->prepare($delete_query) ):
				
				# First argument is the data types for each piece of information
				# Second argument is the data itself
				$deletePost->bind_param(
					'i',
					$postID
				);
				
				$deletePost->execute();
				
				# Close out the prepared statement
				$deletePost->close();
			else:
				die ( "<p class='error'>There was a problem executing your query1</p>" );
			endif;
				# Return the index page, using the GET to supply a message
		#		#header("location: index.php?success=add");
#
		#		$delete_query2 = "
		#		DELETE FROM
		#			PostCategory
		#		WHERE
		#			id=?
		#		LIMIT 1
		#		";
#
		#	# If the query prepares properly, send the record in to the database
		#	if ( $deletePostCategory = $this->database->prepare($delete_query2) ):
		#		
		#		# First argument is the data types for each piece of information
		#		# Second argument is the data itself
		#		$deletePostCategory->bind_param(
		#			'i',
		#			$PostCategoryID
		#		);
		#		
		#		$deletePostCategory->execute();
		#		
		#		# Close out the prepared statement
		#		$deletePostCategory->close();
		#	else:
		#		die ( "<p class='error'>There was a problem executing your query2</p>" );
		#	endif;
		#		# Return the index page, using the GET to supply a message
			header("location: admin.php");
			#header("refresh: 0;"); 
			#echo "potentially ran query";		
		
		}

	}

?>