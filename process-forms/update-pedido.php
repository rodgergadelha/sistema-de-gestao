<?php

include_once "conexao.php";

// dados a serem carregados para o banco de dados
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
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

// modificando dados do produto
$sql = "UPDATE pedido
    SET nome_cliente = '$nome_cliente', nome_vendedor = '$nome_vendedor', produtos = '$produtos',
    valor_total = $valor_total, pagamento = '$pagamento', data_pedido = '$data_pedido',
    obs = '$obs', parcelas = $parcelas, quantidades = '$quantidades', valores_totais = '$valores_totais',
    valores_unit = '$valores_unit', valor_produtos = $valor_produtos, valor_frete = $valor_frete,
    valor_desconto = $valor_desconto
    WHERE id = $id;";


// Salvando dados
if(mysqli_query($conn, $sql)) {
    // Redirecionando o usuário para a página 'pedidos.php'
    header("Location: ../vendas/pedidos.php");
    exit();
}