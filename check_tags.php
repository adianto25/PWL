<?php
$mysqli = new mysqli("localhost", "root", "", "db_kuliner");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$result = $mysqli->query("SELECT * FROM tags");
while($row = $result->fetch_assoc()) {
    print_r($row);
}
$mysqli->close();
