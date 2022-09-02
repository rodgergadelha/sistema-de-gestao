window.addEventListener("DOMContentLoaded", (event) => {
     let valorFrete = document.getElementById("valor-frete");
     let valorDesconto = document.getElementById("valor-desconto");
     let valorTotalPedido = document.getElementById("valor-total-pedido");
     let valoresProdutos = document.getElementById("valor-produtos");
     let adicionarProduto = document.getElementById("adicionar-produto");
     let produtosSection = document.getElementById("produtos-section");
     let qtdPrimeiroProduto = document.getElementsByClassName("quantidade-produto")[0];
     let valorUnitPrimeiroProduto = document.getElementsByClassName("valor-unit-produto")[0];

     function atualizarValoresProdutos() {
          let valoresTotaisProdutos = produtosSection.getElementsByClassName("valor-total-produto");
          valoresProdutos.value = 0;

          for(let valorTotalProduto of valoresTotaisProdutos) {
               valoresProdutos.value = parseFloat(valoresProdutos.value) + parseFloat(valorTotalProduto.value);
          }

          valorTotalPedido.value = parseFloat(valoresProdutos.value) + parseFloat(valorFrete.value) - parseFloat(valorDesconto.value);
     }

     qtdPrimeiroProduto.addEventListener("input", atualizarValoresProdutos);
     valorUnitPrimeiroProduto.addEventListener("input", atualizarValoresProdutos);
     valorFrete.addEventListener("input", atualizarValoresProdutos);
     valorDesconto.addEventListener("input", atualizarValoresProdutos);

     produtosSection.getElementsByClassName("row")[0].getElementsByTagName("button")[0].addEventListener("click", atualizarValoresProdutos);

     adicionarProduto.addEventListener("click", ()=>{
          let rows = produtosSection.getElementsByClassName("row");
          let novaLinha = rows[rows.length - 2];
          let qtdProduto = novaLinha.getElementsByClassName("quantidade-produto")[0];
          let valorUnit = novaLinha.getElementsByClassName("valor-unit-produto")[0];

          qtdProduto.addEventListener("input", atualizarValoresProdutos);
          valorUnit.addEventListener("input", atualizarValoresProdutos);
          rows[rows.length-2].getElementsByTagName("button")[0].addEventListener("click", atualizarValoresProdutos);
     });

});