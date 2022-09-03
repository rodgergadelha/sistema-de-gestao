<?php 

session_start();
$clientes = $_SESSION["clientes"];

$cliente_req = null;

if(count($_GET) > 0) {  
    foreach($clientes as $cliente) {
        if((string)$cliente["id"] == $_GET["id"]) {
            $cliente_req = $cliente;
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
    <script src="../js/cadastro-clientes-script.js"></script>
    <title>Cadastro de clientes</title>
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
            <h2>Novo cliente</h2>

            <div class="form-container">
                <form id="clientes-form" method="post"
                <?php
                    if(count($_GET) > 0) $action = "../process-forms/update-cliente.php";
                    else $action = "../process-forms/process-cliente-form.php";
                ?>
                action='<?php echo $action ?>'>

                    <input 
                        style="display: none;"
                        type="number"
                        value=<?php if($cliente_req) echo $cliente_req["id"];?>
                        name="id"
                    >

                    <div class="info">
                        <label for="categoria-pessoa">Tipo de pessoa</label>
                        <select id="categoria-pessoa" name="categoria-pessoa">
                            <option <?php if($cliente_req && $cliente_req["categoria"] == "Pessoa Física") echo "selected";?> value="Pessoa Física">Pessoa Física</option>
                            <option <?php if($cliente_req && $cliente_req["categoria"] == "Pessoa Jurídica") echo "selected";?> value="Pessoa Jurídica">Pessoa Jurídica</option>
                        </select>
                    </div>

                    <div class="info">
                        <label for="nome-cliente">Nome</label>
                        <input type="text" id="nome-cliente" name="nome-cliente" value='<?php if($cliente_req) echo $cliente_req["nome"];?>' required>
                    </div>

                    <div class="info">
                        <label for="cpf-cliente">CPF</label>
                        <input type="text" id="cpf-cliente" name="cpf-cliente" value='<?php if($cliente_req) echo $cliente_req["cpf"];?>' required>
                    </div>

                    <div class="info">
                        <label for="nascimento-cliente">Data de nascimento</label>
                        <input type="date" id="nascimento-cliente" name="nascimento-cliente" value='<?php if($cliente_req) echo $cliente_req["nascimento"];?>' required>
                    </div>

                    <div class="info">
                        <label for="genero-cliente">Gênero</label>
                        <select id="genero-cliente" name="genero-cliente">
                            <option <?php if($cliente_req && $cliente_req["genero"] == "Masculino") echo "selected";?> value="Masculino">Masculino</option>
                            <option <?php if($cliente_req && $cliente_req["genero"] == "Feminino") echo "selected";?> value="Feminino">Feminino</option>
                            <option <?php if($cliente_req && $cliente_req["genero"] == "Outro") echo "selected";?> value="Outro">Outro</option>
                        </select>
                    </div>
                    
                    <div class="info">
                        <label for="telefone-cliente">Telefone</label>
                        <input type="text" id="telefone-cliente" name="telefone-cliente" value='<?php if($cliente_req) echo $cliente_req["telefone"];?>' required>
                    </div>

                    <div class="info">
                        <label for="email-cliente">E-mail</label>
                        <input type="email" id="email-cliente" name="email-cliente" value='<?php if($cliente_req) echo $cliente_req["email"];?>'>
                    </div>

                    <div class="info">
                        <label for="observacoes">Observações</label>
                        <textarea id="observacoes" name="observacoes" value='<?php if($cliente_req) echo $cliente_req["obs"];?>'></textarea>
                    </div>

                    <div class="botoes-container">
                        <button class="botao-rosa">Salvar</button>
                        <button form="" onclick="location = 'clientes.php';">Cancelar</button>
                    </div>
                </form>

                <form id="clientes-juridicos-form" method="post"
                <?php
                    if(count($_GET) > 0) $action = "../process-forms/update-cliente-juridico.php";
                    else $action = "../process-forms/process-cliente-juridico-form.php";
                ?>
                action='<?php echo $action ?>'>
                    
                    <input 
                        style="display: none;"
                        type="number"
                        value=<?php if($cliente_req) echo $cliente_req["id"];?>
                        name="id"
                    >

                    <div class="info">
                        <label for="razao-social">Razão social</label>
                        <input type="text" id="razao-social" name="razao-social" value='<?php if($cliente_req) echo $cliente_req["nome"];?>' required>
                    </div>

                    <div class="info">
                        <label for="cnpj">CNPJ</label>
                        <input type="text" id="cnpj" name="cnpj" value='<?php if($cliente_req) echo $cliente_req["cpf"];?>' required>
                    </div>

                    <div class="info">
                        <label for="nome-fantasia">Nome fantasia</label>
                        <input type="text" id="nome-fantasia" name="nome-fantasia" value='<?php if($cliente_req) echo $cliente_req["nome_fantasia"];?>' required>
                    </div>

                    <div class="info">
                        <label for="telefone-cliente">Telefone</label>
                        <input type="text" id="telefone-cliente" name="telefone-cliente" value='<?php if($cliente_req) echo $cliente_req["telefone"];?>' required>
                    </div>

                    <div class="info">
                        <label for="email-cliente">E-mail</label>
                        <input type="email" id="email-cliente" name="email-cliente" value='<?php if($cliente_req) echo $cliente_req["email"];?>'>
                    </div>

                    <div class="info">
                        <label for="observacoes">Observações</label>
                        <textarea id="observacoes" name="observacoes" value='<?php if($cliente_req) echo $cliente_req["obs"];?>'></textarea>
                    </div>

                    <div class="botoes-container">
                        <button class="botao-rosa">Salvar</button>
                        <button form="" onclick="location = 'clientes.php';">Cancelar</button>
                    </div>
                </form>
                    
            </div>
            

        </div>
    </main>

</body>
</html>