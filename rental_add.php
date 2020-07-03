<!DOCTYPE html>
<html>
<body>
  <a href="http://localhost/rental/cust_add.php">Add Customer</a>

  <a href="http://localhost/rental/vehicle_add.php">Add Vehicle</a>

  <a href="http://localhost/rental/rental_add.php">Rent Vehicle</a>

  <a href="http://localhost/rental/rental_return.php">Rental Return</a>

  <a href="http://localhost/rental/rental_vview_search.php">View Search</a>


<?php

    if (isset($_POST["CustID"])) {

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
    VALUES (".$_POST["CustID"].",'".$_POST["VehicleID"]."','".$_POST["StartDate"]."',CURDATE(),".$_POST["RentalType"].",".$_POST["Qty"].",'".$_POST["ReturnDate"]."',
            ".$_POST["TotalAmount"].","
            .$_POST["PaymentDate"].",0)";

    if ($conn->query($sql) === TRUE) {
       echo "<br><br>New rental record created successfully";
    } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();


      echo "<br><br> Rent another vehicle";
  }

?>


<h2>The third requirement is to add all the information about a new rental reservation (this must find a free
vehicle of the appropriate type and category for a specific rental period). We assume that the customer
has the right either to pay at the order or return date. Submit your editable SQL queries (select available
vehicles & insert rental) that your code executes.</h2>


<form action="rental_add_search.php" method="post">
  Customer ID:<br>
    <input type="number" name="CustID" min="1" required>
  <br><br>
  Start Date:<br>
    <input id="datefield" type="date" name="SDate" min='2019-01-01' required>

  <br><br>
  Rental Period:
  <br>
  Type
  <select name="RentalType" size"2">
     <option value="1">Days</option>
     <option value="7">Weeks</option>
 </select>
 How many?
 <input type="number" name="Qty" size="2" min="1" required>

  <br><br>
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

   <br><br>
    Category:
   <br>
   <select name="Category">
      <option value="0">Basic</option>
      <option value="1">Luxury</option>
  </select>
  <br><br>
  <input type="submit" value="Submit">
</form>


<script>
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1;
  var yyyy = today.getFullYear();
   if(dd<10){
          dd='0'+dd
      }
      if(mm<10){
          mm='0'+mm
      }

  today = yyyy+'-'+mm+'-'+dd;
  document.getElementById("datefield").setAttribute("min", today);
</script>

</body>
</html>
