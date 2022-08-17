<?php

include_once "conexao.php";

// Dados do cliente jurídico
$razao_social = $_POST["razao-social"];
$cnpj = $_POST["cnpj"];
$nome_fantasia = $_POST["nome-fantasia"];
$categoria = $_POST["categoria-pessoa"];
$telefone = $_POST["telefone-cliente"];
$email = filter_input(INPUT_POST, "email-cliente", FILTER_VALIDATE_EMAIL);
$obs = $_POST["observacoes"];

// Criando comando sql que insere dados do cliente na tabela cliente;
$sql = "INSERT INTO cliente (categoria, nome, cpf, nascimento, genero, telefone, email, obs, nome_fantasia)
VALUES ('$categoria', '$razao_social', '$cnpj', '', '', '$telefone', '$email', '$obs', '$nome_fantasia')";

// Fazendo query do comando sql
if(mysqli_query($conn, $sql)) {
    echo "<h2>Dados salvos!</h2>";
}else {
    echo "<h2>Erro.</h2>";
}