<?php
function get_question($userID, $collegeID, $questionID) {
    global $db;
    $query = "SELECT response FROM questions
	      WHERE accounts_id = '$userID' AND queries_id = '$questionID' AND university_id = '$collegeID'";
    $response = $db->query($query)->fetch()['response'];
    return $response;
}

function get_questions($collegeID, $questionID) {
    global $db;
    $query = "SELECT * FROM questions
	      WHERE question_id = '$questionID' AND university_id = '$collegeID'";
    $response = $db->query($query);
    return $response;
}


function add_question($response, $university_id, $accounts_id) {
    global $db;
    $query = "INSERT INTO questions (response, university_id, accounts_id) VALUES ('$response','$university_id','$accounts_id')";
    $db->exec($query);
}

function delete_question($id) {
    global $db;
    $query = "DELETE FROM questions WHERE id = '$id'";
    $db->exec($query);
}

function update_question($id, $new_response) {
    global $db;
    $query = "UPDATE questions SET response = '$new_response' WHERE id = '$id'";
    $db->exec($query);
}
function delete_question_by_account($accounts_id, $university_id) {
    global $db;
    $query = "DELETE FROM questions WHERE accounts_id = '$accounts_id' && university_id = $university_id";
    $db->exec($query);
}

?>
