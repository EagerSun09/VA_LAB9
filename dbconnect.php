<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$json = file_get_contents('php://input');
$data = json_decode($json);

$servername = "mysql-user.eecs.tufts.edu";
$username = "150vizstudent";
$password = "150vizstudent";
$dbname = "150VIZ";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    $arr = array('error' => $conn->connect_error);
    print json_encode($arr);
    exit;
}

$sql = $data->{'query'};
$result = $conn->query($sql);

if ($result) {
   if ($result->num_rows > 0) {
      $rows = array();

      // output data of each row
      while($r = $result->fetch_assoc()) {
	$rows[] = $r;
      }
      print json_encode($rows);
   } else {
     //if there are 0 rows (or below?) return an empty json
      $rows = array();
      print json_encode($rows);
   }
}
else {
      $arr = array('error' => mysqli_error($conn));
      print json_encode($arr);
}

$conn->close();
?>