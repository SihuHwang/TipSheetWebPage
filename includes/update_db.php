<?php
//Called by windows10.php, windowServer.php and Ubuntu.php
//Controls keeping checklist items up to date
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	require "config1_m.php";
	$query = "UPDATE comp_log SET checked=IF(checked, 0, 1), user_checked=(SELECT first_name FROM users WHERE cap_id='" . $_SESSION['capid'] . "'), time_checked=CURRENT_TIMESTAMP WHERE id=" . $_POST['id'] . " AND os='" . $_POST["os"] . "'";
	$conn1->query($query);
	$conn1->close();
}

//Called by windows10.php, windowServer.php and Ubuntu.php
//Controls Adding new checklist item
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item = $_POST['item'];
    if (isset($_POST['item'])) {
    	require "config1_m.php";
    	$os = $_POST['os'];
		$query1 = "INSERT INTO comp_log (round_id, team_id, os, item) VALUES ((SELECT round_id FROM rounds WHERE team_id=(SELECT team_id FROM users WHERE cap_id='". $_SESSION['capid'] . "')), (SELECT team_id FROM users WHERE cap_id='". $_SESSION['capid'] . "'), '". $os . "', '" . mysqli_real_escape_string($conn1, $item) . "')";
		$conn1->query($query1);
		echo $query1;
    }
}
?>