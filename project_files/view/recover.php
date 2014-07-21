<?php
    include('../model/accounts_db.php');
    include('../model/database.php');
?>

<html>
<body>
    <h1>Recover Password</h1>
    <?php
    if(!isset($_POST["submit"])) {
    ?>
        <form method="post" action="recover.php"> <br>
            <input type="text" name="email"> <br>
            <input type="submit" name="submit" value="Submit">
        </form>

    <?php
    }

    else {
         if(isset($_POST["submit"])) {
             $email = $_POST["email"];
             $password = get_password_by_email($email);
             mail($email,"Password Recovered", $password);
             echo("Password Has Been Sent To Your Email!");
         }
    }
    ?>

</body>
</html>

