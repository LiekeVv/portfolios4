<?php

//    connection voor localhost
//    define('BASE_URL', 'http://localhost:8888/portfolios4/');
//
//    $servername = "localhost";
//    $username = "root";
//    $password = "root";
//
//    $db = new PDO("mysql:host=$servername;dbname=portfolio-semester4", $username, $password);


//    connection voor de hera server
    define('BASE_URL', 'http://i392267.hera.fhict.nl/portfolios4/');

    $servername = "studmysql01.fhict.local";
    $username = "dbi392267";
    $password = "Lieke";

    $db = new PDO("mysql:host=$servername;dbname=dbi392267", $username, $password);

	//Dit zorgt ervoor dat er geen script uitgevoerd kan worden. De speciale tekens worden omgezet naar tekst.
	function e($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

?>