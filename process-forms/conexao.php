<?php

// dados da conexão
$host = "localhost";
$dbname = "blessed_db";
$username = "root";
$password = "";

// estabelecendo conexão
$conn = mysqli_connect($host, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    // Pare o script se houver erro de conexão
    echo "Erro na conexão.";
    die(mysqli_connect_error());
}