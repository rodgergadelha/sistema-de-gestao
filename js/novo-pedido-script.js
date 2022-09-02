window.addEventListener("DOMContentLoaded", (event) => {
    let produtosLinhas = document.getElementById("produtos-section").getElementsByClassName("row");
    let linhaHTMLpadrao = produtosLinhas[0].innerHTML;
    let adicionarProduto = document.getElementById("adicionar-produto");
    let primeiraLinhaProdutosSection = produtosLinhas[0];
    let qtdInputPrimeiraLinha = primeiraLinhaProdutosSection.getElementsByClassName("quantidade-produto")[0];
    let valorUnitinputPrimeiraLinha = primeiraLinhaProdutosSection.getElementsByClassName("valor-unit-produto")[0];
    let valorTotalPrimeiraLinha = primeiraLinhaProdutosSection.getElementsByClassName("valor-total-produto")[0];
    let antigaOpcaoEscolhida;

    // Adicionando listeners para os inputs numéricos
    valorUnitinputPrimeiraLinha.addEventListener("input", ()=>{
        valorTotalPrimeiraLinha.value = valorUnitinputPrimeiraLinha.value * qtdInputPrimeiraLinha.value;
    });
    qtdInputPrimeiraLinha.addEventListener("input", ()=>{
        valorTotalPrimeiraLinha.value = valorUnitinputPrimeiraLinha.value * qtdInputPrimeiraLinha.value;
    });

    // Adicinando ações à primeira linha logo após o carregamento da página
    let produtoLinha = produtosLinhas[0];
    let linhaSelect = produtoLinha.getElementsByTagName("select")[0];
    let opcaoEscolhida = linhaSelect.options[linhaSelect.selectedIndex];
    let qtdMaxima = opcaoEscolhida.getAttribute("qtdmaxima");
    let qtdInput = produtoLinha.getElementsByClassName("quantidade-produto")[0];
    qtdInput.max = qtdMaxima;

    linhaSelect.addEventListener("focus", () => {
        antigaOpcaoEscolhida = linhaSelect.options[linhaSelect.selectedIndex];
    });

    linhaSelect.addEventListener("change", () => {
        let opcaoEscolhida = linhaSelect.options[linhaSelect.selectedIndex];
        let qtdMaxima = opcaoEscolhida.getAttribute("qtdmaxima");
        let qtdInput = produtoLinha.getElementsByClassName("quantidade-produto")[0];
        qtdInput.value = "1";
        qtdInput.max = qtdMaxima;
        
        adicionarOpcaoAsOutrasLinhas(antigaOpcaoEscolhida);
        removerOpcaoDasOutrasLinhas(linhaSelect.options[linhaSelect.selectedIndex]);
    });

    produtoLinha.getElementsByTagName("button")[0].addEventListener("click", () => {
        let opcaoEscolhidaLinhaSelect = linhaSelect.options[linhaSelect.selectedIndex];
        adicionarOpcaoAsOutrasLinhas(opcaoEscolhidaLinhaSelect);

        document.getElementById("produtos-section").removeChild(produtoLinha);
    });


    // Evento disparado ao se adicionar um novo produto ao pedido
    adicionarProduto.addEventListener("click", () => {
        if(document.getElementById("produtos-section").getElementsByTagName("select").length > 0
        && document.getElementById("produtos-section").getElementsByTagName("select")[0].options.length == 1)
            return;

        let novaLinha = document.createElement("div");
        novaLinha.setAttribute("class", "row");
        novaLinha.innerHTML = linhaHTMLpadrao;

        // Adicionando event listeners: se a opção escolhida mudar, a antiga será adicionada
        // aos outros selects e a nova será retirada dos outros selects
        let novaLinhaSelect = novaLinha.getElementsByTagName("select")[0];

        novaLinhaSelect.addEventListener("focus", () => {
            antigaOpcaoEscolhida = novaLinhaSelect.options[novaLinhaSelect.selectedIndex];
        });
    
        novaLinhaSelect.addEventListener("change", () => {
            let opcaoEscolhida = novaLinhaSelect.options[novaLinhaSelect.selectedIndex];
            let qtdMaxima = opcaoEscolhida.getAttribute("qtdmaxima");
            let qtdInput = novaLinha.getElementsByClassName("quantidade-produto")[0];
            qtdInput.value = "1";
            qtdInput.max = qtdMaxima;
            
            adicionarOpcaoAsOutrasLinhas(antigaOpcaoEscolhida);
            removerOpcaoDasOutrasLinhas(novaLinhaSelect.options[novaLinhaSelect.selectedIndex]);
        });

        // Adicionando evento de remoção de linhas
        novaLinha.getElementsByTagName("button")[0].addEventListener("click", () => {
            let opcaoEscolhidaNovaLinha = novaLinhaSelect.options[novaLinhaSelect.selectedIndex];
            adicionarOpcaoAsOutrasLinhas(opcaoEscolhidaNovaLinha);
            document.getElementById("produtos-section").removeChild(novaLinha);
        });

        // Adicionando listeners para os inputs numéricos da nova linha
        let qtdInputNovaLinha = novaLinha.getElementsByClassName("quantidade-produto")[0];
        let valorUnitinputNovaLinha = novaLinha.getElementsByClassName("valor-unit-produto")[0];
        let valorTotalNovaLinha = novaLinha.getElementsByClassName("valor-total-produto")[0];

        // Funções que mudam o campo 'valor total' caso os campos de quantidade e valor unitário mudem
        valorUnitinputNovaLinha.addEventListener("input", ()=>{
            valorTotalNovaLinha.value = valorUnitinputNovaLinha.value * qtdInputNovaLinha.value;
        });
        qtdInputNovaLinha.addEventListener("input", ()=>{
            valorTotalNovaLinha.value = valorUnitinputNovaLinha.value * qtdInputNovaLinha.value;
        });

        retirarOpcoesUsadas(novaLinhaSelect);
        removerOpcaoDasOutrasLinhas(novaLinhaSelect.options[novaLinhaSelect.selectedIndex]);

        // Mudando a quantidade máxima do produto nessa linha
        let opcaoEscolhida = novaLinhaSelect.options[novaLinhaSelect.selectedIndex];
        let qtdMaxima = opcaoEscolhida.getAttribute("qtdmaxima");
        let qtdInput = novaLinha.getElementsByClassName("quantidade-produto")[0];
        qtdInput.max = qtdMaxima;

        // Inserindo nova linha ao site
        adicionarProduto.parentNode.insertAdjacentElement("beforebegin", novaLinha);

    });

    // Função que remove as opções já escolhidas da nova linha a ser adicionada
    function retirarOpcoesUsadas(novaLinhaSelect) {
        let rows = document.getElementById("produtos-section").getElementsByClassName("row");
        let novaLinhaSelectOptions = novaLinhaSelect.getElementsByTagName("option");
        
        for(let row of rows) {
            if(row.getElementsByTagName("span")[0]) continue;

            let rowSelect = row.getElementsByTagName("select")[0];
            if(rowSelect == novaLinhaSelect) continue;
            let rowSelectedOption = rowSelect.options[rowSelect.selectedIndex];
            
            for(let i = 0; i < novaLinhaSelectOptions.length; i++) {
                if(novaLinhaSelectOptions[i].value == rowSelectedOption.value) {
                    novaLinhaSelect.removeChild(novaLinhaSelectOptions[i]);
                }
            }
        }
    }

    // Função que remove uma opção específica das outras linhas
    function removerOpcaoDasOutrasLinhas(opcao) {
        let rows = document.getElementById("produtos-section").getElementsByClassName("row");
        
        for(let row of rows) {
            if(row.getElementsByTagName("span")[0]) continue;

            let rowSelect = row.getElementsByTagName("select")[0];
            if(rowSelect == opcao.parentNode) continue;
            let rowSelectOptions = rowSelect.getElementsByTagName("option");
            
            for(let i = 0; i < rowSelectOptions.length; i++) {
                if(rowSelectOptions[i].value == opcao.value) {
                    rowSelect.removeChild(rowSelectOptions[i]);
                    break;
                }
            }
        }
    }

    // Função que adiciona uma opção específica às outras linhas
    function adicionarOpcaoAsOutrasLinhas(opcao) {
        let rows = document.getElementById("produtos-section").getElementsByClassName("row");
        
        for(let row of rows) {
            if(row.getElementsByTagName("span")[0]) continue;

            let rowSelect = row.getElementsByTagName("select")[0];
            
            if(rowSelect != opcao.parentNode) {
                let opcaoClone = document.createElement("option");
                opcaoClone.innerText = opcao.value;
                opcaoClone.value = opcao.value;
                opcaoClone.setAttribute("qtdmaxima", opcao.getAttribute("qtdmaxima"));

                let rowSelectOptions = rowSelect.getElementsByTagName("option");
                let podeAdicionar = true;

                for(let i = 0; i < rowSelectOptions.length; i++) {
                    if(rowSelectOptions[i].value == opcao.value) {
                        podeAdicionar = false;
                        break;
                    }
                }
                
                if(podeAdicionar) rowSelect.appendChild(opcaoClone);
            }
        }
    }

});