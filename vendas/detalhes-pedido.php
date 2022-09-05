<?php 

include_once "../process-forms/conexao.php";

date_default_timezone_set("America/Fortaleza");


session_start();
$pedidos = $_SESSION["pedidos"];
session_abort();

$pedido_req = null;

if(count($_GET) > 0) {  
    foreach($pedidos as $pedido) {
        if((string)$pedido["id"] == $_GET["id"]) {
            $pedido_req = $pedido;
            break;
        }
    }
}

?>


<?php

// Obtendo informações dos totais do pedido e salvando em arrays
$quant_produtos = 1;
if($pedido_req) {
    $produtos_nomes =  explode(",", $pedido_req["produtos"]);
    $produtos_quantidades = explode(" ", $pedido_req["quantidades"]);
    $produtos_valores_totais = explode(" ", $pedido_req["valores_totais"]);
    $produtos_valores_unit = explode(" ", $pedido_req["valores_unit"]);
    $quant_produtos = count($produtos_nomes);
}

// Criando array com nomes dos produtos para serem exibidos no input de escolha de produtos
$sql_produtos = "SELECT * FROM produto;";
$result = mysqli_query($conn, $sql_produtos);
$produtos = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

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
    <title>Novo pedido</title>
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
            <h2>Dados do pedido</h2>

            <div class="form-container">
                <form id="pedidos-form">
                    <section>
                        <div class="row">
                            <div class="">
                                <label for="nome-produto">Cliente</label>
                                <input type="text" id="nome-cliente" name="nome-cliente" value='<?php if($pedido_req) echo $pedido_req["nome_cliente"];?>' required readonly>
                            </div>
        
                            <div class="">
                                <label for="nome-vendedor">Vendedor</label>
                                <input type="text" id="nome-vendedor" name="nome-vendedor" value='<?php if($pedido_req) echo $pedido_req["nome_vendedor"];?>' required readonly>
                            </div>
                        </div>

                    </section>

                    <section id="produtos-section">
                        <h3>Produtos</h3>

                        <?php for ($index = 0; $index < $quant_produtos; $index++) { ?>
                            <div class="row">
                                <div class="">
                                    <label for="nome-produto">Produto/Código</label>
                                    <select id="nome-produto" name="nome-produto[]" required disabled>
                                        <?php
                                        foreach($produtos as $produto){
                                            if($produto["unidade"] == 0) continue; 
                                            $nome_produto = htmlspecialchars($produto["nome"]);
                                            $unidade = $produto["unidade"];
                                        ?>
                                            <option value='<?php echo $nome_produto; ?>'
                                            <?php if(($pedido_req && $produtos_nomes[$index] == $nome_produto) || (!$pedido_req &&  array_search($produto, $produtos) == 0)) echo "selected"; ?>    
                                            qtdmaxima= '<?php echo $unidade; ?>'>
                                                <?php echo $nome_produto; ?>
                                            </option>

                                        <?php } ?>
                                    </select>
                                </div>
            
                                <div class="">
                                    <label for="quantidade-produto">Qtde.</label>
                                    <input type="number" class="quantidade-produto" id="quantidade-produto" name="quantidade-produto[]"
                                    value=<?php if($pedido_req) echo (int)($produtos_quantidades[$index]); else echo 1;?>
                                    required min="1" readonly>
                                </div>

                                <div class="">
                                    <label for="valor-unit-produto">Valor unit.</label>
                                    <input type="number" id="valor-unit-produto" name="valor-unit-produto[]" value=<?php if($pedido_req) echo (float)($produtos_valores_unit[$index]); else echo 0;?> step="0.01" readonly required>
                                </div>

                                <div class="">
                                    <label for="valor-total-produto">Valor total</label>
                                    <input type="number" id="valor-total-produto" name="valor-total-produto[]" value=<?php if($pedido_req) echo (float)($produtos_valores_totais[$index]); else echo 0;?> step="0.01" readonly required>
                                </div>

                            </div>
                        
                        <?php } ?>
                    </section>

                    <section>
                        <h3>Totais do pedido</h3>

                        <div class="row">
                            <div class="">
                                <label for="valor-produtos">Valor dos produtos</label>
                                <input type="number" id="valor-produtos" name="valor-produtos" value=<?php if($pedido_req) echo (float)$pedido_req["valor_produtos"]; else echo 0;?> step="0.01" readonly required>
                            </div>

                            <div class="">
                                <label for="valor-frete">Valor do frete</label>
                                <input type="number" id="valor-frete" name="valor-frete" value=<?php if($pedido_req) echo (float)$pedido_req["valor_frete"]; else echo 0;?> step="0.01" readonly>
                            </div>

                            <div class="">
                                <label for="valor-desconto">Valor do desconto</label>
                                <input type="number" id="valor-desconto" name="valor-desconto" value=<?php if($pedido_req) echo (float)$pedido_req["valor_desconto"]; else echo 0;?> step="0.01" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="">
                                <label for="valor-total-pedido">Valor total do pedido</label>
                                <input type="number" id="valor-total-pedido" name="valor-total-pedido" value=<?php if($pedido_req) echo $pedido_req["valor_total"]; else echo 0;?> step="0.01" value=0 readonly>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h3>Pagamento</h3>

                        <div class="row">
                            <div class="">
                                <label for="condicao-pagamento">Condição de pagamento</label>
                                <select name="condicao-pagamento" id="condicao-pagamento" disabled>
                                    <option <?php if($pedido_req && $pedido_req["pagamento"] == "Dinheiro físico") echo "selected"; ?>
                                    value="Dinheiro físico">
                                        Dinheiro físico
                                    </option>
                                    <option <?php if($pedido_req && $pedido_req["pagamento"] == "Boleto") echo "selected"; ?>
                                    value="Boleto">
                                        Boleto Bancário
                                    </option>
                                    <option <?php if($pedido_req && $pedido_req["pagamento"] == "Pix") echo "selected"; ?>
                                    value="Pix">
                                        Pix
                                    </option>
                                    <option <?php if($pedido_req && $pedido_req["pagamento"] == "Crédito") echo "selected"; ?>
                                    value="Crédito">
                                        Cartão de crédito
                                    </option>
                                </select>
                            </div>

                            <div class="">
                                <label for="parcelas">Quantidade de parcelas</label>
                                <input type="number" id="parcelas" name="parcelas" value=<?php if($pedido_req) echo $pedido_req["parcelas"]; else echo 1;?> readonly>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h3>Detalhes do pedido</h3>

                        <div class="row">
                            <div class="">
                                <label for="data-pedido">Data do pedido</label>
                                <input type="date" id="data-pedido" name="data-pedido" value='<?php if($pedido_req) echo $pedido_req["data_pedido"]; else echo date("Y-m-d"); ?>' readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="">
                                <label for="observacoes">Observações</label>
                                <textarea id="observacoes" name="observacoes" value='<?php if($pedido_req) echo $pedido_req["obs"];?>' readonly>
                                </textarea>
                            </div>
                        </div>
                    </section>

                    <div class="botoes-container">
                        <button class="botao-rosa" form="" onclick="location = 'pedidos.php';">Voltar</button>
                    </div>
                </form>
            </div>

        </div>
    </main>
</body>
</html>