window.addEventListener("DOMContentLoaded", (event) => {
    let produtosSection = document.getElementById("produtos-section");
    let produtoInfoRow = produtosSection.getElementsByClassName("row")[0];
    let produtoInfoRowHTML = produtoInfoRow.innerHTML;
    let addProdutoSpan = document.getElementById("adicionar-produto");
    let removerProdutoButton = produtoInfoRow.getElementsByTagName("button")[0];
    let rows = produtosSection.getElementsByClassName("row");

    addProdutoSpan.addEventListener("click", () => {
        let novaLinha = document.createElement("div");
        novaLinha.setAttribute("class", "row");
        novaLinha.innerHTML = produtoInfoRowHTML;

        if(rows.length == 1) {
            rows[0].insertAdjacentElement("beforebegin", novaLinha);
        } else {
            rows[rows.length-2].insertAdjacentElement("beforebegin", novaLinha);
        }

        novaLinha.getElementsByTagName("button")[0].addEventListener("click", () => {
            produtosSection.removeChild(novaLinha);
        }, false);
    }, false);


    removerProdutoButton.addEventListener("click", () => {
        produtosSection.removeChild(produtoInfoRow);
    }, false);

});