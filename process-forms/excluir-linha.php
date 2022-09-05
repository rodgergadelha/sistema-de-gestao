<?php

include_once "conexao.php";

$sql = "";

if(count($_POST) > 0) {
    $id_array = $_POST["checkbox"];

    if(!$id_array) {
        // Redirecionando o usuário caso não haja nada para excluir
        $location = $_POST["redirect"];
        header("Location: $location");
        exit();
    }

    $tabela = $_POST["nome-tabela"];

    foreach($id_array as $id) {
        $sql .= "DELETE FROM $tabela WHERE id = $id;";
        
        if($tabela == "pedido") {
            $sql_pedido = "SELECT * FROM pedido WHERE id = $id;";
            $result = mysqli_query($conn, $sql_pedido);
            $pedido = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
            $produtos_array = explode(",", $pedido["produtos"]);
            $quantidades_array = explode(" ", $pedido["quantidades"]);

            foreach($produtos_array as $produto_nome) {
                $quantidade = (int)($quantidades_array[array_search($produto_nome, $produtos_array)]);
                $sql .= "UPDATE produto
                        SET unidade = unidade + $quantidade
                        WHERE nome = '$produto_nome';";
            }
            
            mysqli_free_result($result);
        }

        if($tabela == "produto") {
            //Obtendo a localização da imagem antiga para removê-la
            $sql_imagem_antiga = "SELECT imagem FROM produto WHERE id = $id;";
            $result = mysqli_query($conn, $sql_imagem_antiga);
            $imagem_antiga = mysqli_fetch_all($result)[0][0];
            mysqli_free_result($result);
            $path_imagem_antiga = "../imagens/$imagem_antiga"; 
            
            // Removendo a imagem antiga
            unlink($path_imagem_antiga);
        }

    }   

}

// Salvando dados
if(mysqli_multi_query($conn, $sql)) {
    echo "<h2>Dados salvos!</h2>";
}

// Redirecionando o usuário
$location = $_POST["redirect"];
header("Location: $location");
exit();