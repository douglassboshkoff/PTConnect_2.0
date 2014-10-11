
<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<body>
<div id="wrapper1">
    <div id='wrapper2'>
    <div id='top'>
        <ul>
            <li><span id="white">PT</span><span id="red">Connect</span></li>
            <form id="login" method="post" action="index.php">
                <input type="hidden" name="action" value="login"/>
                <input type="text" name="email" placeholder="Email" />
                <input type="password" name="password" placeholder="Password" />
                <input id="loginButton" type="submit" value="Login"/>
            </form>
        </ul>
    </div>
    <div id="guestSide">
        <h1>Just Visiting?</h1>
    </div>
    <div id="ptcsSide">
        <h1>Past or Current PTCS Student?</h1>
    </div>
    <div id="guestLogin">
        <p>Learn more about PTCS alumni, the colleges they have attended, and their current and past employers.  </p>
        <form method="get" action="index.php">
            <input type="hidden" value="continue_as_guest" name="action"/>
            <input class="button" type="submit" value="Continue as Guest" />
        </form>
    </div>
    <div id="ptcsCreate">
        <form method="post" action="index.php">
            <input name="action" type="hidden" value="register"/>
            <?php
            //find errors
            $first_name_error =  $fields->getField('first_name')->hasError();
            $last_name_error = $fields->getField('last_name')->hasError();
            $email_error = $fields->getField('email')->hasError();
            $password_error = $fields->getField('password')->hasError();
            $verify_password_error = $fields->getField('verify_password')->hasError();
            //The purpose of the below code is to process for errors. Many of the form values are conditional upon whether errors have occured.
            ?>
            <input id="fname" name="first_name" type="text" style="<?php if($first_name_error){?> color:red; <?php }?>" placeholder="First Name" value="<?php if($first_name_error){ echo $fields->getField('first_name')->getText(); } else if(isset($first_name)){ echo htmlspecialchars($first_name); }?>"/>
            <input id="lname" name="last_name" type="text" style="<?php if($last_name_error){ ?> color:red <?php }?>" placeholder="Last Name" value="<?php if($last_name_error){ echo $fields->getField('last_name')->getText();} else if(isset($last_name)){ echo htmlspecialchars($last_name); }?>"/>
            <input id="email" name="email" type="text" style="<?php if($email_error) {?> color:red <?php }?>" placeholder="Email" value="<?php if($email_error){echo $fields->getField('email')->getText();} else if(isset($email)){ echo htmlspecialchars($email); }?>"/>
            <input id="password" name="password" type="text" style="<?php if($password_error){?> color:red <?php } ?>" placeholder="Password" value="<?php if($password_error) { echo $fields->getField('password')->getText(); } else if(isset($password)){ echo htmlspecialchars($password); }?>"/>
            <input id="password" name="verifypassword" type="text" style="<?php if($verify_password_error){ ?> color:red <?php } ?>" placeholder="Confirm Password" value="<?php if($verify_password_error){ echo $fields->getField('verify_password')->getText();} else if(isset($verify_password)) { echo htmlspecialchars($verify_password); }?>"/>
            <select id="gradyear" name="grad_year">
                <option value="">- PT Grad Year -</option>
                <option>2017</option>
                <option>2016</option>
                <option>2015</option>
                <option>2014</option>
                <option>2013</option>
                <option>2012</option>
                <option>2011</option>
                <option>2010</option>
                <option>2010</option>
                <option>2010</option>
                <option>2009</option>
                <option>2008</option>
                <option>2007</option>
                <option>2006</option>
                <option>2005</option>
                <option>2004</option>
            </select>
            <input class="button" id="create" type="submit" value="Create" />
            <form>
    </div>
</div>
</div>
</body>
<?php include "footer.php"; ?>
</html>