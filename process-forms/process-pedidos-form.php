<?php

include_once "conexao.php";

// dados a serem carregados para o banco de dados
$nome_cliente = $_POST["nome-cliente"];
$nome_vendedor = $_POST["nome-vendedor"];
$produtos = implode(",", $_POST["nome-produto"]);
$valor_total = filter_input(INPUT_POST, "valor-total-pedido", FILTER_VALIDATE_FLOAT);
$pagamento = $_POST["condicao-pagamento"];
$data_pedido = $_POST["data-pedido"];
$obs = $_POST["observacoes"];
$parcelas = filter_input(INPUT_POST, "parcelas", FILTER_VALIDATE_INT);
$quantidades = implode(" ", $_POST["quantidade-produto"]);
$valores_totais = implode(" ", $_POST["valor-total-produto"]);
$valores_unit = implode(" ", $_POST["valor-unit-produto"]);
$valor_produtos = filter_input(INPUT_POST, "valor-produtos", FILTER_VALIDATE_FLOAT);
$valor_frete = filter_input(INPUT_POST, "valor-frete", FILTER_VALIDATE_FLOAT);
$valor_desconto = filter_input(INPUT_POST, "valor-desconto", FILTER_VALIDATE_FLOAT);

// inserindo dados na tabela produto do banco de dados
$sql = "INSERT INTO pedido (nome_cliente, nome_vendedor, produtos, valor_total, pagamento, data_pedido, obs, parcelas, quantidades, valores_totais, valores_unit, valor_produtos, valor_frete, valor_desconto)
        VALUES ('$nome_cliente', '$nome_vendedor', '$produtos', $valor_total, '$pagamento', '$data_pedido', '$obs', $parcelas, '$quantidades', '$valores_totais', '$valores_unit', $valor_produtos, $valor_frete, $valor_desconto);";
        

// Decrementando o estoque dos produtos vendidos
foreach($_POST["nome-produto"] as $nome_produto) {
    $unidade_str = $_POST["quantidade-produto"][array_search($nome_produto, $_POST["nome-produto"])];
    $unidade = (int)$unidade_str;

    $sql .= "UPDATE produto
    SET unidade = unidade - $unidade
    WHERE nome = '$nome_produto' and unidade > 0;";
};

// Salvando dados
if(mysqli_multi_query($conn, $sql)) {
    // Redirecionando o usuário para a página 'pedidos.php'
    header("Location: ../vendas/pedidos.php");
    exit();
}