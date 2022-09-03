<!-- Conectando-se com o banco de dados e obtendo dados dos clientes -->
<?php
    include_once "../process-forms/conexao.php";

    // Obtendo todas as linhas da tabela cliente
    $sql = "SELECT  * FROM pedido";

    //Fazendo query e obtendo resultados
    $result = mysqli_query($conn, $sql);

    // Salvando linhas da tabela 'clientes' como um array
    $pedidos = array_reverse(mysqli_fetch_all($result, MYSQLI_ASSOC));

    // Liberando memória
    mysqli_free_result($result);

    // Fechando conexão
    mysqli_close($conn);

    // Iniciando a $_SESSION com os dados que serão enviados para outra página
    session_start();
    $_SESSION["pedidos"] = $pedidos;
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
    <title>Pedidos</title>
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
                        <a href="cadastro-clientes.php">Cadastrar cliente</a>
                        <a href="clientes.php">Clientes</a>
                        <a href="novo-pedido.php">Novo pedido</a>
                        <a href="pedidos.php">Pedidos</a>
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
                        <a href="../estoque/produtos.php">Produtos</a>
                        <a href="../estoque/cadastro-produtos.php">Cadastrar produto</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <h2>Pedidos</h2>

            <div class="opcoes-container">
                <div class="botoes-container">
                    <button class="novo-pedido botao-rosa" onclick="location = 'novo-pedido.php';">Novo pedido</button>
                    <button onclick="TableToExcel.convert(document.getElementById('pedidos-table'));" class="gerar-relatorio">Gerar planilha de pedidos</button>
                    
                    <!-- formulário que será usado para a ação de excluir pedidos -->
                    <form style="display: inline-block;" id="excluir-pedido-form" action="../process-forms/excluir-linha.php" method="post">
                        <input type="text" name="redirect" value="../vendas/pedidos.php" style="display: none;">
                        <input type="text" name="nome-tabela" value="pedido" style="display: none;">
                        <button class="excluir-pedido">Excluir pedido</button>
                    </form>
                </div>
    
                <input class="pesquisar-pedido pesquisar" type="text" placeholder="Pesquisar">
            </div>

            <div class="table-container">
                <table id="pedidos-table">
                    <tr>
                        <th class="primeira-linha checkbox-column"><input id="super-checkbox" type="checkbox"></th>
                        <th class="primeira-linha">Data</th>
                        <th class="primeira-linha">Cliente</th>
                        <th class="primeira-linha">Valor total</th>
                        <th class="primeira-linha"></th>
                    </tr>
    
                    <?php foreach ($pedidos as $pedido) { ?>
                        <tr>
                            <th class="checkbox-column">
                                <input form="excluir-pedido-form" type="checkbox" name="checkbox[]" value=<?php echo $pedido["id"] ?>>
                            </th>
                            <th>
                                <?php echo htmlspecialchars($pedido["data_pedido"]) ?>
                            </th>
                            <th>
                                <?php echo htmlspecialchars($pedido["nome_cliente"]) ?>
                            </th>
                            <th>
                                R$ <?php echo number_format($pedido["valor_total"], 2, ","); ?>
                            </th>
                            <th>
                                <a href="detalhes-pedido.php?id=<?php echo $pedido["id"] ?>">Detalhes</a>
                            </th>
                        </tr>
                    <?php } ?>
                </table>
            </div>

        </div>
    </main>

</body>
</html>