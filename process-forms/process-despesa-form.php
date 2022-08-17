<?php

include_once "conexao.php";

// dados a serem carregados para o banco de dados
$nome = $_POST["nome-despesa"];
$categoria = $_POST["categoria-despesa"];
$forma_pagamento = $_POST["forma-pagamento"];
$codigo_barras = filter_input(INPUT_POST, "codigo-barras", FILTER_VALIDATE_INT);
$vencimento = $_POST["vencimento"];
$valor = filter_input(INPUT_POST, "valor", FILTER_VALIDATE_FLOAT);
$emissao = $_POST["emissao"];
$obs = $_POST["observacoes"];

// inserindo dados na tabela produto do banco de dados
$sql = "INSERT INTO conta_a_pagar (nome, categoria, forma_pagamento, codigo_barras, vencimento, valor, emissao, obs)
        VALUES ('$nome', '$categoria', '$forma_pagamento', $codigo_barras, '$vencimento', $valor, '$emissao', '$obs')";


// Salvando dados
if(mysqli_query($conn, $sql)) {
    echo "<h2>Dados salvos!</h2>";
}else {
    echo "<h2>Erro.</h2>";
}