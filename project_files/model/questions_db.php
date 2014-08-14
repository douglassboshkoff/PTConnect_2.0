<?php
function get_question($userID, $collegeID, $questionID) {
    global $db;
    $query = "SELECT response FROM questions
	      WHERE accounts_id = '$userID' AND queries_id = '$questionID' AND university_id = '$collegeID'";
    $response = $db->query($query)->fetch()['response'];
    return $response;
}

function get_questions($universityID, $accountID) {
    global $db;
    $query = "SELECT * FROM questions
	      WHERE accounts_id = '$accountID' AND university_id = '$universityID' ORDER BY queries_id";
    $response = $db->query($query)->fetchAll();
    return $response;
}


function add_question($response, $university_id, $accounts_id, $query_id) {
    global $db;
    $query = "INSERT INTO questions (response, university_id, accounts_id, queries_id) VALUES ('$response','$university_id','$accounts_id', '$query_id')";
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
