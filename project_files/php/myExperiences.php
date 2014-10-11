<!DOCTYPE html>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../model/comments_db.php');
include "../model/accounts_db.php";
include('../model/experiences_db.php');
include('../model/database.php');
include('../model/university_db.php');
include('../model/concentration_db.php');

$account_id = $_SESSION['acocunt_id'];

if(isset($_POST['action']))
{
    $action = $_POST['action'];
}
else
{
    $action='display';
}
    $type= get_types();
    $titles = get_all_titles();

if($action==='display')
{
    $experiences = get_experiences_by_account_id($_SESSION['id']);
}
else if($action === 'edit')
{
    $experience_id = $_POST['experience_id'];
    $content = $_POST['content'];
    $type = $_POST['type'];
    if($_POST['title'] === '1')
    {
        $title = $_POST['titletextbox'];
    }else{
    $title = $_POST['title'];
    }
    update_experience($experience_id, $type, $title, $content, $account_id);
    $experiences = get_experiences_by_account_id($account_id);
    $type = get_types();
    $titles = get_all_titles();
    $action = 'display';
}
else if($action === 'populate_edit')
{
    $experience_id = $_POST['experience_id'];
    $sp_experience = get_specific_experience($experience_id)->fetch();
    $experiences = get_experiences_by_account_id($account_id);
}
else if($action === 'add')
{
    $content = $_POST['content'];
    $type = $_POST['type'];
    //if statement checks to see if user has created a different title than others already in the database.
    if($_POST['title'] === '1')
    {
        $title = $_POST['titletextbox'];
    }else{
        $title = $_POST['title'];
    }
    add_experience($type, $title, $content, $account_id);
    $experiences = get_experiences_by_account_id($account_id);
    $type = get_types();
    $titles = get_all_titles();
    $action = 'display';
}
else if($action === 'delete')
{
    $experience_id = $_POST['experience_id'];
    delete_experience($experience_id);
    $experiences = get_experiences_by_account_id(1);
    $action = 'display';
}
include("header.php");
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css" />
        <script type="text/javascript" src="../js/jQuery.js"></script>
        <script type="text/javascript" src="../js/dropdown_text_exp.js"></script>
        <style>
            form input[type="submit"]{

                background: none;
                border: none;
                color: black;
                text-decoration: underline;
                cursor: pointer;
                font-size: 16px;
            }
            .dropdown2{
                width: 200px;
                margin-right:4px;
            }
            #titlediv input {
	            margin-left: 58px;
	            width: 316px;
                font-family: "HelveticaNeue-Thin", "Helvetica Neue Thin", "Helvetica Neue", Helvetica, sans-serif;
                font-size: 16px;

            }


        </style>
	</head>
	<body>
	<div id="wrapper1">
    	<div id='wrapper2'>
		<div id='table'>
			<table>
                <?php  foreach($experiences as $experience) { ?>
                    <tr>
                        <td><h1><?php echo $experience['title']; ?></h1></td>

                        <td>
                            <form action="myExperiences.php" method="post">
                                <input type="hidden" value="populate_edit" name="action" />
                                <input type="hidden" value="<?php echo $experience['id'] ?>" name="experience_id"/>
                                <input type="submit" value="edit" name="submit"/>
                                <input type="hidden" value="experience" name="page"/>
                            </form>
                        </td>
                        <td>
                            <form action="myExperiences.php" method="post">
                                <input type="submit" value="delete" name="submit" />
                                <input type="hidden" value="<?php echo $experience['id'] ?>" name="experience_id"/>
                                <input type="hidden" value="delete" name="action"/>
                                <input type="hidden" value="experience" name="page"/>
                            </form>

                    </tr>
                <?php  } ?>
			</table>
		</div>
		<div id="add">
            <h1><?php if($action==='display') { echo "Add Experience";} else { echo "Edit Experience";} ?></h1>

            <form method="post" action="myExperiences.php">

                <label>Type</label>

                <select class="dropdown2" id = "typeselect" name="type" style="width:320px">
                    <?php for($i = 0; $i < count($type); $i++) { ?>
                        <?php if($action === 'populate_edit') { ?>

                            <option <?php if($sp_experience['type'] === $type[$i] ) { ?> selected <?php } ?>><?php echo $type[$i] ?></option>

                        <?php }else { ?> <option><?php echo $type[$i] ?> <?php } ?></option>
                    <?php } ?>
                    <option>Other</option>
                </select>

                <br/>
                <label style="margin-right: 5px;">Title</label>

                <select class="dropdown2" id = "titleselect" name="title" style="width:320px">
                    <?php for($i = 0; $i < count($titles); $i++) { ?>
                        <?php if($action === 'populate_edit') { ?>

                            <option <?php if($sp_experience['title'] === $titles[$i] ) { ?> selected <?php } ?>><?php echo $titles[$i] ?></option>

                        <?php }else { ?> <option><?php echo $titles[$i] ?> <?php } ?></option>
                    <?php } ?>
                    <option value="1" >Other</option>
                </select>


                <div id = "titlediv">  <input type="text" id="titletextbox" name="titletextbox" />  </div>

                <br/>

                <h2>Describe Your Experience</h2>
                <textarea class="questions" rows="4" name="content" ><?php if($action==='populate_edit') { echo $sp_experience['content']; } ?></textarea>
                <input type="hidden" name="action" value="<?php
                if($action === 'display')
                {
                    echo 'add';
                }
                else{
                    echo 'edit';
                }
                ?>">
                <input type="submit" id="addButton" value="submit" style="text-decoration: none"/>
                <?php if($action==='populate_edit') { ?>
                    <input type="hidden" name="experience_id" value="<?php echo $sp_experience['id'] ?>"/>
                <?php } ?>
            </form>
        </div>
		</div>
		</div>
		</body>
<?php include('footer.php') ?>
</html>
