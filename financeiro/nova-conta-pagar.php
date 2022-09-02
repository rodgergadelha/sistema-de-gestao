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
                            <option <?php if($conta_pagar_req && $conta_pagar_req["forma_pagamento"] == "Dinheiro físico") echo "selected";?> value="Dinheiro físico">Dinheiro físico</option>
                            <option <?php if($conta_pagar_req && $conta_pagar_req["forma_pagamento"] == "Boleto") echo "selected";?> value="Boleto">Boleto Bancário</option>
                            <option <?php if($conta_pagar_req && $conta_pagar_req["forma_pagamento"] == "Pix") echo "selected";?> value="Pix">Pix</option>
                            <option <?php if($conta_pagar_req && $conta_pagar_req["forma_pagamento"] == "Crédito") echo "selected";?> value="Crédito">Cartão de crédito</option>
                        </select>
                    </div>

                    <div class="info">
                        <label for="codigo-barras">Código de barras</label>
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
                        <label for="emissao">Emissão</label>
                        <input type="date" id="emissao" name="emissao"value='<?php if($conta_pagar_req) echo $conta_pagar_req["emissao"];?>'>
                    </div>

                    <div class="info">
                        <label for="observacoes">Observações</label>
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