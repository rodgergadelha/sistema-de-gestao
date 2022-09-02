<!-- Conectando-se com o banco de dados e obtendo dados dos clientes -->
<?php
    include_once "../process-forms/conexao.php";

    date_default_timezone_set("America/Fortaleza");

    function obterFluxoMensal($mes, $conn) {
        // Obtendo todas os valores totais da tabela conta_a_pagar
        $sqlDespesas = "SELECT * FROM conta_a_pagar WHERE EXTRACT(MONTH FROM vencimento) = $mes";
        //Fazendo query e obtendo resultados
        $resultDespesas = mysqli_query($conn, $sqlDespesas);
        // array de despesas
        $despesas = mysqli_fetch_all($resultDespesas, MYSQLI_ASSOC);
        // Liberando memória
        mysqli_free_result($resultDespesas);

        // Obtendo todas os valores totais da tabela pedido
        $sqlVendas = "SELECT * FROM pedido WHERE EXTRACT(MONTH FROM data_pedido) = $mes";
        //Fazendo query e obtendo resultados
        $resultVendas = mysqli_query($conn, $sqlVendas);
        // array de vendas
        $vendas = mysqli_fetch_all($resultVendas, MYSQLI_ASSOC);
        // Liberando memória
        mysqli_free_result($resultVendas);

        // Soma dos valores de despesas
        $somaDespesas = 0;
        // Soma dos valores de despesas
        $somaVendas = 0;
        
        if(count($despesas) > 0) {
            foreach($despesas as $despesa) {
                $somaDespesas += $despesa["valor"];
            }
        }

        if(count($vendas) > 0) {
            foreach($vendas as $venda) {
                $somaVendas += $venda["valor_total"];
            }
        }

        //Obtendo saldo mensal
        $saldoMensal = $somaVendas - $somaDespesas;

        $fluxo = array($somaVendas, $somaDespesas, $saldoMensal);

        return $fluxo;
    }

    // Obtendo número do mês atual
    if(count($_POST) == 0){
        $mes_atual = (int) date("m");
    }else{
        $inputDate = strtotime($_POST["fluxo-data"]);
        $mes_atual = date("m", $inputDate);
    }

    // Obtendo número do mês anterior
    $mes_anterior = $mes_atual - 1;

    // Obtendo fluxos dos 2 últimos meses
    $fluxoMesAnterior =  obterFluxoMensal($mes_anterior, $conn);
    $fluxoMesAtual =  obterFluxoMensal($mes_atual, $conn);

    // Obtendo dados as serem exibidos na tela
    $saldoMesAnterior = $fluxoMesAnterior[2];
    $vendasMesAtual = $fluxoMesAtual[0];
    $despesasMesAtual = $fluxoMesAtual[1];
    $saldoMesAtual = $fluxoMesAtual[2];

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
    <script src="../js/fluxo-caixa-script.js"></script>
    <script src="../js/tableToExcel.js"></script>
    <title>Fluxo de caixa</title>
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
            <h2>Fluxo de caixa</h2>

            <div class="opcoes-container">
                <div class="botoes-container">
                    <button onclick="TableToExcel.convert(document.getElementById('fluxo-table'));" class="gerar-relatorio botao-rosa">Gerar planilha do fluxo de caixa</button>
                </div>

                <form id="date-form" action="fluxo-caixa.php" method="post">
                    <input id="fluxo-data" type="date" name="fluxo-data"
                    value=<?php if(count($_POST) == 1) echo $_POST["fluxo-data"]; else echo date("Y-m-d");?>>
                </form>
            </div>

            <div id="fluxo-table" class="table-container fluxo-tables">
                <table id="saldo-total-table">
                    <tr>
                        <th class="primeira-linha">Saldo - Todas as contas</th>
                    </tr>
    
                    <tr>
                        <th><span>Saldo do mês anterior</span> <span>R$ <?php echo number_format($saldoMesAnterior, 2, ","); ?></span></th>
                    </tr>
    
                    <tr>
                        <th><span>Saldo atual</span> <span >R$ <?php echo number_format($saldoMesAtual, 2, ","); ?></span></th>
                    </tr>
                </table>
    
                <table id="receitas-table">
                    <tr>
                        <th class="primeira-linha">Receitas</th>
                    </tr>
    
                    <tr>
                        <th>R$ <?php echo number_format($vendasMesAtual, 2, ","); ?></th>
                    </tr>
    
                </table>
    
                <table id="despesas-table">
                    <tr>
                        <th class="primeira-linha">Despesas</th>
                    </tr>
    
                    <tr>
                        <th>R$ <?php echo number_format($despesasMesAtual, 2, ","); ?></th>
                    </tr>
    
                </table>
            </div>

        </div>
    </main>

</body>
</html>