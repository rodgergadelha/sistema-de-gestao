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
    <title>Pedidos</title>
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
            <h2>Pedidos</h2>

            <div class="opcoes-container">
                <div class="botoes-container">
                    <button class="novo-pedido botao-rosa" onclick="location = 'novo-pedido.html';">Novo pedido</button>
                    <button class="gerar-relatorio">Gerar planilha de pedidos</button>
                    <button class="excluir-pedido">Excluir pedido</button>
                </div>
    
                <input class="pesquisar-pedido pesquisar" type="text" placeholder="Pesquisar">
            </div>

            <div class="table-container">
                <table id="pedidos-table">
                    <tr>
                        <th class="primeira-linha checkbox-column"><input type="checkbox"></th>
                        <th class="primeira-linha">N°</th>
                        <th class="primeira-linha">Data</th>
                        <th class="primeira-linha">Cliente</th>
                        <th class="primeira-linha">Valor total</th>
                    </tr>
    
                    <?php foreach ($pedidos as $pedido) { ?>
                        <tr>
                            <th class="checkbox-column"><input type="checkbox"></th>
                            <th><?php echo htmlspecialchars($pedido["id"]) ?></th>
                            <th><?php echo htmlspecialchars($pedido["data_pedido"]) ?></th>
                            <th><?php echo htmlspecialchars($pedido["nome_cliente"]) ?></th>
                            <th><?php echo htmlspecialchars($pedido["valor_total"]) ?></th>
                        </tr>
                    <?php } ?>
                </table>
            </div>

        </div>
    </main>

</body>
</html>