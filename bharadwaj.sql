-- create and select the database
-- change your_server_user_name in the following line before running this file
USE fakestore;  -- MySQL command

-- drop tables if already exist
DROP TABLE IF EXISTS orderHistory;
/*DROP TABLE IF EXISTS userInformation;*/
DROP TABLE IF EXISTS cart;
DROP TABLE IF EXISTS itemsForSale;
DROP TABLE IF EXISTS users;

-- create the tables

CREATE TABLE users(
    username        VARCHAR(111)    NOT NULL    UNIQUE,
    user_password   VARCHAR(255)    NOT NULL,
    type            VARCHAR(11)     NOT NULL    DEFAULT 'user',
    PRIMARY KEY (username)
);

/*CREATE TABLE userInformation(
    username        VARCHAR(111)    NOT NULL,
    first_name      VARCHAR(111),
    last_name       VARCHAR(255),
    phone           VARCHAR(11)     NOT NULL,
    email           VARCHAR(77)     NOT NULL,
    CONSTRAINT FOREIGN KEY (username) references users(username)
);*/

CREATE TABLE itemsForSale (
    name            VARCHAR(44)     NOT NULL,
    cost            DECIMAL(33,2)   NOT NULL,
    identifier      VARCHAR(111)    NOT NULL,
    description     VARCHAR(333),
    hidden          VARCHAR(5)      NOT NULL    DEFAULT 'false',
    PRIMARY KEY (identifier)
);

CREATE TABLE orderHistory (
    username        VARCHAR(111)    NOT NULL,
    identifier      VARCHAR(111)    NOT NULL,
    licenseKey      VARCHAR(255)    NOT NULL    UNIQUE,
    dateOfPurchase  VARCHAR(66)     NOT NULL,
    paid            DECIMAL(33,2)   NOT NULL,
    orderNumber     int             NOT NULL    AUTO_INCREMENT,
    PRIMARY KEY (orderNumber),
    CONSTRAINT FOREIGN KEY (identifier) references itemsForSale(identifier),
    CONSTRAINT FOREIGN KEY (username) references users(username)
);

CREATE TABLE cart (
    username        VARCHAR(111)    NOT NULL,
    identifier      VARCHAR(111)    NOT NULL,
    CONSTRAINT FOREIGN KEY (username) references users(username),
    CONSTRAINT FOREIGN KEY (identifier) references itemsForSale(identifier)
);

-- populate the database
INSERT INTO itemsForSale(name, cost, identifier, description)
VALUES
('The Purple Scribbler.exe','932487.39','purple_scribbles', 'Draws purple scribbles all over the screen.'),
('Planner App','22.39','planner', 'Allows user to plan homework, schoolwork, etc.'),
('Plushware','0.01','plushy', 'Virus that replaces all images on PC with images of tedddy bear!'),
('PHP writer','73','php_write', 'Writes all your PHP code for you.'),
('JavaScript writer','0.00','jscript_write', 'Writes all your JavaScript for you.'),
('SQL writer','0.11','sql_write', 'Writes all your SQL for you.'),
('HTML writer','10','html_write', 'Writes all your HTML for you.'),
('CSS writer','10.0','css_write', 'Writes all your CSS for you.'),
('Partition Partitioner','11.11','partitioner', 'Manages partitions on your hard drive.'),
('Texty','0.00','texty', 'A free and open source text editor.'),
('iText','199.00','itext', 'An overpriced and closed source text editor.'),
('Elephantine application','33.33','elephantine', 'Makes everything on your screen really big.');
