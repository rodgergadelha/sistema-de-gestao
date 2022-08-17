<?php

include_once "conexao.php";

// Dados do cliente físico
$nome = $_POST["nome-cliente"];
$cpf = $_POST["cpf-cliente"];
$nascimento = $_POST["nascimento-cliente"];
$genero = $_POST["genero-cliente"];
$categoria = $_POST["categoria-pessoa"];
$telefone = $_POST["telefone-cliente"];
$email = filter_input(INPUT_POST, "email-cliente", FILTER_VALIDATE_EMAIL);
$obs = $_POST["observacoes"];


// Criando comando sql que insere dados do cliente na tabela cliente;
$sql = "INSERT INTO cliente (categoria, nome, cpf, nascimento, genero, telefone, email, obs, nome_fantasia)
        VALUES ('$categoria', '$nome', '$cpf', '$nascimento', '$genero', '$telefone', '$email', '$obs', '')";

// Fazendo query do comando sql
if(mysqli_query($conn, $sql)) {
    echo "<h2>Dados salvos!</h2>";
}else {
    echo "<h2>Erro.</h2>";
}