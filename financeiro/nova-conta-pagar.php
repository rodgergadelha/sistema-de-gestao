<?php 

session_start();
$contas_pagar = $_SESSION["contas_pagar"];

$conta_pagar_req = null;

if(count($_GET) > 0) {  
    foreach($contas_pagar as $conta_pagar) {
        if((string)$conta_pagar["id"] == $_GET["id"]) {
            $conta_pagar_req = $conta_pagar;
            break;
        }
    }
}

session_abort();

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
    <title>Contas a pagar</title>
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
                        <a href="contas-pagar.php">Contas a pagar</a>
                        <a href="nova-conta-pagar.php">Nova conta a pagar</a>
                        <a href="fluxo-caixa.php">Fluxo de caixa</a>
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
            <h2>Dados do pagamento</h2>

            <div class="form-container">
                <form id="despesa-form" method="post"
                <?php
                    if(count($_GET) > 0) $action = "../process-forms/update-despesa.php";
                    else $action = "../process-forms/process-despesa-form.php";
                ?>
                action='<?php echo $action ?>'>

                    <input 
                        style="display: none;"
                        type="number"
                        value=<?php if($conta_pagar_req) echo $conta_pagar_req["id"];?>
                        name="id"
                    >

                    <div class="info">
                        <label for="nome-despesa">Nome da despesa</label>
                        <input type="text" id="nome-despesa" name="nome-despesa" value='<?php if($conta_pagar_req) echo $conta_pagar_req["nome"];?>'>
                    </div>

                    <div class="info">
                        <label for="categoria-despesa">Categoria</label>
                        <input type="text" id="categoria-despesa" name="categoria-despesa" value='<?php if($conta_pagar_req) echo $conta_pagar_req["categoria"];?>'>
                    </div>

                    <div class="info">
                        <label for="forma-pagamento">Forma de pagamento</label>
                        <select id="forma-pagamento" name="forma-pagamento">
                            <option <?php if($conta_pagar_req && $conta_pagar_req["forma_pagamento"] == "Dinheiro f??sico") echo "selected";?> value="Dinheiro f??sico">Dinheiro f??sico</option>
                            <option <?php if($conta_pagar_req && $conta_pagar_req["forma_pagamento"] == "Boleto") echo "selected";?> value="Boleto">Boleto Banc??rio</option>
                            <option <?php if($conta_pagar_req && $conta_pagar_req["forma_pagamento"] == "Pix") echo "selected";?> value="Pix">Pix</option>
                            <option <?php if($conta_pagar_req && $conta_pagar_req["forma_pagamento"] == "Cr??dito") echo "selected";?> value="Cr??dito">Cart??o de cr??dito</option>
                        </select>
                    </div>

                    <div class="info">
                        <label for="codigo-barras">C??digo de barras</label>
                        <input type="number" id="codigo-barras" name="codigo-barras" value=<?php if($conta_pagar_req) echo $conta_pagar_req["codigo_barras"];?>>
                    </div>

                    <div class="info">
                        <label for="vencimento">Vencimento</label>
                        <input type="date" id="vencimento" name="vencimento" value='<?php if($conta_pagar_req) echo $conta_pagar_req["vencimento"];?>'>
                    </div>

                    <div class="info">
                        <label for="valor">Valor</label>
                        <input type="number" id="valor" step="0.01" name="valor" value=<?php if($conta_pagar_req) echo $conta_pagar_req["valor"];?>>
                    </div>

                    <div class="info">
                        <label for="emissao">Emiss??o</label>
                        <input type="date" id="emissao" name="emissao"value='<?php if($conta_pagar_req) echo $conta_pagar_req["emissao"];?>'>
                    </div>

                    <div class="info">
                        <label for="observacoes">Observa????es</label>
                        <textarea id="observacoes" name="observacoes" value='<?php if($conta_pagar_req) echo $conta_pagar_req["obs"];?>'></textarea>
                    </div>

                    <div class="botoes-container">
                        <button class="botao-rosa">Salvar</button>
                        <button form="" onclick="location = 'contas-pagar.php';">Cancelar</button>
                    </div>
                </form>
            </div>
            

        </div>
    </main>

</body>
</html>