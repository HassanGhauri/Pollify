<?php

// Params to connect to a database
$dbHost="localhost";
$dbUser="hassan";
$dbPass="bscs";
$dbName="Pollify";

//Connection to database
$conn = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName) or die("Database connection failed :(");


