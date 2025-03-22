<?php
$dbhost = ("localhost");
$dbuser = ("root");
$dbpass = ("");
$dbname = ("sgs");


if (!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)){

die("connexion echoué");

}