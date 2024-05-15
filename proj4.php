<!DOCTYPE html>
<!--
/************************************************************/
/* Author: Rachel Alden
/* Major: Computer Science
/* Creation Date: April 8th, 2024
/* Due Date: April 10th, 2024
/* Course: CSC 242
/* Professor Name: Dr. Carelli
/* Assignment: #4
/* Filename: proj4.php
/* Purpose: Collect user requests from an HTML form, pass
/* that information to a server, retrieve the requested 
/* information from a database, and display requested
/* information in a browser.
/************************************************************/
-->
<html lang="en">
<head>
  <title>Books</title>
  <link rel = "stylesheet" type = "text/css"
       href = "style.css">
</head>
<body>

<h1>Book Information</h1>

<form action="proj4.php" method="get">
  <select name="type">
    <option value="Category">Category</option>
    <option value="Author">Author</option>
  </select>
  <input type="text" name="name">
  <input type="submit" value="Search">
</form>
<br>

<?php

ini_set ('display_errors', 1); // Let me learn from my mistakes!
error_reporting (E_ALL);

//PREPARE PDO OBJECT

$dbname = "sqlite:books.db";
$db = new PDO($dbname);

//SEARCH FOR MATCHES

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['type']) && isset($_GET['name'])){
        $search_type = $_GET['type'];	//category or author
        $search_key = $_GET['name'];	//user input

	$query = "SELECT * FROM Books WHERE $search_type = '$search_key'";
	$result = $db->query($query);
	$rows = $result->fetchAll(PDO::FETCH_ASSOC);

	if ($rows) {
            echo "<h3>Matching Books</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Title</th><th>Year</th><th>Category</th><th>Author</th></tr>";

            foreach ($rows as $row) {
                echo "<tr>";
                echo "<td>" . $row['Title'] . "</td>";
                echo "<td>" . $row['Year'] . "</td>";
                echo "<td>" . $row['Category'] . "</td>";
                echo "<td>" . $row['Author'] . "</td>";
                echo "</tr>";
            }
	echo "</table>";
	} else {
        	echo "<h3>Error: Invalid value for $search_type</h3>";
		$query = "SELECT DISTINCT $search_type FROM Books";
	        $result = $db->query($query);
        
        	$values = $result->fetchAll(PDO::FETCH_COLUMN);
        
        	if ($values) {
            		echo "<p>Valid values are:</p>";
            		echo "<ul>";
        	        foreach ($values as $value) {
                		echo "<li>$value</li>";
            		}
            		echo "</ul>";
        		}
		}
	}
}


?>
</body>
</html>
