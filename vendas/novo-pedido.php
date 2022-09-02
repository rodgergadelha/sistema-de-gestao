<?php 

include_once "../process-forms/conexao.php";

date_default_timezone_set("America/Fortaleza");

// Criando array com nomes dos produtos para serem exibidos no input de escolha de produtos
$sql_produtos = "SELECT * FROM produto;";
$result = mysqli_query($conn, $sql_produtos);
$produtos = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

// Criando array com nomes dos clientes para serem exibidos no input do nome do cliente
$sql_clientes = "SELECT * FROM cliente;";
$result = mysqli_query($conn, $sql_clientes);
$clientes = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <script src="../js/novo-pedido-produtos-section.js"></script>
    <script src="../js/totais-pedido-script.js"></script>
    <title>Novo pedido</title>
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
            <h2>Dados do pedido</h2>

            <div class="form-container">
                <form id="pedidos-form" action="../process-forms/process-pedidos-form.php" method="post" enctype="multipart/form-data">
                    <section>
                        <div class="row">
                            <div class="">
                                <label for="nome-cliente">Cliente</label>
                                <input type="text" id="nome-cliente" name="nome-cliente" required autocomplete="off">
                                <div class="ul-container">
                                    <ul id="lista-clientes" class="lista-nomes">
                                        <?php
                                            foreach($clientes as $cliente) {
                                                $nome_cliente = $cliente["nome"];
                                                echo "<li style='display: none;'>$nome_cliente</li>";
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
        
                            <div class="">
                                <label for="nome-vendedor">Vendedor</label>
                                <input type="text" id="nome-vendedor" name="nome-vendedor" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="">
                                <a href="cadastro-clientes.php">Cadastrar novo cliente</a>
                            </div>
                        </div>
                    </section>

                    <section id="produtos-section" qtd='<?php echo count($produtos) ?>'>
                        <h3>Produtos</h3>

                        <div class="row">
                            <div class="">
                                <label>Produto/Código</label>
                                <input type="text" liid="" class="nome-produto" name="nome-produto[]" required autocomplete="off" qtdmaxima="">
                                <div class="ul-container">
                                    <ul class="lista-nomes lista-produtos">
                                        <?php
                                            foreach($produtos as $produto) {
                                                $nome_produto = htmlspecialchars($produto["nome"]);
                                                $unidade = $produto["unidade"];
                                                $codigo = $produto["codigo"];
                                                $id = $produto["id"];

                                                echo "<li id='$id' style='display: none;' codigo='$codigo' qtdmaxima='$unidade'>$nome_produto</li>";
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
        
                            <div class="">
                                <label>Qtde.</label>
                                <input type="number" class="quantidade-produto" name="quantidade-produto[]" value="1" min="1" max="" required>
                            </div>

                            <div class="">
                                <label>Valor unit.</label>
                                <input type="number" class="valor-unit-produto" name="valor-unit-produto[]" value="0" step="0.01" required>
                            </div>

                            <div class="">
                                <label>Valor total</label>
                                <input type="number" class="valor-total-produto" name="valor-total-produto[]" value="0" step="0.01" readonly required>
                            </div>

                            <button class="remover-produto-pedido" form="">Remover</button>

                        </div>

                        <div class="row">
                            <span id="adicionar-produto">+ Adicionar outro produto</span>
                        </div>
                    </section>

                    <section id="totais-pedido">
                        <h3>Totais do pedido</h3>

                        <div class="row">
                            <div class="">
                                <label for="valor-produtos">Valor dos produtos</label>
                                <input type="number" id="valor-produtos" name="valor-produtos" value="0" step="0.01" readonly required>
                            </div>

                            <div class="">
                                <label for="valor-frete">Valor do frete</label>
                                <input type="number" id="valor-frete" name="valor-frete" value="0" step="0.01">
                            </div>

                            <div class="">
                                <label for="valor-desconto">Valor do desconto</label>
                                <input type="number" id="valor-desconto" name="valor-desconto" value="0" step="0.01">
                            </div>
                        </div>

                        <div class="row">
                            <div class="">
                                <label for="valor-total-pedido">Valor total do pedido</label>
                                <input type="number" id="valor-total-pedido" name="valor-total-pedido" value="0" step="0.01" readonly>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h3>Pagamento</h3>

                        <div class="row">
                            <div class="">
                                <label for="condicao-pagamento">Condição de pagamento</label>
                                <select name="condicao-pagamento" id="condicao-pagamento">
                                    <option value="Dinheiro físico">Dinheiro físico</option>
                                    <option value="Boleto">Boleto Bancário</option>
                                    <option value="Pix">Pix</option>
                                    <option value="Crédito">Cartão de crédito</option>
                                </select>
                            </div>

                            <div class="">
                                <label for="parcelas">Quantidade de parcelas</label>
                                <input type="number" id="parcelas" name="parcelas" value="1">
                            </div>
                        </div>
                    </section>

                    <section>
                        <h3>Detalhes do pedido</h3>

                        <div class="row">
                            <div class="">
                                <label for="data-pedido">Data do pedido</label>
                                <input type="date" id="data-pedido" name="data-pedido" value='<?php echo date("Y-m-d"); ?>'>
                            </div>
                        </div>

                        <div class="row">
                            <div class="">
                                <label for="observacoes">Observações</label>
                                <textarea id="observacoes" name="observacoes">
                                </textarea>
                            </div>
                        </div>
                    </section>

                    <div class="botoes-container">
                        <button class="botao-rosa">Salvar</button>
                        <button form="" onclick="location = 'pedidos.php';">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </main>
</body>
</html>