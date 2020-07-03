<!DOCTYPE html>
<html>
<body>
  <a href="http://localhost/rental/cust_add.php">Add Customer</a>

  <a href="http://localhost/rental/vehicle_add.php">Add Vehicle</a>

  <a href="http://localhost/rental/rental_add.php">Rent Vehicle</a>

  <a href="http://localhost/rental/rental_return.php">Rental Return</a>

  <a href="http://localhost/rental/rental_vview_search.php">View Search</a>



<?php
  if (isset($_POST["PaymentDate"])) {

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

    if ($_POST["PaymentDate"] === "NULL")
    {
      $TotalAmount =  number_format( (floatval($_POST["TotalAmount"])), 2, '.',',')  ;
      echo "<br><br>Amount Due is $".$TotalAmount;
      echo "<br>".$_POST["ReturnDate"]."<br><br>";
    }
    else
    {
      echo "<br><br>Balance of 0. Payed on order Date.";
    }

    $sql = "UPDATE Rental
            SET Returned = 1, PaymentDate = '".$_POST["ReturnDate"]."'
            WHERE  CustID = ".$_POST["CustID"]." AND VehicleID ='".$_POST["VehicleID"]."' AND ReturnDate = '".$_POST["ReturnDate"]."'" ;

    if ($conn->query($sql) === TRUE) {
       echo "Vehicle returned successfully";
    } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    echo "<br><br> Return another vehicle <br><br>";
  }
?>

<h2>The fourth requirement is to handle the return of a rented car. This transaction should print the total
customer payment due for that rental, enter it in the database and update the returned attribute
accordingly. You need to be able to retrieve a rental by the return date, customer name (the table needs
the id), and vehicle info. Submit your editable SQL queries (retrieve & update rental) that your code
executes.</h2>


<form action="rental_return_search.php" method="post">

Name:
<input type="text" id="Name" name="Name">
<br>
Return Date:
<input type="date" id="ReturnDate" name="ReturnDate" >
<br>
Vin:
<input type="text" id="VehicleID" name="VehicleID">
<br>
Description:
<input type="text" id="Description" name="Description">
<br>
Year:
<input type="number" id="Year" name="Year" min="1800">
<br>
Type:
<select id="Type" name="Type">
  <Option></option>
   <option value="1">Compact</option>
   <option value="2">Medium</option>
   <option value="3">Large</option>
   <option value="4">SUV</option>
   <option value="5">Truck</option>
   <option value="6">Van</option>
</select>
<br>
Category:
<select id="Category" name="Category">
  <Option></option>
   <option value="0">Basic</option>
   <option value="1">Luxury</option>
</select>
<br>
<input type="submit" value="Search">

</form>

<script>

//this javascript will enter default if blank
//#########################
function InsertDefaultValues()
{

   var FieldsAndDefault = new Array();


   //"idname defaultvalue"
   FieldsAndDefault.push("Name %");
   FieldsAndDefault.push("ReturnDate %");
   FieldsAndDefault.push("VehicleID %");
   FieldsAndDefault.push("Description %");
   FieldsAndDefault.push("Year %");
   FieldsAndDefault.push("Type %");
   FieldsAndDefault.push("Category %");

   for( var i=0; i<FieldsAndDefault.length; i++ )
   {
      FieldsAndDefault[i] = FieldsAndDefault[i].replace(/^\s*/,"");
      var pieces = FieldsAndDefault[i].split(" ");
      var field = pieces.shift();
      var f = document.getElementById(field);
      if( f.value.length < 1 ) { f.value = pieces.join(" "); }
   }
   return true;
}
</script>


</body>
</html>
