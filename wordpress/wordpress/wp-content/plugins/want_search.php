<?php
/**
 * Plugin Name: want_search
 */
   if (isset($_POST['submit'])) {
  //do database request here
       $mysql= new mysqli("localhost","root","","wordpress");
         

       $test=$mysql->real_escape_string($_POST['test']);

      # $sql= "SELECT product_name FROM food_cals";
       $result=$mysqli->query("SELECT product_name FROM food_cals");
       if ($result->num_rows) {
         $row=$result-> fetch_row();
         print_r($row);
         
        }else 
        echo "Don't match any data" ;
      }

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Search</title>
</head>
<body>

	<form action="want_search.php" method="POST">
     <input type="text" name="test" placeholder="Search Query...." />
     <input type="submit" name="submit" value="Submit" />
    </form>
	
</body>
</html>