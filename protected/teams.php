<?php

if(isset($_GET['export'])){
  $query = "SELECT first_name, last_name, cap_id FROM sq_members WHERE FQSN=" . $_SESSION['FQSN'];
  include "../includes/export.php";
}

require "../includes/header.php";
require "../includes/config1_m.php";


if(isset($_GET['addmember'])) {
  header("Location: ../includes/addmember.php");
}


function submit() {
  if($_POST['sent'] == "Firstname:") {
    $firstname = $_POST['input'];
    if (preg_match('/[^A-Za-z]/', $firstname)) {
      echo "<p style='color: red'>Names don't have numbers in them - try again<p>";
    }
    else {
      $data = "first_name LIKE '" . $_POST['input'] . "%'";
      queryit($data);
    }
  }
  if($_POST['sent'] == "Lastname:") {
    $lastname = $_POST['input'];
    if (preg_match('/[^A-Za-z]/', $lastname)) {
      echo "<p style='color: red'>Names don't have numbers in them - try again<p>";
    }
    else {
      $data = "last_name LIKE '" . $_POST['input'] . "%'";
      queryit($data);
    }
  }
  if($_POST['sent'] == "CAP ID:") {
    $capid = $_POST['input'];
    if(!is_numeric($capid)) {
      echo "<p style='color: red'>Invalid Cap ID<p>";
    }
    else {
      $data = "cap_id LIKE '" . $_POST['input'] . "%'";
      queryit($data);
    }
  }
  if($_POST['sent'] == "Privlage Level:") {
    $priv = $_POST['input'];
    if(!is_numeric($priv)) {
      echo "<p style='color: red'>Invalid Privlage Level<p>";
    }
    else {
      $data = "privlage_level=" . $_POST['input'];
      queryit($data);
    }
  }
}

function queryit($data) {
  require "../includes/config_m.php";
  $query = "SELECT * FROM sq_members WHERE " . $data . " && FQSN='" . $_SESSION['FQSN']. "'";
  $result = $conn->query($query);

  echo '<div class="sqsearch">
    <br>
    <table>
      <colgroup>
        <col span="3" style="background-color:lightgrey">
        <col style="background-color:red">
      </colgroup>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>CAPID</th>
        <th>Priv</th>
      </tr>';

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>" . $row["first_name"] . "</td>
        <td>" . $row["last_name"] . "</td>
        <td>" . $row["cap_id"] . "</td>
        <td>" . $row["privlage_level"] . "</td>
        </tr>";
        $rm_capid = $row["cap_id"];
    }
  }
  else {
    echo "<h4 style='color: darkyellow'>No Reults found</h4>";
    $conn->close();
  }
  echo "</table></div></div>";
}

if(isset($_POST['sent'])) {submit();}


require "../includes/config1_m.php";
$query = "SELECT * FROM teams";
$result = $conn1->query($query);
?>

<script src="../libs/tabulator/jquery-3.2.1.js"></script>
<script src="../libs/tabulator/jquery-ui.js"></script>
<link href="../libs/tabulator/tabulator.min.css" rel="stylesheet"></script>
<script src="../libs/tabulator/tabulator.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CyberHub Teams</title>
  </head>
  <body>
    <br>
    <div class="row">
      <div class="leftside">
        <div class="sqmenubar">
          <ul>
            <li><a href="../includes/addteam.php">Create Team</a><li>
            <li><a href="../includes/addmember.php">Add Member</a><li>
            <li><a href="../includes/update.php">Update Team</a></li>
            <li><a href="?retire">Retire Team</a><li>
          </ul>
        </div>
      </div>
      <div class="middle">
      <table id="teams">
        <tr>
         <th>Team Name</th>
            <th>Team ID</th>
            <th>Division</th>
            <th>Unique-ID</th>
            <th>Members</th>
          </tr>
        <?php
          require "../includes/config1_m.php";
          $query = "SELECT * FROM teams WHERE status='ACTIVE'";
          $result = $conn1->query($query);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>". $row['team_name'] . "</td>";
              echo "<td>" . $row['team_id'] . "</td>";
              echo "<td>" . $row['division'] . "</td>";
              echo "<td>" . $row['unique_id'] . "</td>";

              $query = "SELECT * FROM users WHERE team_id='" . $row['team_id'] . "'";
              $result1 = $conn1->query($query);
              $members = "";
              while($row1 = $result1->fetch_assoc()) { 
                $members = $row1['first_name'] . ", " . $members;
              }
              echo "<td>$members</td>";
            }
          }
          $conn1->close();
        ?>
        </tr>
      </table>
    </div>
  </body>
</html>
