<?php

include_once "conexao.php";

// dados a serem carregados para o banco de dados
$nome_cliente = $_POST["nome-cliente"];
$nome_vendedor = $_POST["nome-vendedor"];
$produtos = implode(" ", $_POST["nome-produto"]);
$valor_total = filter_input(INPUT_POST, "valor-total-pedido", FILTER_VALIDATE_FLOAT);
$pagamento = $_POST["condicao-pagamento"];
$data_pedido = $_POST["data-pedido"];
$obs = $_POST["observacoes"];
$parcelas = filter_input(INPUT_POST, "parcelas", FILTER_VALIDATE_INT);
$quantidades = implode(" ", $_POST["quantidade-produto"]);
$valores_totais = implode(" ", $_POST["valor-total-produto"]);

// inserindo dados na tabela produto do banco de dados
$sql = "INSERT INTO pedido (nome_cliente, nome_vendedor, produtos, valor_total, pagamento, data_pedido, obs, parcelas, quantidades, valores_totais)
        VALUES ('$nome_cliente', '$nome_vendedor', '$produtos', $valor_total, '$pagamento', '$data_pedido', '$obs', $parcelas, '$quantidades', '$valores_totais');";


// Decrementando o estoque dos produtos vendidos
foreach($_POST["nome-produto"] as $nome_produto) {
    $sql .= "UPDATE produto
    SET unidade = unidade - 1
    WHERE nome = '$nome_produto' and unidade > 0;";
};

// Salvando dados
if(mysqli_multi_query($conn, $sql)) {
    echo "<h2>Dados salvos!</h2>";
}else {
    echo "<h2>Erro.</h2>";
}