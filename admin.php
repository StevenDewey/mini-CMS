<?php 
require 'queries.php'; # Make sure you have the needed Class file
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

 <?php 
$myWizard = new wizard;


$myWizard->displayWizards();
?>