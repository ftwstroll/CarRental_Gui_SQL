<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
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






  $sql = "SELECT CustID, Name, VehicleID, StartDate, OrderDate, ReturnDate, PaymentDate, TotalAmount, Description, Year, CASE Category WHEN 0 THEN  'Basic'
  													                                     WHEN 1 THEN  'Luxury'
                                                                 end as Category,
                                                     CASE Type    WHEN 1 THEN 'Compact'
                                                                        WHEN 2 THEN 'Medium'
                                                                        WHEN 3 THEN 'Large'
                                                                        WHEN 4 THEN 'SUV'
                                                                        WHEN 5 THEN 'Truck'
                                                                        WHEN 6 THEN 'Van'
                                                                        END AS Type
          FROM (Rental natural join Customer) natural join vehicle
          WHERE Type like '%".$_POST["Type"]."%' AND
                Category like '%".$_POST["Category"]."%' AND
                VehicleID like '%".$_POST["VehicleID"]."%' AND
                Year like '%".$_POST["Year"]."%' AND
                ReturnDate like '%".$_POST["ReturnDate"]."%' AND
                Name like '%".$_POST["Name"]."%' AND
                Description like '%".$_POST["Description"]."%' And Returned = 0
                ";


  $result = $conn->query($sql);
  $num_rows = $result->num_rows;


  if ($result->num_rows > 0) {
      // output data of each row
      echo "<br><br><br> <h3>Results:</h3>";
      echo "Select your vehicle to return<br>";
      echo "<table>
             <tr>
              <th>Customer ID</th><th>Customer Name</th><th>Vin</th><th>Description</th><th>Year</th><th>Type</th><th>Category</th><th>Return Date</th><th></th>
             </tr>
        ";

      while($row = $result->fetch_assoc())
      {

        echo "<form action=\"rental_return.php\" method=\"post\">";
          echo "<tr><td>".$row["CustID"]."</td><td>".$row["Name"]."</td><td>".$row["VehicleID"]."</td><td>".$row["Description"]."</td><td>".$row["Year"]."</td><td>".$row["Type"]."</td><td>".$row["Category"]."</td><td>".$row["ReturnDate"]."</td>";
          echo "<input type=\"hidden\" name=\"CustID\" value=\"".$row["CustID"]."\">";
          echo "<input type=\"hidden\" name=\"ReturnDate\" value=\"".$row["ReturnDate"]."\">";
          echo "<input type=\"hidden\" name=\"VehicleID\" value=\"".$row["VehicleID"]."\">";
          echo "<input type=\"hidden\" name=\"TotalAmount\" value=\"".$row["TotalAmount"]."\">";
          echo "<input type=\"hidden\" name=\"PaymentDate\" value=\"".$row["PaymentDate"]."\">";
         echo "<td><input type=\"submit\" value=\"Select\"></td></tr>";




        echo "</form>";

      }
        echo "</table>";
        echo "Rows: ".$result->num_rows;
/*
      echo "<br><br>Payment Day?";
      echo "<select name=\"PaymentDate\" required size=\"2\">";
      echo "<option value=\"'NULL'\">On Return Date</option>";
      echo "<option value=\"CURDATE()\">On Order Date</option>";
      echo "</select>";

      echo "<input type=\"hidden\" name=\"CustID\" value=\"".$_POST["CustID"]."\">";
      echo "<input type=\"hidden\" name=\"StartDate\" value=\"".$SDate."\">";
      echo "<input type=\"hidden\" name=\"RentalType\" value=\"".$_POST["RentalType"]."\">";
      echo "<input type=\"hidden\" name=\"Qty\" value=\"".$_POST["Qty"]."\">";
      echo "<input type=\"hidden\" name=\"ReturnDate\" value=\"".$RDate."\">";
      echo "<input type=\"hidden\" name=\"TotalAmount\" value=\"".$TotalAmount."\">";
*/

  }
  else
  {
      echo "0 results";
  }


  $conn->close();
?>
  <br><br>
  <h3>Redo Search:</h3>

  <form action="rental/rental_return_search.php" method="post">

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
