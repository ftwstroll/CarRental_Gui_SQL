LOAD DATA INFILE 'c:/ProgramData/MySQL/MySQL Server 8.0/Uploads/CUSTOMER.CSV'
INTO TABLE CUSTOMER
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
;

LOAD DATA INFILE 'c:/ProgramData/MySQL/MySQL Server 8.0/Uploads/VEHICLE.CSV'
INTO TABLE VEHICLE
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
;

LOAD DATA INFILE 'c:/ProgramData/MySQL/MySQL Server 8.0/Uploads/RATE.CSV'
INTO TABLE RATE
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
;

LOAD DATA INFILE 'c:/ProgramData/MySQL/MySQL Server 8.0/Uploads/RENTAL.CSV'
INTO TABLE RENTAL
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
;


