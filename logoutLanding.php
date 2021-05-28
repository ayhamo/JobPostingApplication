<?php
//this page is made to prevent session destroying if page is refreshed, and only opened when logout button is clicked
session_start();

session_destroy();

header("location: login.php");
exit;

