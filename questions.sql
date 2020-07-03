
#drop table customer, vehicle, rental, rate;
/*
SHOW VARIABLES LIKE "secure_file_priv";
select *
from rental*/

select  Description
from vehicle;

select  * 
from customer;

select  * 
from Rate;

SELECT *
FROM RENTAL;

#QUESTION 1
INSERT INTO CUSTOMER(Name, Phone)
VALUES ("h. Diaz", "(555) 555-5555");

#QUESTION 2
UPDATE CUSTOMER AS C1, (SELECT CustID FROM CUSTOMER WHERE NAME = "h. Diaz") AS C2
SET C1.Phone = "(837) 721-8965"
WHERE C1.CustID = C2.CustID;

#Question 3
UPDATE Rate
SET Daily = Daily * 1.05
WHERE category = 1 and type >= 0;

#Question 4-A
INSERT INTO VEHICLE(VehicleID, Description, Year, Type, Category)
VALUES ("5FNRL6H58KB133711", "Honda Odyssey",2019,6,1)  ON DUPLICATE KEY UPDATE VehicleID = "5FNRL6H58KB133711", Description ="Honda Odyssey", Type = 6, year = 2019, Category = 1 ;

#Question 4-B
INSERT INTO RATE(Type, Category, Weekly, Daily)
Values (5, 1, 900.00, 150.00),(6,1,800.00,135.00)  #Type = 5, Category = 1, Weekly = 900.00, Daily = 150.00;
ON DUPLICATE KEY UPDATE  Type = Type;

#Question 5
SELECT R.VehicleID as VIN, V.Description, V.year, sum( R.RentalType * R.Qty) as days,R.StartDate, R.ReturnDate
FROM rental AS R, VEHICLE AS V
WHERE V.category = 1 AND V.Type = 1 AND R.VehicleID = V.VehicleID AND (R.ReturnDate < '2019-06-01' OR R.ReturnDate > '2019-06-20') AND (R.StartDate < '2019-06-01' OR R.StartDate > '2019-06-20')
group by vin;

#Question 6
SELECT DISTINCT C.Name, B.balance
FROM RENTAL AS R, CUSTOMER AS C, (SELECT Custid, SUM(TotalAmount) as balance
									FROM Rental
                                    where PaymentDate = "NULL"
                                    Group by Custid) as B
WHERE B.CustID = 221 AND C.CustID = 221;

#Question 7
SELECT VehicleID as VIN, Description, Year, CASE Type WHEN 0 THEN  'Basic'
													  WHEN 1 THEN  'Luxury' end as Type, Category
FROM VEHICLE 



