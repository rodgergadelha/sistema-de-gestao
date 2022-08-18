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
    <title>Cadastro de produtos</title>
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
            <h2>Novo produto</h2>

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
                        <label for="codigo-produto">Código do produto</label>
                        <input type="text" id="codigo-produto" placeholder="PD0001" name="codigo-produto" value='<?php if($produto_req) echo $produto_req["codigo"];?>' required>
                    </div>

                   <div class="info">
                        <label for="unidade-produto">Unidade</label>
                        <input type="number" id="unidade-produto" placeholder="Ex: Pç, Kg, Un" name="unidade-produto" value=<?php if($produto_req) echo $produto_req["unidade"];?> required>
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
                        <label for="carregar-imagem-produto">Carregar imagem do produto (opcional)</label>
                        <input type="file" id="carregar-imagem-produto" name="imagem-produto">
                    </div>

                    <div class="info">
                        <label for="observacoes">Observações</label>
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