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


$sql = "SELECT CustID FROM Customer WHERE CustID=".$_POST["CustID"];
$result = $conn->query($sql);


if($result->num_rows > 0)
{
  $SDate = date_create($_POST["SDate"]);
  $RDate = date_create($_POST["SDate"]);

  $interval = ((string) (  ((int)$_POST["RentalType"]) *  ((int)$_POST["Qty"])  ))." days";


  date_add($RDate,date_interval_create_from_date_string( $interval));
  $RDate = date_format($RDate,"Y-m-d");
  $SDate = date_format($SDate,"Y-m-d");


  echo "<br><br>From ".$SDate." to ".$RDate;

  if ($_POST["RentalType"] === "7")
  {
    $RentalType = "Weekly";
  }
  else
  {
    $RentalType = "Daily";
  }
  $sql = "SELECT ".$RentalType." FROM Rate WHERE Type=".$_POST["Type"]." AND Category=".$_POST["Category"];
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();


  $TotalAmount =  number_format( (floatval($_POST["Qty"]) * floatval($row[$RentalType])), 2, '.',',')  ;


  echo "<br>Rental Amount: $";
  echo $TotalAmount;


  $TotalAmount =  number_format( (floatval($_POST["Qty"]) * floatval($row[$RentalType])), 2, '.','')  ;



  $sql = "SELECT v.VehicleID, v.Description, v.Year, CASE Type WHEN 0 THEN  'Basic'
  													                                     WHEN 1 THEN  'Luxury'
                                                                 end as Type,
                                                     CASE v.Category    WHEN 1 THEN 'Compact'
                                                                        WHEN 2 THEN 'Medium'
                                                                        WHEN 3 THEN 'Large'
                                                                        WHEN 4 THEN 'SUV'
                                                                        WHEN 5 THEN 'Truck'
                                                                        WHEN 6 THEN 'Van'
                                                                        END AS Category
          FROM vehicle v
          WHERE v.Type=".$_POST["Type"]." AND
                v.Category = ".$_POST["Category"]." AND
                v.VehicleID NOT IN (SELECT VehicleID
                                    FROM rental
                                    WHERE NOT ((StartDate < '".$SDate."' And ReturnDate < '".$SDate."') or ((StartDate > '".$RDate."'))))";
  $result = $conn->query($sql);
  $num_rows = $result->num_rows;


  if ($result->num_rows > 0) {
      // output data of each row
      echo "<br><br><br> <h3>Results:</h3>";
      echo "Select your vehicle to rent";
      echo "<form action=\"rental_add.php\" method=\"post\">";
      echo "<select name=\"VehicleID\" size=\"$num_rows\" required>";
      while($row = $result->fetch_assoc())
      {
          echo "<option value=\"".$row["VehicleID"]."\">".$row["VehicleID"]." ".$row["Description"]."</option>";
      }
      echo "</select>";
        echo "<br>Rows: ".$result->num_rows;
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

      echo "<br><input type=\"submit\" value=\"Select\">";




      echo "</form>";
  } else {
      echo "0 results";
  }
}
else
{
  echo "No such record for Customer ID ".$_POST["CustID"].".";
  echo "<br>Redo search below, go back, or create a new Customer at <a href=\"http://localhost/cust_add.html\">Add Customer</a>";
}

  $conn->close();
  ?>
  <br><br>
  <h3>Redo Search:</h3>

  <form action="rental_add_search.php" method="post">
    Customer ID:<br>
      <input type="number" name="CustID" min="1">
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
   <input type="number" name="Qty" size="2" min="1">

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
