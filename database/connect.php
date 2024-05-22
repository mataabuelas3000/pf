<?php
$con = new mysqli('localhost', 'root', '1234', 'gym');

if (!$con) {
    die(mysqli_error($con));
}

?>