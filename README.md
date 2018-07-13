# Basic_Employee_Database_CRUD
A simple php application to view, create, edit and delete entries to a DB table.

Usage:
>The files are to be placed in a php enabled host or localserver.
>Have added the sample DB, for reference.

>To create a DB run the following SQL.

/*This created the DB*/
CREATE DATABASE crud;

/*This creates the table*/
CREATE TABLE employees (
id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100),
    address VARCHAR(255),
    salary VARCHAR(100),
    gender VARCHAR(100),
    designation VARCHAR(100),
    PRIMARY KEY(id)
);


