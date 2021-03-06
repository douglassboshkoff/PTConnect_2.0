<?php
include "../model/accounts_db.php";
include "../model/university_db.php";
include "../model/concentration_db.php";
include "../model/experiences_db.php";
include "../model/database.php";
include "header.php";



$grad_year_array = get_grad_years();
$college_array = get_colleges();
$major_array = danny_get_majors();
$experience_type_array = danny_get_types();
$experience_title_array = danny_get_all_titles();

if(isset($_POST['year'])){
    $yearIn = $_POST['year'];
}
else{
    $yearIn = "";
}
if(isset($_POST['college'])){
    $collegeIn = $_POST['college'];
}
else{
    $collegeIn = "";
}
if(isset($_POST['major'])){
    $majorIn = $_POST['major'];
}
else{
    $majorIn = "";
}
if(isset($_POST['type'])){
    $typeIn = $_POST['type'];
}
else{
    $typeIn = "";
}
if(isset($_POST['title'])){
    $titleIn = $_POST['title'];
}
else{
    $titleIn = "";
}

$newArr = accounts_filter($collegeIn, $yearIn, $majorIn, $typeIn, $titleIn);

$class_array = "";
$name_array = "";
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<style>
    form input[type="submit"]{

        background: none;
        border: none;
        color: black;
        text-decoration: underline;
        cursor: pointer;
        font-size: 16px;
    }
</style>
<body>
<div id="wrapper1">
    <div id='wrapper2'>
<div id="filters">
    <h1>Filters</h1>
    <form action="userSearch.php" method="post">
        <label>PT Grad Year</label></br>
        <select name="year" id="dropdown">
            <?php if($yearIn != "") : ?>
                <option value="<?php echo $yearIn?>"><?php echo $yearIn ?></option>
            <?php endif ; ?>
            <option value="">(No Criteria)</option>
            <?php foreach ($grad_year_array as $year) : ?>
                <?php if($year['pt_grad_year'] != $yearIn) : ?>
                    <option value="<?php echo $year['pt_grad_year'] ?>"><?php echo $year['pt_grad_year'] ?></option>
                <?php endif ; ?>
            <?php endforeach ; ?>
        </select></br>
        <label>College</label></br>
        <select name="college" id="dropdown">
            <?php if($collegeIn != "") : ?>
                <option value="<?php echo $collegeIn?>"><?php echo $collegeIn ?></option>
            <?php endif ; ?>
            <option value="">(No Criteria)</option>
            <?php foreach ($college_array as $college) : ?>
                <?php if($college['name'] != $collegeIn) : ?>
                    <option value="<?php echo $college['name'] ?>"><?php echo $college['name'] ?></option>
                <?php endif ; ?>
            <?php endforeach ; ?>
        </select></br>
        <label>Major</label></br>
        <select name="major" id="dropdown">
            <?php if($majorIn != "") : ?>
                <option value="<?php echo $majorIn?>"><?php echo $majorIn ?></option>
            <?php endif ; ?>
            <option value="">(No Criteria)</option>
            <?php foreach ($major_array as $major) : ?>
                <?php if($major['name'] != $majorIn) : ?>
                    <option value="<?php echo $major['name'] ?>"><?php echo $major['name'] ?></option>
                <?php endif ; ?>
            <?php endforeach ; ?>
        </select></br>
        <label>Experience Type</label></br>
        <select name="type" id="dropdown">
            <?php if($typeIn != "") : ?>
                <option value="<?php echo $typeIn?>"><?php echo $typeIn ?></option>
            <?php endif ; ?>
            <option value="">(No Criteria)</option>
            <?php foreach ($experience_type_array as $type) : ?>
                <?php if($type['type'] != $typeIn) : ?>
                    <option value="<?php echo $type['type'] ?>"><?php echo $type['type'] ?></option>
                <?php endif ; ?>
            <?php endforeach ; ?>
        </select></br>
        <label>Experience Title</label></br>
        <select name="title" id="dropdown">
            <?php if($titleIn != "") : ?>
                <option value="<?php echo $titleIn?>"><?php echo $titleIn ?></option>
            <?php endif ; ?>
            <option value="">(No Criteria)</option>
            <?php foreach ($experience_title_array as $title) : ?>
                <?php if($title['title'] != $titleIn) : ?>
                    <option value="<?php echo $title['title'] ?>"><?php echo $title['title'] ?></option>
                <?php endif ; ?>
            <?php endforeach ; ?>
        </select></br>

        <input class="submit" type="submit" value="Search">
    </form>
</div>


<div id="content">

    <?php foreach($newArr as $name) : ?>

        <div id="user">
            <a href="profile.php"><img src="<?php echo $name['image_link'] ?>"/></a>
            <form action="profile.php" method="post">
                <input type="submit" value="<?php echo $name['first_name']." ".$name['last_name']?>">
                <input type="hidden" name="name" value="<?php echo $name['email']?>">
            </form>

            <h3>PT <?php echo $name['pt_grad_year'] ?></h3>
        </div>
    <?php endforeach; ?>
</div>
</div>
</div>
</body>
<?php include ("footer.php"); ?>
</html>
