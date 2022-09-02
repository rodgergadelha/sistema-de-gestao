<?php

include_once "conexao.php";

// dados a serem carregados para o banco de dados
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$nome = $_POST["nome-despesa"];
$categoria = $_POST["categoria-despesa"];
$forma_pagamento = $_POST["forma-pagamento"];
$codigo_barras = filter_input(INPUT_POST, "codigo-barras", FILTER_VALIDATE_INT);
$vencimento = $_POST["vencimento"];
$valor = filter_input(INPUT_POST, "valor", FILTER_VALIDATE_FLOAT);
$emissao = $_POST["emissao"];
$obs = $_POST["observacoes"];

// inserindo dados na tabela conta_a_pagar do banco de dados
$sql = "UPDATE conta_a_pagar
        SET nome = '$nome', categoria = '$categoria', forma_pagamento = '$forma_pagamento',
        codigo_barras = $codigo_barras, vencimento = '$vencimento', valor = $valor,
        emissao = '$emissao', obs = '$obs' WHERE id = $id;";


// Salvando dados
if(mysqli_query($conn, $sql)) {
    // Redirecionando o usuário para a página 'contas-pagar.php'
    header("Location: ../financeiro/contas-pagar.php");
    exit();
}