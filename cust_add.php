<!DOCTYPE html>
<html>
<body>
  <a href="http://localhost/rental/cust_add.php">Add Customer</a>

  <a href="http://localhost/rental/vehicle_add.php">Add Vehicle</a>

  <a href="http://localhost/rental/rental_add.php">Rent Vehicle</a>

  <a href="http://localhost/rental/rental_return.php">Rental Return</a>

  <a href="http://localhost/rental/rental_vview_search.php">View Search</a>



<?php

if (isset($_POST["pone"])) {
  $host = "localhost";
  $user = "root";
  $port = 3306;
  $socket = "";
  $password = "CSE3330";
  $dbname = "local instance mysql80";

  // Create connection
  $conn = mysqli_connect("127.0.0.1", $user, $password,"project");
  // Check connection
  if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
  }

  $Phone = "(".$_POST["pone"].") ".$_POST["ptwo"]."-".$_POST["pthree"];
  $sql = "INSERT INTO Customer (Name, Phone)
  VALUES ('".$_POST["name"]."','".$Phone."')";

  if ($conn->query($sql) === TRUE) {
     echo "<br><br>New Customer record created successfully";
  } else {
     echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<h1>The first requirement is to add information about a new customer. Do not provide the customer ID in
your query. Submit your editable SQL query that your code executes. </h1>

<form action="cust_add.php" method="post">
  Name:<br>
  <input type="text" name="name" required>
  <br>
  Phone:<br>
  (<input type="number" name="pone" min="100" max="999" required>)
   <input type="number" name="ptwo"  min="100" max="999"  required>
   -<input type="number" name="pthree"  min="1000" max="9999"  required>
  <br><br>
  <input type="submit" value="Submit">
</form>


</body>
</html>
