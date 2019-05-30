<?php

/*
 * This file provides examples to frequently used PHP and PDO operations which can be direcly 
 * used when developing and designing at higher level. 
 */

/* echo can print a string, the value of a variable, and even html code. */
echo "Hello World";

/* print_r is commonly used in development and debugging.
 * print_r can print out the value of a variable in a very nice way.
 */
$a = array ('a' => 'apple', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
print_r ($a);

/* Three commonly used arrays: $_GET, $_SET, $_COOKIE and some operations
 * isset() checks whether a field of a form is setted.
 * setcookie() sets the cookie
 */
isset($_GET['cancel']);
// name is the name of the cookie. value is the value (not necessarily String) of the cookie. // time() + 3600 sets the expiration time of the cookie. 
// time() gets the current time, and 3600 is measured in second. 
setcookie("name", "value", time() + 3600);

// this expression lead to another website indicated after Location:.
header("Location: index.html");

// This expression encode the provided string into url and returns the encoded string.
urlencode("String");


/* PDO Construction 
 * The PDO constructor function can be used in the following way.
 * mysql: the type of database, can be replaced by other sqls.
 * localhost: the host for your database, can be replaced by other host.
 * dbname: the name of the database you want to use on the host.
 * dbusername: the username for you to access the database.
 * dbpassword: the password for you to access the database.
 * NOTE: if you don't know your dbusername and dbpassword, create it in your database using
 * "GRANT ALL ON dbname.* TO 'dbusername'@'your IP Address' IDENTIFIED BY 'dbpassword'".
 * if you don't have privilege to create user for the database, ask your boss for a username 
 * and password.
 */
$myPDO = new PDO('mysql:localhost; dbname=myDataBase','dbusername','dbpassword');

// These variables are designed for the purpose of illustration of the syntax of the queries.
$sample1 = "sample1";
$sample2 = 2;

/* 
 * This is the simplist way to do query by using PDO.
 * However, this way may have security issues like SQL Injection, therefore being unrecommended.
 */
// This statement queries the provided SQL to the database the PDO is connecting to.
// the query result is stored in $stmt, which cannot be directly used.
$stmt = $pdo->query("SELECT * FROM users WHERE username = '$sample1'"); 

/* This is a better way to do query by using PDO.
 * This way avoids all the security issues, and therefore being the iconic feature of PDO.
 */
// This set of statements queries the provided SQL to the database the PDO is connecting to.
// the query result is stored in $stmt, which cannot be directly used.
$sql = "SELECT * FROM users WHERE username = '$sample1'";
$stmt = $pdo->prepare($sql);
$stmt->execute();

/* This while loop fetches the tuples in the query result one by one and stores the fetched 
 * one tuple in $var.
 */
// PDO::FETCH_ASSOC determines the type of fetched result, can be changed to other modes.
// If the query result has nothing in it, $var = false;
while ($var = $stmt->fetch(PDO::FETCH_ASSOC)) {
	// do something with $var.
} 

/* To insert a tuple to the database, we can use either way. 
 * Deletion is in a similar way
 */
// The way without place holder:
$sql = "INSERT INTO users (name, age) VALUES ('$sample1', '$sample2')";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// The way with place holder:
$sql = "INSERT INTO users (name, age) VALUES (:name, :age)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
	':name' => $sample1,
	':age'  => $sample2));


?>