--Use create database statement

--CREATE DATABASE IF NOT EXISTS Notes;          --==> a query to create a database with the name Notes


--To store the data in a table you you create another query by using a CREATE TABLE statement.

CREATE TABLE IF NOT EXISTS note (            --==> a query to create a table 
    id   Int(6)  NOT NULL UNIQUE,
    author    varchar(255) NOT NULL,
    title     varchar(64) NOT NULL,
    note      varchar(255),
    PRIMARY KEY (autho, title)
);
