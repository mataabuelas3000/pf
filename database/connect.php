<?php
$con = new mysqli('localhost', 'root', '2004', 'gym');

if (!$con) {
    die(mysqli_error($con));
}

?>