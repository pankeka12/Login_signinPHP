<?php
/*
before you use this code you need to create a table called users with an serial primary key id, varchar email 
and varchar password

CREATE TABLE users(
    id SERIAL,
    email VARCHAR(64) UNIQUE,
    password VARCHAR(64),
    PRIMARY KEY(id)
);

*/
$db = new PDO('pgsql:host=where you are hosting the database;
port=the port, by default its 5432; 
dbname=database name user=the user od the database password=your database password');

?>
<h1>Log in</h1>
<!-- simple form so the user can put their email and password -->
<form method="POST">
   Email:<input type="text" name="email"></input><br>
   Password:<input type="password" name="password"></input><br>
   <button type="submit">Log in</button><br>
   Create an account:<a href="./sign_up.php">Sign up</a>
</form>

<?php
//if statment that checks if a request has been made to the server
if($_SERVER['REQUEST_METHOD'] === "POST"){
   //remane the html inputs to new variables names
    $email = $_POST['email'];
    $password = $_POST['password'];
   //query to select where the email is equal to the one given by the user as its unique
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $db->query($sql);//applie the query above in the database
   //if statment that checks if the query above works
    if($result){
      /*
       what bind columns basicly does its bind the columns of the table in the database to new variable, 
       insade the single quotes are the name of the columns in the table in the database and as its
       second parameters would be the variable name
      */
       $result->bindColumn('id', $id);//bind column id in the table to a variable named $id
       $result->bindColumn('email', $sqlEmail);//bind column email in the table to a variable named $sqlEmail
       $result->bindColumn('password', $sqlPassword);//bind column password in the table to a variable named $sqlPassword
       $result->fetch(PDO::FETCH_BOUND);//what PDO::FETCH_BOUND do its turn the bind column in an PHP associative array that you can work with

       //checks if the password given by the user is the same as in the column where the email is
       if($sqlPassword === $password){
           echo "You are in";
       }else{
           echo "Email or password incorrect";
       }
    }
}

?>