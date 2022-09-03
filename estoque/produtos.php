<!-- Conectando-se com o banco de dados e obtendo dados dos produtos -->
<?php
    include_once "../process-forms/conexao.php";

    // Obtendo todas as linhas da tabela produto
    $sql = "SELECT  * FROM produto";

    //Fazendo query e obtendo resultados
    $result = mysqli_query($conn, $sql);

    // Salvando linhas da tabela 'produtos' como um array
    $produtos = array_reverse(mysqli_fetch_all($result, MYSQLI_ASSOC));

    // Liberando memória
    mysqli_free_result($result);

    // Fechando conexão
    mysqli_close($conn);

    // Iniciando a $_SESSION com os dados que serão enviados para outra página
    session_start();
    $_SESSION["produtos"] = $produtos;
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
    <script src="../js/selection-script.js"></script>
    <script src="../js/tableToExcel.js"></script>
    <script src="../js/search-script-tabelas.js"></script>
    <title>Estoque</title>
</head>
<body>
    <header>
        <div class="image-container">
            <a href="../index.html"><img class="logo" alt="logo blessed conceito"></a>
        </div>
        
        <nav>
            <ul>
                <li>
                    <span>Vendas</span>
                    <div class="dropdown-content">
                        <a href="../vendas/cadastro-clientes.php">Cadastrar cliente</a>
                        <a href="../vendas/clientes.php">Clientes</a>
                        <a href="../vendas/novo-pedido.php">Novo pedido</a>
                        <a href="../vendas/pedidos.php">Pedidos</a>
                    </div>
                </li>
                <li>
                    <span>Financeiro</span>
                    <div class="dropdown-content">
                        <a href="../financeiro/contas-pagar.php">Contas a pagar</a>
                        <a href="../financeiro/nova-conta-pagar.php">Nova conta a pagar</a>
                        <a href="../financeiro/fluxo-caixa.php">Fluxo de caixa</a>
                    </div>
                </li>
                <li>
                    <span>Estoque</span>
                    <div class="dropdown-content">
                        <a href="produtos.php">Produtos</a>
                        <a href="cadastro-produtos.php">Cadastrar produto</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <main>  
        <div class="container">
            <h2>Estoque</h2>

            <div class="opcoes-container">
                <div class="botoes-container">
                    <button onclick="location = 'cadastro-produtos.php';" class="adicionar-produto botao-rosa">Adicionar produto</button>
                    <button onclick="TableToExcel.convert(document.getElementById('produtos-table'));" class="gerar-relatorio">Gerar planilha de produtos</button>
                    
                    <!-- formulário que será usado para a ação de excluir produtos -->
                    <form style="display: inline-block;" id="excluir-produto-form" action="../process-forms/excluir-linha.php" method="post">
                        <input type="text" name="redirect" value="../estoque/produtos.php" style="display: none;">
                        <input type="text" name="nome-tabela" value="produto" style="display: none;">
                        <button class="excluir-produto">Excluir produto</button>
                    </form>
                </div>
    
                <input class="pesquisar-pedido pesquisar" type="text" placeholder="Pesquisar">
            </div>

            <table id="produtos-table">
                <tr>
                    <th class="primeira-linha checkbox-column"><input id="super-checkbox" type="checkbox"></th>
                    <th class="primeira-linha coluna-nome">Nome</th>
                    <th class="primeira-linha">Código</th>
                    <th class="primeira-linha">Estoque</th>
                    <th class="primeira-linha">Valor unitário</th>
                </tr>

                <?php foreach ($produtos as $produto) { ?>
                    <tr>
                        <th class="checkbox-column">
                            <input form="excluir-produto-form" type="checkbox" name="checkbox[]" value=<?php echo $produto["id"] ?>>
                        </th>

                        <th class="coluna-nome" onMouseOver="this.style.cursor = 'pointer'" onclick="location = 'cadastro-produtos.php?id=<?php echo $produto['id']; ?>';">
                            <?php echo htmlspecialchars($produto["nome"]) ?>
                        </th>
                        <th>
                            <?php echo htmlspecialchars($produto["codigo"]) ?>
                        </th>
                        <th>
                            <?php echo htmlspecialchars($produto["unidade"]) ?>
                        </th>
                        <th>
                            R$ <?php echo number_format($produto["valor_venda"], 2, ","); ?>
                        </th>
                    </tr>
                <?php } ?>
            </table>

        </div>
    </main>

</body>
</html>