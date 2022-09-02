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

//Obtendo a localização da imagem antiga para removê-la
$sql_imagem_antiga = "SELECT imagem FROM produto WHERE id = $id;";
$result = mysqli_query($conn, $sql_imagem_antiga);
$imagem_antiga = mysqli_fetch_all($result)[0][0];
mysqli_free_result($result);
$path_imagem_antiga = "../imagens/$imagem_antiga"; 
$imagem = $imagem_antiga;

// Upload da imagem
if($_FILES["imagem-produto"]["size"] != 0 && $_FILES["imagem-produto"]["error"] == 0) {
    // Colocando nome único no arquivo para que não haja
    // possibilidade de substituição
    $imagem = uniqid("", true).".".$_FILES["imagem-produto"]["name"];

    // Nome do arquivo temp (localização inicial)
    $tname = $_FILES["imagem-produto"]["tmp_name"];

    // Removendo a imagem antiga
    unlink($path_imagem_antiga);
    // Movendo o arquivo para a pasta 'imagens'
    move_uploaded_file($tname, "../imagens/" . $imagem);
}

// modificando dados do produto
$sql = "UPDATE produto
    SET nome = '$nome', codigo = '$codigo', unidade = $unidade, marca = '$marca', valor_venda = $valor_venda,
    valor_custo = $valor_custo, tamanho = $tamanho, fornecedor = '$fornecedor',
    categoria = '$categoria', obs = '$obs', imagem = '$imagem'
    WHERE id = $id;";

// Fazendo query do comando sql
if(mysqli_query($conn, $sql)) {
    // Redirecionando o usuário para a página 'produtos.php'
    header("Location: ../estoque/produtos.php");
    exit();
}