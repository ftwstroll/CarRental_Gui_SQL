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

<table>
<tr>
  <td>
  <form action="rental_cview_search.php" method="post">

  <h5>Customer Search </h5>
  Name:
  <input type="text" id="Name" name="Name">
  <br>
  ID:
  <input type="number" id="CustID" name="CustID" >
  <br>
  <input type="submit" value="Search">

  </form>
</td>
<td>

  <form action="rental_vview_search.php" method="post">

  <h5>Vehicle Search </h5>

  Vin:
  <input type="text" id="VehicleID" name="VehicleID">
  <br>
  Description:
  <input type="text" id="Description" name="Description">

  <br>
  <input type="submit" value="Search">

  </form>
</td>
</tr>
</table>


















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





  $sql = "SELECT V.VIN, V.Vehicle, IFNULL(concat('$',format(sum(VR.OrderAmount)/sum(VR.TotalDays),2)),'Not Applicable') as DailyPrice
          FROM (SELECT VehicleID as VIN, Description as Vehicle FROM Vehicle) as V left outer join vRentalinfo as VR on V.VIN = VR.VIN

            where V.Vin LIKE '%".$_POST["VehicleID"]."%' AND V.Vehicle LIKE '%".$_POST["Description"]."%'
              group by V.VIN;
            ";


    $result = $conn->query($sql);
    $num_rows = $result->num_rows;




    if ($result->num_rows > 0) {
        // output data of each row
        echo "<br><br><br> <h3>Results:</h3>";
        echo "<table>
               <tr>
                <th>Vehicle Id</th><th>Description</th><th>Daily Average</th>
               </tr>
          ";

        while($row = $result->fetch_assoc())
        {


            echo "<tr><td>".$row["VIN"]."</td><td>".$row["Vehicle"]."</td><td>".$row["DailyPrice"]."</td>";


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
}
?>



  <script>

  //this javascript will enter default if blank
  //#########################
  function InsertDefaultValues()
  {

     var FieldsAndDefault = new Array();


     //"idname defaultvalue"
     FieldsAndDefault.push("Name %");
     FieldsAndDefault.push("CustID %");
     FieldsAndDefault.push("VehicleID %");
     FieldsAndDefault.push("Description %");


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
