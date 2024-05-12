<?php
$con = new mysqli('localhost', 'root', '', 'gym');

if (!$con) {
    die(mysqli_error($con));
}

?>