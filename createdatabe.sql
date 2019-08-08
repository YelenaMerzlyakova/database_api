--Use create database statement

CREATE DATABASE IF NOT EXISTS Notes;          --==> a query to create a database with the name Notes


--To store the data in a table you you create another query by using a CREATE TABLE statement.

CREATE TABLE IF NOT EXISTS Notes (            --==> a query to create a table 
    NotesID   Int(6)  NOT NULL UNIQUE,
    NotesAuthor    varchar(230) NOT NULL,
    NotesTitle     varchar(230) NOT NULL,
    NotesBody      varchar(230),
    PRIMARY KEY (title),
)
