<!DOCTYPE html>
<html>
<body>
  <a href="http://localhost/rental/cust_add.php">Add Customer</a>

  <a href="http://localhost/rental/vehicle_add.php">Add Vehicle</a>

  <a href="http://localhost/rental/rental_add.php">Rent Vehicle</a>

  <a href="http://localhost/rental/rental_return.php">Rental Return</a>

  <a href="http://localhost/rental/rental_vview_search.php">View Search</a>



<?php
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

$sql = "INSERT INTO Rental (CustID,VehicleID,StartDate,OrderDate,RentalType,Qty,ReturnDate,TotalAmount,PaymentDate,Returned)
VALUES ('".$_POST["CustID"]."','".$_POST["VehicleID"]."','".$_POST["StartDate"]."',CURDATE(),'".$_POST["RentalType"]."','".$_POST["Qty"]."'
        ,'".$_POST["ReturnDate"]."','".$_POST["TotalAmount"]."',".$_POST["PaymentDate"].",'0')";

if ($conn->query($sql) === TRUE) {
   echo "New rental record created successfully";
} else {
   echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


  <a href="http://localhost/cust_add.html">Add Customer</a>
  <br>
  <a href="http://localhost/vehicle_add.html">Add Vehicle</a>
  <br>
  <a href="http://localhost/rental_add.html">Rent Vehicle</a>







</body>
</html>
