<!DOCTYPE html>
<?php
include "../model/database.php";
include "../model/accounts_db.php";
include "../model/university_db.php";
include "../model/concentration_db.php";
include "../model/comments_db.php";
include "../model/queries_db.php";
/*
 * Every time I open this file the sadder I get.
 * I cry every time.
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$majors = get_majors();
$minors = get_minors();
$queries = get_queries();

if(isset($_POST['action']))
{
    $action = $_POST['action'];
}
else
{
    $action='display';
}


    $sp_minor1 = "none";
    $sp_minor2 = "none";
    $sp_major2 = "none";


if($action === 'display')
{
        $colleges = get_college_by_user($_SESSION['id']);
}
else if($action === 'edit')
{

}
else if($action === 'populate_edit')
{
    $university_id = $_POST['university_id'];
    $sp_college = get_specific_college($university_id)->fetch();
    $sp_major =  get_sp_major($university_id, $_SESSION['id']);
    $sp_minor = get_sp_minor($university_id, $_SESSION['id']);
    $questions = get_questions($university_id, $_SESSION['id']);
    foreach($questions as $question)
    {
        echo $question;
    }
    if(count($sp_major) == 2)
    {
        $sp_major1 = $sp_major[0];
        $sp_major2 = $sp_major[1];
    }
    else {
        $sp_major1 = $sp_major[0];
        $sp_major2 = "none";
    }

    if(count($sp_minor) == 2)
    {
        $sp_minor1 = $sp_minor[0];
        $sp_minor2 = $sp_minor[1];
    }
    else if(count($sp_minor) == 1){
        $sp_minor1 = $sp_minor[0];
    }
    $colleges = get_college_by_user($_SESSION['id']);
}
else if($action === 'add')
{
    $accounts_id = $_SESSION['id'];
    $sp_college_id = $_POST['college_choice'];
    $major1 = $_POST['major1'];
    $major2 = $_POST['major2'];
    $minor1 = $_POST['minor1'];
    $minor2 = $_POST['minor2'];
    if($major1 == 1)
    {

        add_concentration($_POST['majorothertextbox'], 0, $_SESSION['id'],$sp_college_id);
    }
    if($_POST['major2'] != 'none')
    {
        if($_POST['major2'] == 1)
        {
            add_concentration($_POST['major2'],0,$_SESSION['id'],$sp_college_id);
        }
        else
        {
            add_concentration($_POST['major2'],0,$_SESSION['id'],$sp_college_id);
        }
    }
    if($_POST['minor1'] != 'none')
    {
        add_concentration($_POST['minor1'],1,$_SESSION['id'],$sp_college_id);
    }
    if($_POST['minor2'] != 'none')
    {
        add_concentration($_POST['minor2'],1,$_SESSION['id'],$sp_college_id);
    }
    add_question($_POST['question1'],$sp_college_id,$_SESSION['id'],1);
    add_question($_POST['question2'],$sp_college_id,$_SESSION['id'],2);
    add_question($_POST['question3'],$sp_college_id,$_SESSION['id'],3);
    add_question($_POST['question3'],$sp_college_id,$_SESSION['id'],4);
    add_question($_POST['question3'],$sp_college_id,$_SESSION['id'],5);

    $action='display';
    $colleges = get_college_by_user($_SESSION['id']);

}
else if($action === 'delete')
{
    $college_id = $_POST['university_id'];
    delete_question_by_account($_SESSION['id'], $college_id);
    remove_concentration_by_user_and_university($_SESSION['id'],$college_id);
    $colleges = get_college_by_user($_SESSION['id']);
    $action = 'display';
}
include "header.php";
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css" />
        <script type="text/javascript" src="../js/jQuery.js"></script>
        <script type="text/javascript" src="../js/dropdown_text.js"></script>
        <style>

          .dropdown2{
              width:240px;
          }
            #majordiv1, #majordiv2, #minordiv1, #minordiv2 {
                display:inline-block;
                margin-left: 77px;

            }
            #majordiv1 input, #majordiv2 input, #minordiv1 input, #minordiv2 input {
                width: 178px;
                font-family: "HelveticaNeue-Thin", "Helvetica Neue Thin", "Helvetica Neue", Helvetica, sans-serif;
                font-size: 16px;
            }
            .othertextbox{
                margin-left: 77px;
                width: 235px;
            }
            </style>
	</head>
	<body>
	<div id="wrapper1">
    	<div id='wrapper2'>
		<div id='table'>
			<table>
                <?php foreach($colleges as $college) { ?>
                    <tr>
                        <td><h1><?php echo $college['name']; ?></h1></td>
                        <td>
                            <form action="myColleges.php" method="post">
                                <input type="hidden" value="populate_edit" name="action"/>
                                <input type="hidden" value="<?php echo $college['id'] ?>" name="university_id"/>
                                <input id="submitLink" type="submit" value="edit" name="submit"/>
                                <input type="hidden" value="college" name="page"/>
                            </form>
                        </td>
                        <td>
                            <form action="myColleges.php" method="post">
                                <input id="submitLink" type="submit" value="delete" name="submit"/>
                                <input type="hidden" value="<?php echo $college['id'] ?>" name="university_id"/>
                                <input type="hidden" value="delete" name="action"/>
                                <input type="hidden" value="college" name="page"/>
                            </form>
                            
                    </tr>
                <?php  } unset($college) ?>
			</table>
		</div>
		<div id="add">
			<h1><?php if($action==='display') { echo "Add College";} else { echo "Edit College";} ?></h1>
			<form method="post" action="myColleges.php">
				<label>School</label>
                <?php if($action === 'populate_edit') { ?>
                    <input type="text" name="college" value="<?php echo  $sp_college['name']?>" style="margin-left:7px; width: 230px; font-family: 'HelveticaNeue-Thin', 'Helvetica Neue Thin', 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; padding: 2px 0 2px 8px;"/>
                <?php }else{ ?>
				<select class="dropdown2" id="college2" name ="college_choice">
                    <?php $colleges = get_colleges(); ?>
                        <?php  foreach($colleges as $college1) { ?>
                            <option value="<?php echo $college1['id'] ?>"><?php echo $college1['name'] ?></option>
                    <?php } ?>

                    <option value = "1" class = ".textexp"> Other </option>

                </select>
                <?php } ?>
                <div id = "hiddendiv">   <label><input type="text" class="othertextbox" /></label>  </div>
                <div id = "hiddendiv2">  <label><input type="text" class="othertextbox" /></label> </div>
                <div id = "hiddendiv3">  <label><input type="text" class="othertextbox" /></label>  </div>
                <div id = "hiddendiv4">  <label><input type="text" class="othertextbox" /></label>  </div>
				<br>
				<label style="margin-right: 2px;">Major 1</label>

				<select class="dropdown2" name="major1" id = "major1" style= "width:180px">
                    <?php for($i = 0; $i < count($majors); $i++) { ?>
                        <?php if($action === 'populate_edit') { ?>
                            <option <?php if($sp_major1 == $majors[$i] ) { ?> selected <?php } ?>><?php echo $majors[$i] ?></option>
                        <?php }else { ?> <option><?php echo $majors[$i] ?> <?php } ?></option>
                    <?php } ?>
                    <option value = "1" class = ".textexp"> Other </option>
                </select>


				<label style="margin-left: 2px;">Major 2</label>

				<select class="dropdown2" name="major2" id = "major2" style= "width:180px">
                    <?php for($i = 0; $i < count($majors); $i++) { ?>
                        <?php if($action === 'populate_edit') { ?>
                            <option <?php if($sp_major2 == $majors[$i] ) { ?> selected <?php } ?>><?php echo $majors[$i] ?></option>
                        <?php }else { ?> <option><?php echo $majors[$i] ?> <?php } ?></option>
                    <?php } ?>
                    <option <?php if($sp_major2 === "none") { ?>  selected <?php } ?>>none</option> ?>
                    <option value = "1" class = ".textexp" name="major2_other" style= "width:180px"> Other </option>
                </select>
                <div id = "majordiv1" >  <input type="text" id="majorothertextbox" />  </div>
                <div id = "majordiv2">  <input type="text" id="majorothertextbox2" />  </div>
				<br>

				<label style="margin-right: 1px;">Minor 1</label>

				<select class="dropdown2" name="minor1" id = "minor1" style= "width:180px">
                    <?php for($i = 0; $i < count($minors); $i++) { ?>
                        <?php if($action === 'populate_edit') { ?>
                            <option <?php if($sp_minor1 == $minors[$i] ) { ?> selected <?php } ?>><?php echo $minors[$i] ?></option>
                        <?php }else { ?> <option><?php echo $minors[$i] ?> <?php } ?></option>
                    <?php } ?>
                    <option <?php if($sp_minor1 === "none") { ?>  selected <?php } ?>>none</option> ?>
                    <option value = "1" class = ".textexp" name="minor1_other"> Other </option>
                </select>


                <label style="margin-left: 2px;">Minor 2</label>

				<select class="dropdown2" name="minor2" id = "minor2" style= "width:180px">
                    <?php for($i = 0; $i < count($minors); $i++) { ?>
                        <?php if($action === 'populate_edit') { ?>
                            <option <?php if($sp_minor2 === $minors[$i] ) { ?> selected <?php } ?>><?php echo $minors[$i] ?></option>
                        <?php }else { ?> <option><?php echo $minors[$i] ?> <?php } ?></option>
                    <?php } ?>
                    <option <?php if($sp_minor2 === "none") { ?>  selected <?php } ?>>none</option> ?>
                    <option value = "1" class = ".textexp" name="minor2_other"> Other </option>
                </select>
                <div id = "minordiv2">  <input type="text" id="minorothertextbox2" />  </div>
                <div id = "minordiv1">  <input type="text" id="minorothertextbox" />  </div>

                <?php foreach($queries as $query) { ?>
                    <h2><?php echo $query['question']; ?></h2>
				    <textarea class="questions" rows="4" name="question<?php echo $query['id']; ?>"><?php if($action === 'populate_edit') { echo $questions[$query['id'] - 1]; }?></textarea>
				<?php } ?>
                <input type="hidden" name="action" value="<?php
                if($action === 'display')
                {
                    echo 'add';
                }
                else{
                    echo 'edit';
                } ?>"/>
				<input type="submit" id="addButton" value="submit">
                <?php if($action==='populate_edit') { ?>
                    <input type="hidden" name="college_id" value="<?php echo $sp_college['id'] ?>"/>
                <?php } ?>
			</form>
		</div>
		</div>
		</div>

	</body>	<?php  include "footer.php" ?>
</html>

