<?php
/*
before you use this code you need to create a table called users with an serial primary key id, varchar and a unique email 
and varchar password

CREATE TABLE users(
    id SERIAL,
    email VARCHAR(64) UNIQUE,
    password VARCHAR(64),
    PRIMARY KEY(id)
);

*/
$db = new PDO('pgsql:host=where you are hosting the database;
port=the port by default its 5432; 
dbname=database name user=the user od the database password=your database password');

?>
<h1>Create an account</h1>
<!-- simple form so the user can put their email and password to create an account -->
<form method="POST">
  Your email:<input type="text" name="email"><br>
  Your password:<input type="password" name="password"><br>
  Confirm password:<input type="password" name="password1"><br>
  <button type="submit" value="Submit POST">Create account</button><br>
  Already have one:<a href="./login.php">Log in</a>
</form>
<?php
//if statment to see if some request has been made
if($_SERVER["REQUEST_METHOD"] === "POST"){
  //rename the html input with anothers variable so its easier to work with them
   $email = $_POST['email'];
   $password = $_POST['password'];
   $checkPassword = $_POST['password1'];

  //sanitaze and validate email to see if its an actual email and not something random
   $sanitazedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
   $validatedEmail = filter_var($sanitazedEmail, FILTER_VALIDATE_EMAIL);
    /*
    if statment that checks if the password and the confirm passsword inputs are the same 
    and also checks if ist an valid email
    */
     if($password === $checkPassword && $validatedEmail){
        //query to insert into users table(no need to insert an id as its a serial)
        $sql = "INSERT INTO users(email, password) VALUES('$email', '$password')";

        //if statment that checks if the query above works and applie it to the database
        if($db->query($sql)){
            echo "Account created";
        //just if something didnt work
        }else{
             echo "Try again";
        }
    //if password and confirm password inputs arent the same
     }elseif($password != $checkPassword){
         echo "Passwords aren't the same";
    //if its not a valid email
     }elseif(!$validatedEmail){
         echo "Thats not an valid email";
    //i something else didnt work
     }else{
         echo "something went wrong";
     }
}
?>