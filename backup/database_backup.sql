

CREATE TABLE `billpurchase` (
  `bpid` int(11) NOT NULL AUTO_INCREMENT,
  `cartno` int(25) NOT NULL,
  `bpdate` date NOT NULL,
  `bpsid` int(15) NOT NULL,
  `bppid` int(15) NOT NULL,
  `quantity` int(15) NOT NULL,
  `cost` float(25,2) NOT NULL,
  `mrp` float(25,2) NOT NULL,
  `tax` float(25,2) NOT NULL,
  `discount` float(25,2) NOT NULL,
  `netamt` float(25,2) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`bpid`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO billpurchase VALUES("53","1","2023-09-27","9","40","10","125999.00","199999.00","18.00","0.00","1486788.25","1");
INSERT INTO billpurchase VALUES("54","1","2023-09-27","9","41","12","99999.00","125999.00","18.00","0.00","1415985.88","1");
INSERT INTO billpurchase VALUES("55","1","2023-09-28","9","40","2","125999.00","199999.00","18.00","0.00","297357.62","1");



CREATE TABLE `billsale` (
  `bsid` int(11) NOT NULL AUTO_INCREMENT,
  `cartno` int(25) NOT NULL,
  `bsdate` date NOT NULL,
  `custid` int(25) NOT NULL,
  `proid` int(25) NOT NULL,
  `quantity` int(25) NOT NULL,
  `cost` float(25,2) NOT NULL,
  `mrp` float(25,2) NOT NULL,
  `tax` float(25,2) NOT NULL,
  `discount` float(25,2) NOT NULL,
  `netamt` float(25,2) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`bsid`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO billsale VALUES("53","1","2023-09-28","43","40","1","125999.00","199999.00","18.00","0.00","199999.00","1");
INSERT INTO billsale VALUES("54","1","2023-09-28","43","41","2","99999.00","125999.00","18.00","0.00","251998.00","1");



CREATE TABLE `customers` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `orders` varchar(10) NOT NULL,
  `retailer` varchar(5) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO customers VALUES("43","Neeraj Kumar","9887654525","neeraj@email.com","India","1","NO");



CREATE TABLE `payment` (
  `payid` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL,
  `typeid` int(50) NOT NULL,
  `amount` float(25,2) NOT NULL,
  `paid` float(25,2) NOT NULL,
  `balance` float(25,2) NOT NULL,
  `paydate` date NOT NULL,
  `mode` varchar(25) NOT NULL,
  `recid` varchar(50) NOT NULL,
  PRIMARY KEY (`payid`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO payment VALUES("44","Supplier","9","2902774.25","2902774.25","0.00","2023-09-27","Cheque","28");
INSERT INTO payment VALUES("45","Supplier","9","297357.62","297357.62","0.00","2023-09-28","Cheque","29");
INSERT INTO payment VALUES("46","Customer","43","451997.00","450000.00","1997.00","2023-09-28","Cash","27");



CREATE TABLE `products` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  `code` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `cost` float(25,2) NOT NULL,
  `price` float(25,2) NOT NULL,
  `tax` float(25,2) NOT NULL,
  `discount` float(25,2) NOT NULL,
  `profit` float(25,2) NOT NULL,
  `quantity` int(25) NOT NULL,
  `retmrp` float(25,2) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO products VALUES("40","Smartphone","IP015","IPhone 15","Apple","125999.00","199999.00","18.00","0.00","38000.18","11","189999.00");
INSERT INTO products VALUES("41","Smartphone","SMS23","Samsung S23 Ultra","Samsung","99999.00","125999.00","18.00","0.00","3320.18","10","120999.00");



CREATE TABLE `purchase` (
  `purid` int(11) NOT NULL AUTO_INCREMENT,
  `cartno` int(25) NOT NULL,
  `purdate` date NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `gst` varchar(15) NOT NULL,
  `purstatus` varchar(15) NOT NULL,
  `total` float(25,2) NOT NULL,
  `paid` float(25,2) NOT NULL,
  `balance` float(25,2) NOT NULL,
  `paystatus` varchar(25) NOT NULL,
  `mode` varchar(25) NOT NULL,
  PRIMARY KEY (`purid`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO purchase VALUES("28","1","2023-09-27","9","99XXXXX9999X9XX","Received","2902774.25","2902774.25","0.00","Paid","Cheque");
INSERT INTO purchase VALUES("29","1","2023-09-28","9","99XXXXX9999X9XX","Received","297357.62","297357.62","0.00","Paid","Cheque");



CREATE TABLE `sale` (
  `salid` int(11) NOT NULL AUTO_INCREMENT,
  `cartno` int(25) NOT NULL,
  `saldate` date NOT NULL,
  `custid` int(25) NOT NULL,
  `salstatus` varchar(25) NOT NULL,
  `total` float(25,2) NOT NULL,
  `paid` float(25,2) NOT NULL,
  `balance` float(25,2) NOT NULL,
  `paystatus` varchar(25) NOT NULL,
  `mode` varchar(25) NOT NULL,
  `biller` varchar(50) NOT NULL,
  PRIMARY KEY (`salid`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO sale VALUES("27","1","2023-09-28","43","Received","451997.00","450000.00","1997.00","Due","Cash","Shubham Kumar Gupta");



CREATE TABLE `suppliers` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  `gst` varchar(25) NOT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO suppliers VALUES("9","Rajat Singh","ABC Enterprises","rajat@email.com","9988776655","India","99XXXXX9999X9XX");



CREATE TABLE `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `business` varchar(25) NOT NULL,
  `address` varchar(50) NOT NULL,
  `gst` varchar(25) NOT NULL,
  `role` varchar(15) NOT NULL,
  `joindate` date NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO users VALUES("19","Shubham Kumar Gupta","9988775454","shubham14243@email.com","6a95c0df38e54945180f4d5e66b69b86","Online Retail Store","India","99XXXXX9999X9XX","Admin","2023-09-28");

