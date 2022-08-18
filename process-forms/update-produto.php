<?php

include_once "conexao.php";

// dados a serem carregados para o banco de dados
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
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

// modificando dados do produto
$sql = "UPDATE produto
    SET nome = '$nome', codigo = '$codigo', unidade = $unidade, marca = '$marca', valor_venda = $valor_venda,
    valor_custo = $valor_custo, tamanho = $tamanho, fornecedor = '$fornecedor',
    categoria = '$categoria', obs = '$obs', imagem = '$imagem'
    WHERE id = $id;";

// Salvando dados
if(mysqli_query($conn, $sql)) {
    echo "<h2>Dados salvos!</h2>";
}else {
    echo "<h2>Erro.</h2>";
}