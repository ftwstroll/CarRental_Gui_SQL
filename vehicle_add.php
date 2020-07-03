<!DOCTYPE html>
<html>
<body>
  <a href="http://localhost/rental/cust_add.php">Add Customer</a>

  <a href="http://localhost/rental/vehicle_add.php">Add Vehicle</a>

  <a href="http://localhost/rental/rental_add.php">Rent Vehicle</a>

  <a href="http://localhost/rental/rental_return.php">Rental Return</a>

  <a href="http://localhost/rental/rental_vview_search.php">View Search</a>


<?php

  if (isset($_POST["VehicleID"])) {

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

    $sql = "INSERT INTO VEHICLE(VehicleID, Description, Year, Type, Category)
    VALUES ('".$_POST["VehicleID"]."','".$_POST["Description"]."',".$_POST["Year"].",'".$_POST["Type"]."','".$_POST["Category"]."')";

    if ($conn->query($sql) === TRUE) {
       echo "<br><br>New vehicle record created successfully";
    } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    echo "<br><br><br> Add another vehicle <br><br><br>";
  }
?>




<h2>The second requirement is to add all the information about a new vehicle. Submit your editable SQL
query that your code executes.</h2>


<form action="vehicle_add.php" method="post">
  Vin Number:<br>
  <input type="text" name="VehicleID" required  pattern=".{17,17}" required title="17 characters">
  <br>
  Description:
  <br>
  <input type="text" name="Description" maxlength="30" size="30" required>
  <br>
  Year(YYYY):
  <br>
   <input type="number" name="Year" min="1800" required>
   <br>
   Type:
   <br>
   <select name="Type">
      <option value="1">Compact</option>
      <option value="2">Medium</option>
      <option value="3">Large</option>
      <option value="4">SUV</option>
      <option value="5">Truck</option>
      <option value="6">Van</option>
  </select>

   <br>
   Category:
   <br>
   <select name="Category">
      <option value="0">Basic</option>
      <option value="1">Luxury</option>
  </select>
  <br><br>
  <input type="submit" value="Submit">
</form>


</body>
</html>
