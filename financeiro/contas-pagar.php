<!-- Conectando-se com o banco de dados e obtendo dados das despesas -->
<?php
    include_once "../process-forms/conexao.php";

    // Obtendo todas as linhas da tabela conta_a_pagar
    $sql = "SELECT  * FROM conta_a_pagar";

    //Fazendo query e obtendo resultados
    $result = mysqli_query($conn, $sql);

    // Salvando linhas da tabela 'conta_a_pagar' como um array
    $contas_pagar = array_reverse(mysqli_fetch_all($result, MYSQLI_ASSOC));

    // Liberando memória
    mysqli_free_result($result);

    // Fechando conexão
    mysqli_close($conn);

    // Iniciando a $_SESSION com os dados que serão enviados para outra página
    session_start();
    $_SESSION["contas_pagar"] = $contas_pagar;
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
    <title>Contas a pagar</title>
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
            <h2>Contas a pagar</h2>

            <div class="opcoes-container">
                <div class="botoes-container">
                    <button onclick="location = 'nova-conta-pagar.php';" class="adicionar-conta-pagar botao-rosa">Adicionar conta a pagar</button>
                    <button onclick="TableToExcel.convert(document.getElementById('contas-pagar-table'));" class="gerar-relatorio">Gerar planilha de contas a pagar</button>
                    
                    <!-- formulário que será usado para a ação de excluir contas  -->
                    <form style="display: inline-block;" id="excluir-conta-pagar-form" action="../process-forms/excluir-linha.php" method="post">
                        <input type="text" name="redirect" value="../financeiro/contas-pagar.php" style="display: none;">
                        <input type="text" name="nome-tabela" value="conta_a_pagar" style="display: none;">
                        <button class="excluir-conta-pagar">Excluir conta</button>
                    </form>
                </div>
    
                <input class="pesquisar-conta pesquisar" type="text" placeholder="Pesquisar">
            </div>
            
            <table id="contas-pagar-table">
                <tr>
                    <th class="primeira-linha checkbox-column"><input id="super-checkbox" type="checkbox"></th>
                    <th class="primeira-linha">Nome da despesa</th>
                    <th class="primeira-linha">Vencimento</th>
                    <th class="primeira-linha">Emissão</th>
                    <th class="primeira-linha">Valor</th>
                </tr>

                <?php foreach ($contas_pagar as $conta_pagar) { ?>
                    <tr>
                        <th class="checkbox-column">
                            <input form="excluir-conta-pagar-form" type="checkbox" name="checkbox[]" value=<?php echo $conta_pagar["id"] ?>>
                        </th>
                        <th onMouseOver="this.style.cursor = 'pointer'" onclick="location = 'nova-conta-pagar.php?id=<?php echo $conta_pagar['id']; ?>';"><?php echo htmlspecialchars($conta_pagar["nome"]) ?></th>
                        <th><?php echo htmlspecialchars($conta_pagar["vencimento"]) ?></th>
                        <th><?php echo htmlspecialchars($conta_pagar["emissao"]) ?></th>
                        <th><?php echo htmlspecialchars($conta_pagar["valor"]) ?></th>
                    </tr>
                <?php } ?>
            </table>

        </div>
    </main>

</body>
</html>