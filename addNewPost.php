<?php
	require_once 'queries.php';

?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		
		<link rel="stylesheet" href="styles.css" />

		<title>Potion Storeroom</title>
	</head>
	
	<body>
		<p><a class="return" href="index.php">&laquo; Back to Inventory</a></p>
		
		<h1>Potion Storeroom</h1>
		
		<?php
			if ($error > 0):
				echo "<p class='error'>Please fill out all the fields.</p>";
			endif;
		?>

		<form name="storeroom" id="storeroom" method="post">
			<fieldset>
				<legend>Potion Details</legend>
				
				<input type="hidden" name="form_action" value="<?=$action;?>" />

				<?php if ( isset($potion_id) ): ?>
					<input type="hidden" name="potion_id" value="<?=$potion_id;?>" />
				<?php endif; ?>

				<p>
					<label for="potion_name">Name:</label>
					<input type="text" name="potion_name" value="<?=(isset($potion_name)?$potion_name:"");?>" />
				</p>
				
				<p>
					<label for="potion_color">Color:</label>
					<input type="text" name="potion_color" value="<?=(isset($potion_color)?$potion_color:"");?>" />
				</p>
				
				<p>
					<label for="intended_effects">Intended Effects:</label>
					<input type="text" name="intended_effects" value="<?=(isset($intended_effects)?$intended_effects:"");?>" />
				</p>

				<p>
					<label for="side_effects">Side Effects:</label>
					<input type="text" name="side_effects" value="<?=(isset($side_effects)?$side_effects:"");?>" />
				</p>

				<p>
					<label for="toxic">Toxic:</label>
					Yes <input type="radio" name="toxic" value="1" <?=(isset($toxic)&&$toxic)?"checked":"";?> />
					No <input type="radio" name="toxic" value="0" <?=(isset($toxic)&&!$toxic)?"checked":"";?> />
				</p>
				
				<p>
					<label for="quantity">Quantity:</label>
					<input type="text" name="quantity" value="<?=(isset($quantity)?$quantity:"");?>" />
				</p>

				<input type="submit" name="btn_action" class="btn_action <?=$action;?>" value="<?=$btn_value;?>" />
			</fieldset>
		</form>
	</body>
</html>