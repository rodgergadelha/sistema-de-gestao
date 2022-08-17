<!-- Conectando-se com o banco de dados e obtendo dados dos clientes -->
<?php
    include_once "../process-forms/conexao.php";

    // Obtendo todas as linhas da tabela cliente
    $sql = "SELECT  * FROM produto";

    //Fazendo query e obtendo resultados
    $result = mysqli_query($conn, $sql);

    // Salvando linhas da tabela 'clientes' como um array
    $produtos = array_reverse(mysqli_fetch_all($result, MYSQLI_ASSOC));

    // Liberando memória
    mysqli_free_result($result);

    // Fechando conexão
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet"> 
    <title>Estoque</title>
</head>
<body>
    <header>
        <div class="image-container">
            <img class="logo" alt="logo blessed conceito">
        </div>
        
        <nav>
            <ul>
                <li><a href="#">Vendas</a></li>
                <li><a href="#">Financeiro</a></li>
                <li><a href="#">Estoque</a></li>
            </ul>
        </nav>
    </header>

    <main>  
        <div class="container">
            <h2>Estoque</h2>

            <div class="opcoes-container">
                <div class="botoes-container">
                    <button onclick="location = 'cadastro-produtos.html';" class="adicionar-produto botao-rosa">Adicionar produto</button>
                    <button class="gerar-relatorio">Gerar planilha de produtos</button>
                    <button class="excluir-produto">Excluir produto</button>
                </div>
    
                <input class="pesquisar-pedido pesquisar" type="text" placeholder="Pesquisar">
            </div>

            <table id="produtos-table">
                <tr>
                    <th class="primeira-linha checkbox-column"><input type="checkbox"></th>
                    <th class="primeira-linha coluna-nome">Nome</th>
                    <th class="primeira-linha">Código</th>
                    <th class="primeira-linha">Estoque</th>
                    <th class="primeira-linha">Valor unitário</th>
                </tr>

                <?php foreach ($produtos as $produto) { ?>
                    <tr>
                        <th class="checkbox-column"><input type="checkbox"></th>
                        <th class="coluna-nome"><?php echo htmlspecialchars($produto["nome"]) ?></th>
                        <th><?php echo htmlspecialchars($produto["codigo"]) ?></th>
                        <th><?php echo htmlspecialchars($produto["unidade"]) ?></th>
                        <th><?php echo htmlspecialchars($produto["valor_venda"]) ?></th>
                    </tr>
                <?php } ?>
            </table>

        </div>
    </main>

</body>
</html>