<?php

include_once "conexao.php";

// Dados do cliente físico
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$nome = $_POST["nome-cliente"];
$cpf = $_POST["cpf-cliente"];
$nascimento = $_POST["nascimento-cliente"];
$genero = $_POST["genero-cliente"];
$categoria = $_POST["categoria-pessoa"];
$telefone = $_POST["telefone-cliente"];
$email = filter_input(INPUT_POST, "email-cliente", FILTER_VALIDATE_EMAIL);
$obs = $_POST["observacoes"];


// modificando dados do cliente
$sql = "UPDATE cliente
SET categoria = '$categoria', nome = '$nome', cpf = '$cpf',
nascimento = '$nascimento', genero = '$genero', telefone = '$telefone',
email = '$email', obs = '$obs', nome_fantasia = '' WHERE id = $id;";

// Fazendo query do comando sql
if(mysqli_query($conn, $sql)) {
    // Redirecionando o usuário para a página 'clientes.php'
    header("Location: ../vendas/clientes.php");
    exit();
}