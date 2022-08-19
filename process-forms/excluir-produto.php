<?php

include_once "conexao.php";

$sql = "";

if(count($_POST) > 0) {
    $id_array = $_POST["checkbox"];

    foreach($id_array as $id) {
        $sql .= "DELETE FROM produto WHERE id = $id;";
    }   
}

// Salvando dados
if(mysqli_multi_query($conn, $sql)) {
    echo "<h2>Dados salvos!</h2>";
}