<!-- Conectando-se com o banco de dados e obtendo dados dos clientes -->
<?php
    include_once "../process-forms/conexao.php";

    // Obtendo todas as linhas da tabela cliente
    $sql = "SELECT  * FROM cliente";

    //Fazendo query e obtendo resultados
    $result = mysqli_query($conn, $sql);

    // Salvando linhas da tabela 'clientes' como um array
    $clientes = array_reverse(mysqli_fetch_all($result, MYSQLI_ASSOC));

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
    <title>Clientes</title>
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
            <h2>Clientes</h2>

            <div class="opcoes-container">
                <div class="botoes-container">
                    <button onclick="location = 'cadastro-clientes.html';" class="adicionar-cliente botao-rosa">Cadastrar cliente</button>
                    <button class="gerar-relatorio">Gerar planilha de clientes</button>
                    <button class="excluir-cliente">Excluir cliente</button>
                </div>
    
                <input class="pesquisar-cliente pesquisar" type="text" placeholder="Pesquisar">
            </div>

            <table id="clientes-table">
                <tr>
                    <th class="primeira-linha checkbox-column"><input type="checkbox"></th>
                    <th class="primeira-linha">N°</th>
                    <th class="primeira-linha">Nome</th>
                    <th class="primeira-linha">CPF/CNPJ</th>
                    <th class="primeira-linha">Telefone</th>
                    <th class="primeira-linha">Tipo</th>
                </tr>

                <?php foreach ($clientes as $cliente) { ?>
                    <tr>
                        <th class="checkbox-column"><input type="checkbox"></th>
                        <th><?php echo htmlspecialchars($cliente["id"]) ?></th>
                        <th><?php echo htmlspecialchars($cliente["nome"]) ?></th>
                        <th><?php echo htmlspecialchars($cliente["cpf"]) ?></th>
                        <th><?php echo htmlspecialchars($cliente["telefone"]) ?></th>
                        <th><?php echo htmlspecialchars($cliente["categoria"]) ?></th>
                    </tr>
                <?php } ?>
            </table>

        </div>
    </main>

</body>
</html>