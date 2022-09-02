window.addEventListener("DOMContentLoaded", (event) => {
    let produtosLinhas = document.getElementById("produtos-section").getElementsByClassName("row");
    let linhaHTMLpadrao = produtosLinhas[0].innerHTML;
    let adicionarProduto = document.getElementById("adicionar-produto");
    let primeiraLinhaProdutosSection = produtosLinhas[0];
    let qtdInputPrimeiraLinha = primeiraLinhaProdutosSection.getElementsByClassName("quantidade-produto")[0];
    let valorUnitinputPrimeiraLinha = primeiraLinhaProdutosSection.getElementsByClassName("valor-unit-produto")[0];
    let valorTotalPrimeiraLinha = primeiraLinhaProdutosSection.getElementsByClassName("valor-total-produto")[0];
    let antigaOpcaoEscolhida;
    let ultimoInputModificado = null;

    // Adicionando listeners para os inputs numéricos
    valorUnitinputPrimeiraLinha.addEventListener("input", ()=>{
        valorTotalPrimeiraLinha.value = valorUnitinputPrimeiraLinha.value * qtdInputPrimeiraLinha.value;
    });
    qtdInputPrimeiraLinha.addEventListener("input", ()=>{
        valorTotalPrimeiraLinha.value = valorUnitinputPrimeiraLinha.value * qtdInputPrimeiraLinha.value;
    });


    // Event listeners para o input do nome do cliente
    let nomeClienteInput = document.getElementById("nome-cliente");
    let nomesClientesUl = document.getElementsByClassName("lista-nomes")[0];
    let listaNomesClientes = nomesClientesUl.getElementsByTagName("li");

    for(let nomeClienteLi of listaNomesClientes) {
        nomeClienteLi.addEventListener("click", () => {
            nomeClienteInput.value = nomeClienteLi.innerText;
        });
    }

    nomeClienteInput.addEventListener("keyup", () => {
        search(nomeClienteInput, nomesClientesUl);
    });


    // Event listeners para os inputs dos nomes dos produtos
    let nomeProdutoInput = document.getElementsByClassName("nome-produto")[0];
    let nomesProdutosUl = document.getElementsByClassName("lista-nomes")[1];
    let listaNomesProdutos = nomesProdutosUl.getElementsByTagName("li");
    let qtdMaxima = listaNomesProdutos[0].getAttribute("qtdmaxima");
    let qtdInput = document.getElementsByClassName("quantidade-produto")[0];
    qtdInput.max = qtdMaxima;

    for(let nomeProdutoLi of listaNomesProdutos) {
        nomeProdutoLi.addEventListener("click", () => {
            nomeProdutoInput.value = nomeProdutoLi.innerText;
            nomeProdutoInput.setAttribute("qtdmaxima", nomeProdutoLi.getAttribute("qtdmaxima"));
            nomeProdutoInput.setAttribute("liid", nomeProdutoLi.id);
            
            for(let li of listaNomesProdutos) {
                li.style.display = "none";
            }
        });
    }

    nomeProdutoInput.addEventListener("focus", () => {
        antigaOpcaoEscolhida = null;

        for(let nomeProdutoLi of listaNomesProdutos) {
            if(nomeProdutoLi.id == nomeProdutoInput.getAttribute("liid")) {
                antigaOpcaoEscolhida = nomeProdutoLi;
                break;
            }
        }
    });

    nomeProdutoInput.addEventListener("change", ()=>{
        let qtdMaxima = nomeProdutoInput.getAttribute("qtdmaxima");
        let qtdInput = document.getElementsByClassName("quantidade-produto")[0];
        qtdInput.value = "1";
        qtdInput.setAttribute("max", qtdMaxima);
        ultimoInputModificado = nomeProdutoInput;
    });
    
    window.addEventListener("click", () => {
        let produtoExiste = false;
        let listaNomesProdutos = document.getElementById("produtos-section").getElementsByTagName("li");

        for(let nomeProdutoLi of listaNomesProdutos) {
            if(ultimoInputModificado && nomeProdutoLi.innerText == ultimoInputModificado.value) {
                produtoExiste = true;
                ultimoInputModificado.setAttribute("qtdmaxima", nomeProdutoLi.getAttribute("qtdmaxima"));
                ultimoInputModificado.setAttribute("liid", nomeProdutoLi.id);
                let ultimoInputModificadoRow = ultimoInputModificado.parentNode.parentNode;
                let qtdInput = ultimoInputModificadoRow.getElementsByClassName("quantidade-produto")[0];
                qtdInput.value = "1";
                qtdInput.setAttribute("max", nomeProdutoLi.getAttribute("qtdmaxima"));
                removerOpcaoDasOutrasLinhas(ultimoInputModificadoRow);
            }

            nomeProdutoLi.style.display = "none";
            
        }

        if(ultimoInputModificado && !produtoExiste && ultimoInputModificado.value != "") {
            alert("Produto não cadastrado!");
            ultimoInputModificado.value = "";
            ultimoInputModificado.setAttribute("liid", "none");
        }
        
        for(let nomeClienteLi of listaNomesClientes) {
            nomeClienteLi.style.display = "none";
        }

        if(antigaOpcaoEscolhida && ultimoInputModificado &&
        (antigaOpcaoEscolhida.getAttribute("id") != ultimoInputModificado.getAttribute("liid")
        || ultimoInputModificado.value == "")){
            adicionarOpcaoAsOutrasLinhas(antigaOpcaoEscolhida);
        }

        ultimoInputModificado = null;
        
    });

    nomeProdutoInput.addEventListener("keyup", () => {
        search(nomeProdutoInput, nomesProdutosUl);
    });

    let primeiraLinhaProdutos = produtosLinhas[0];
    primeiraLinhaProdutos.getElementsByTagName("button")[0].addEventListener("click", () => {
        let inputNomePrimeiraLinha = primeiraLinhaProdutos.getElementsByClassName("nome-produto")[0];
        let opcaoEscolhidaPrimeiraLinha = null;
        
        for(let nomeProdutoLi of listaNomesProdutos) {
            if(nomeProdutoLi.id == inputNomePrimeiraLinha.getAttribute("liid")) {
                opcaoEscolhidaPrimeiraLinha = nomeProdutoLi;
                break;
            }
        }

        if(opcaoEscolhidaPrimeiraLinha) adicionarOpcaoAsOutrasLinhas(opcaoEscolhidaPrimeiraLinha);

        document.getElementById("produtos-section").removeChild(primeiraLinhaProdutos);
    });


    // Evento disparado ao se adicionar um novo produto ao pedido
    adicionarProduto.addEventListener("click", () => {
        let produtosSection = document.getElementById("produtos-section"); 
        if(produtosSection.getElementsByClassName("row").length - 1 == parseInt(produtosSection.getAttribute("qtd"))) return;

        let novaLinha = document.createElement("div");
        novaLinha.setAttribute("class", "row");
        novaLinha.innerHTML = linhaHTMLpadrao;

        // Adicionando event listeners: se a opção escolhida mudar, a antiga será adicionada
        // aos outros selects e a nova será retirada dos outros selects
        let novaLinhaNomeInput = novaLinha.getElementsByClassName("nome-produto")[0];


        novaLinhaNomeInput.addEventListener("focus", () => {
            antigaOpcaoEscolhida = null;

            for(let nomeProdutoLi of novaLinha.getElementsByTagName("li")) {
                if(nomeProdutoLi.id == novaLinhaNomeInput.getAttribute("liid")) {
                    antigaOpcaoEscolhida = nomeProdutoLi;
                    break;
                }
            }
        });
    
        novaLinhaNomeInput.addEventListener("change", ()=>{
            let qtdMaxima = novaLinhaNomeInput.getAttribute("qtdmaxima");
            let qtdInput = novaLinha.getElementsByClassName("quantidade-produto")[0];
            qtdInput.value = "1";
            qtdInput.setAttribute("max", qtdMaxima);
            ultimoInputModificado = novaLinhaNomeInput;
        });


        novaLinhaNomeInput.addEventListener("keyup", () => {
            search(novaLinhaNomeInput, novaLinha.getElementsByTagName("ul")[0]);
        });
    
        novaLinha.getElementsByTagName("button")[0].addEventListener("click", () => {
            let opcaoEscolhidaNovaLinha = null;
            
            for(let nomeProdutoLi of novaLinha.getElementsByTagName("li")) {
                if(nomeProdutoLi.id == novaLinhaNomeInput.getAttribute("liid")) {
                    opcaoEscolhidaNovaLinha = nomeProdutoLi;
                    break;
                }
            }
    
            if(opcaoEscolhidaNovaLinha) adicionarOpcaoAsOutrasLinhas(opcaoEscolhidaNovaLinha);
    
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

        retirarOpcoesUsadas(novaLinha);

        // Inserindo nova linha ao site
        adicionarProduto.parentNode.insertAdjacentElement("beforebegin", novaLinha);

        for(let nomeProdutoLi of novaLinha.getElementsByTagName("li")) {
            nomeProdutoLi.addEventListener("click", () => {
                novaLinhaNomeInput.value = nomeProdutoLi.innerText;
                novaLinhaNomeInput.setAttribute("qtdmaxima", nomeProdutoLi.getAttribute("qtdmaxima"));
                novaLinhaNomeInput.setAttribute("liid", nomeProdutoLi.id);

                for(let li of novaLinha.getElementsByTagName("li")) {
                    li.style.display = "none";
                }
            });
        }

    });

    // Função que remove as opções já escolhidas da nova linha a ser adicionada
    function retirarOpcoesUsadas(novaLinha) {
        let rows = document.getElementById("produtos-section").getElementsByClassName("row");
        let novaLinhaLi = novaLinha.getElementsByTagName("li");
        let novaLinhaUl = novaLinha.getElementsByTagName("ul")[0];
        
        for(let row of rows) {
            if(row.getElementsByTagName("span")[0] || row == novaLinha
            || row.getElementsByClassName("nome-produto")[0].value == "") continue;

            let rowNomeInput = row.getElementsByClassName("nome-produto")[0];

            for(let li of novaLinhaLi) {
                if(li.id == rowNomeInput.getAttribute("liid")) {
                    novaLinhaUl.removeChild(li);
                }
            }
        }
    }

    // Função que remove uma opção específica das outras linhas
    function removerOpcaoDasOutrasLinhas(linha) {
        let rows = document.getElementById("produtos-section").getElementsByClassName("row");
        let liid = linha.getElementsByClassName("nome-produto")[0].getAttribute("liid");
        
        for(let row of rows) {
            if(row.getElementsByTagName("span")[0] || row == linha) continue;

            let rowNomesProdutosLista = row.getElementsByTagName("li");
            
            for(let li of rowNomesProdutosLista) {
                if(li.id == liid) {
                    row.getElementsByTagName("ul")[0].removeChild(li);
                    break;
                }
            }
        }
    }

    // Função que adiciona uma opção específica às outras linhas
    function adicionarOpcaoAsOutrasLinhas(li) {
        let rows = document.getElementById("produtos-section").getElementsByClassName("row");
        
        for(let row of rows) {
            if(row.getElementsByTagName("span")[0]) continue;

            let rowProdutoInput = row.getElementsByClassName("nome-produto")[0];
            
            if(rowProdutoInput.getAttribute("liid") != li.id) {
                let opcaoClone = document.createElement("li");
                opcaoClone.innerText = li.innerText;
                opcaoClone.id = li.id;
                opcaoClone.style.display = "none";
                opcaoClone.setAttribute("qtdmaxima", li.getAttribute("qtdmaxima"));
                opcaoClone.setAttribute("codigo", li.getAttribute("codigo"));

                let rowLi = row.getElementsByTagName("li");
                let podeAdicionar = true;

                for(let i = 0; i < rowLi.length; i++) {
                    if(rowLi[i].id == opcaoClone.id) {
                        podeAdicionar = false;
                        break;
                    }
                }
                
                if(podeAdicionar) {
                    opcaoClone.addEventListener("click", () => {
                        rowProdutoInput.value = opcaoClone.innerText;
                        rowProdutoInput.setAttribute("qtdmaxima", opcaoClone.getAttribute("qtdmaxima"));
                        rowProdutoInput.setAttribute("liid", opcaoClone.id);
                        
                        for(let li of document.getElementsByTagName("li")) {
                            li.style.display = "none";
                        }
                    });

                    row.getElementsByTagName("ul")[0].appendChild(opcaoClone);
                }
            }
        }
    }

    function search(input, ul) {
        let filter, li, i, txtValue, codeValue;
        filter = input.value.toUpperCase();
        li = ul.getElementsByTagName("li");
        
        for (i = 0; i < li.length; i++) {
            txtValue = li[i].textContent || li[i].innerText;
            codeValue = li[i].getAttribute("codigo");
            if(codeValue == null) codeValue = "";
            
            if ((codeValue.toUpperCase().indexOf(filter) > -1 || txtValue.toUpperCase().indexOf(filter) > -1) && filter != "") {
                li[i].style.display = "";
            }else {
                li[i].style.display = "none";
            }
        }

    }

});