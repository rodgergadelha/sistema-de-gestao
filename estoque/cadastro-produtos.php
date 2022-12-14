<?php 

session_start();
$produtos = $_SESSION["produtos"];

$produto_req = null;

$action = "../process-forms/process-produto-form.php";

if(count($_GET) > 0) {  
    foreach($produtos as $produto) {
        if((string)$produto["id"] == $_GET["id"]) {
            $produto_req = $produto;
            break;
        }
    }

    $action = "../process-forms/update-produto.php";
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
    <script src="../js/cadastro-produtos-imagem.js"></script>
    <title>Cadastro de produtos</title>
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
            <h2><?php if($produto_req) echo "Editar produto"; else echo "Novo produto"; ?></h2>

            <div class="form-container">
                <form id="produtos-form" action='<?php echo $action; ?>' method="post" enctype="multipart/form-data">
                    
                    <input 
                        style="display: none;"
                        type="number"
                        value=<?php if($produto_req) echo $produto_req["id"];?>
                        name="id"
                    >

                    <div class="info">
                        <label for="nome-produto">Nome do produto</label>
                        <input type="text" id="nome-produto" name="nome-produto" value='<?php if($produto_req) echo $produto_req["nome"];?>' required>
                    </div>

                    <div class="info">
                        <label for="codigo-produto">C??digo do produto</label>
                        <input type="text" id="codigo-produto" placeholder="PD0001" name="codigo-produto" value='<?php if($produto_req) echo $produto_req["codigo"];?>' required>
                    </div>

                   <div class="info">
                        <label for="unidade-produto">Unidade</label>
                        <input type="number" id="unidade-produto" placeholder="Ex: P??, Kg, Un" name="unidade-produto" value=<?php if($produto_req) echo $produto_req["unidade"];?> required>
                   </div>

                    <div class="info">
                        <label for="marca-produto">Marca</label>
                        <input type="text" id="marca-produto" placeholder="Nome do fabricante" value='<?php if($produto_req) echo $produto_req["marca"];?>' name="marca-produto">
                    </div>

                    <div class="info">
                        <label for="valor-venda">Valor de venda</label>
                        <input type="number" id="valor-venda" placeholder="R$ 120,00" step="0.01" name="valor-venda" value=<?php if($produto_req) echo $produto_req["valor_venda"];?> required>
                    </div>

                    <div class="info">
                        <label for="valor-custo">Valor de custo</label>
                        <input type="number" id="valor-custo" placeholder="R$ 100,00" step="0.01" name="valor-custo" value=<?php if($produto_req) echo $produto_req["valor_custo"];?> required>
                    </div>

                    <div class="info">
                        <label for="tamanho-produto">Tamanho do produto</label>
                        <input type="number" id="tamanho-produto" step="0.01" name="tamanho-produto" value=<?php if($produto_req) echo $produto_req["tamanho"];?>>
                    </div>

                    <div class="info">
                        <label for="fornecedor-produto">Fornecedor</label>
                        <input type="text" id="fornecedor-produto" name="fornecedor-produto" value='<?php if($produto_req) echo $produto_req["fornecedor"];?>' required>
                    </div>

                    <div class="info">
                        <label for="categoria-produto">Categoria (opcional)</label>
                        <select id="categoria-produto" name="categoria-produto">
                            <option value="default">Selecione uma categoria</option>
                        </select>
                    </div>

                    <div class="info">
                        <?php
                            if($produto_req && $produto_req["imagem"] != "(Sem imagem)") {
                                $imagem = $produto_req["imagem"];
                                $path = "../imagens/$imagem";
                            }
                        ?>
                        <img id="imagem-produto" src='<?php echo $path; ?>' alt="imagem do produto" width="150px" height="150px">
                        <label for="carregar-imagem-produto">Carregar imagem do produto (opcional)</label>
                        <input type="file" id="carregar-imagem-produto" name="imagem-produto" accept="image/png, image/jpeg">
                    </div>

                    <div class="info">
                        <label for="observacoes">Observa????es</label>
                        <textarea id="observacoes" name="observacoes" value='<?php if($produto_req) echo $produto_req["obs"];?>'></textarea>
                    </div>
                    
                    <div class="botoes-container">
                        <button class="botao-rosa">Salvar</button>
                        <button form="" onclick="location = 'produtos.php';">Cancelar</button>
                    </div>
                </form>
            </div>
            

        </div>
    </main>

</body>
</html>