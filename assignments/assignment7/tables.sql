CREATE TABLE customer (
    id INT NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(50),
    lastname  VARCHAR(50),
    address   VARCHAR(100),
    city      VARCHAR(50),
    state     VARCHAR(2),
    zip       VARCHAR(10),
    phone     VARCHAR(20),
    email     VARCHAR(100),
    password  VARCHAR(255),
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE product_group (
    id INT NOT NULL AUTO_INCREMENT,
    groupname   VARCHAR(50),
    imagefolder VARCHAR(255),
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE product (
    id INT NOT NULL AUTO_INCREMENT,
    groupid INT,
    productname  VARCHAR(100),
    productprice VARCHAR(50),
    image        VARCHAR(255),
    description  TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE orders (
    id INT NOT NULL AUTO_INCREMENT,
    timestamp INT,
    customerid INT,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE order_info (
    id INT NOT NULL AUTO_INCREMENT,
    orderid   INT,
    productid INT,
    amount    INT,
    PRIMARY KEY (id)
) ENGINE=InnoDB;
