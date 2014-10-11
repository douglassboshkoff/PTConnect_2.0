<?php
include_once "../model/database.php";
include_once "../model/accounts_db.php";
//Setting up session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//setting up validation
require_once('../validate/fields.php');
require_once('../validate/validate.php');
$validate = new Register\Validate();
$fields = $validate->getFields();
$fields->addField('first_name','First Name');
$fields->addField('last_name','Last Name');
$fields->addField('email','Email Address');
$fields->addField('password','Password');
$fields->addField('verify_password','Confirm Password');

//creating variables
$default_image = "../resources/default_picture.png";
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'homepage';
}


if($action == 'login')
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(validate_password($email, $password) === true){
        $temp = get_id_by_email($email);
        $_SESSION['id'] = $temp['id'];
        $_SESSION['link'] = get_image($_SESSION['id'])[0];
        include('main.php');
    }
    else {
        $error=true;
        include('homepage.php');
    }
}
else if($action == 'register')
{
    //copying to local variables.
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $verify_password = $_POST['verifypassword'];
    $grad_year = $_POST['grad_year'];

    //validating form data
    $validate->email('email',$email);
    $validate->text('first_name',$first_name);
    $validate->text('last_name',$last_name);
    $validate->text('password',$password);
    $validate->verify('verify_password',$password,$verify_password);

    if(!$fields->hasErrors())
    {
        add_user($first_name, $last_name, $email, $grad_year, $password,$default_image);
        $temp = get_id_by_email($email);
        $_SESSION['account_id'] = $temp['id'];
        $_SESSION['link'] = get_image($_SESSION['id'])[0];
        include('main.php');
    }
    else
    {
        include('homepage.php');
    }
}
else if($action == 'continue_as_guest')
{
    unset($_SESSION['account_id']);
    include('main.php');

}
else if($action === 'homepage')
{
    session_destroy();
    include('homepage.php');
}

?>