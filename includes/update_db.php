<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	require "config1_m.php";
	$query = "UPDATE comp_log SET checked=IF(checked, 0, 1), user_checked=(SELECT first_name FROM users WHERE cap_id='" . $_SESSION['capid'] . "'), time_checked=CURRENT_TIMESTAMP WHERE id=" . $_POST['id'] . " AND os='" . $_POST["os"] . "'";
	$conn1->query($query);
	$conn1->close();
}
?>