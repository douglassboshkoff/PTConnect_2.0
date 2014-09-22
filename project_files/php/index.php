<?php
include_once "../model/database.php";
include_once "../model/accounts_db.php";

$error=false;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verifypassword = $_POST['verifypassword'];
    $grad_year = $_POST['grad_year'];

    if($password == $verifypassword && $password != "")
    {
        add_user($first_name, $last_name, $email, $grad_year, $password,"../resources/default_picture.png");
        $temp = get_id_by_email($email);
        $_SESSION['id'] = $temp['id'];
        $_SESSION['link'] = get_image($_SESSION['id'])[0];
        include('main.php');
    }
    else
    {
        echo "This should create error text in the registration box.";
    }
}
else if($action == 'continue_as_guest')
{
    unset($_SESSION['id']);
    include('main.php');

}
else if($action === 'homepage')
{
    session_destroy();
    include('homepage.php');
}

?>