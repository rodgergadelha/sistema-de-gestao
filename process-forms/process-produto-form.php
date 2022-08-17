<?php

include_once "conexao.php";

// dados a serem carregados para o banco de dados
$nome = $_POST["nome-produto"];
$codigo = $_POST["codigo-produto"];
$unidade = filter_input(INPUT_POST, "unidade-produto", FILTER_VALIDATE_INT);
$marca = $_POST["marca-produto"];
$valor_venda = filter_input(INPUT_POST, "valor-venda", FILTER_VALIDATE_FLOAT);
$valor_custo = filter_input(INPUT_POST, "valor-custo", FILTER_VALIDATE_FLOAT);
$tamanho = filter_input(INPUT_POST, "tamanho-produto", FILTER_VALIDATE_FLOAT);
$fornecedor = $_POST["fornecedor-produto"];
$categoria = $_POST["categoria-produto"];
$obs = $_POST["observacoes"];
$imagem = "(Sem imagem)";

// Upload da imagem
if($_FILES["imagem-produto"]["size"] != 0 && $_FILES["imagem-produto"]["error"] == 0) {
    // Colocando nome único no arquivo para que não haja
    // possibilidade de substituição
    $imagem = uniqid("", true).".".$_FILES["imagem-produto"]["name"];

    // Nome do arquivo temp (localização inicial)
    $tname = $_FILES["imagem-produto"]["tmp_name"];

    // Movendo o arquivo para a pasta 'imagens'
    move_uploaded_file($tname, "imagens/" . $imagem);
}

// inserindo dados na tabela produto do banco de dados
$sql = "INSERT INTO produto (nome, codigo, unidade, marca, valor_venda, valor_custo, tamanho, fornecedor, categoria, obs, imagem)
        VALUES ('$nome', '$codigo', $unidade, '$marca', $valor_venda, $valor_custo, $tamanho, '$fornecedor', '$categoria', '$obs', '$imagem')";


// Salvando dados
if(mysqli_query($conn, $sql)) {
    echo "<h2>Dados salvos!</h2>";
}else {
    echo "<h2>Erro.</h2>";
}
