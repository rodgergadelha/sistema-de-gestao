<?php

include_once "conexao.php";

// Dados do cliente jurídico
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$razao_social = $_POST["razao-social"];
$cnpj = $_POST["cnpj"];
$nome_fantasia = $_POST["nome-fantasia"];
$categoria = $_POST["categoria-pessoa"];
$telefone = $_POST["telefone-cliente"];
$email = filter_input(INPUT_POST, "email-cliente", FILTER_VALIDATE_EMAIL);
$obs = $_POST["observacoes"];

// Criando comando sql que insere dados do cliente na tabela cliente;
$sql = "UPDATE cliente
SET categoria = '$categoria', nome = '$razao_social', cpf = '$cnpj',
nascimento = '', genero = '', telefone = '$telefone', email = '$email', obs = '$obs',
nome_fantasia = '$nome_fantasia' WHERE id = $id;";

// Fazendo query do comando sql
if(mysqli_query($conn, $sql)) {
    // Redirecionando o usuário para a página 'clientes.php'
    header("Location: ../vendas/clientes.php");
    exit();
}