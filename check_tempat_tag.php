<?php
$mysqli = new mysqli("localhost", "root", "", "db_kuliner");
$result = $mysqli->query("SELECT * FROM tempat_tag");
while($row = $result->fetch_assoc()) {
    print_r($row);
}
$mysqli->close();
