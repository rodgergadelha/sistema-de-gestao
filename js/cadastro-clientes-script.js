window.addEventListener("DOMContentLoaded", (event) => {
    let pessoaFisicaForm = document.getElementById("clientes-form");
    let pessoaJuridicaForm = document.getElementById("clientes-juridicos-form");
    let selectCategoriaPessoa = pessoaFisicaForm.querySelector("#categoria-pessoa");
    let selectCategoriaPessoaContainer = pessoaFisicaForm.querySelector(".info");

    // Após carregamento da página
    let categoriaSelecionada = selectCategoriaPessoa.options[selectCategoriaPessoa.selectedIndex].value;

    if(categoriaSelecionada == "Pessoa Física") {
        pessoaFisicaForm.insertAdjacentElement("afterbegin", selectCategoriaPessoaContainer);
        pessoaFisicaForm.style.display = "block";
        pessoaJuridicaForm.style.display = "none";
    }else if(categoriaSelecionada == "Pessoa Jurídica"){
        pessoaJuridicaForm.insertAdjacentElement("afterbegin", selectCategoriaPessoaContainer);
        pessoaFisicaForm.style.display = "none";
        pessoaJuridicaForm.style.display = "block";
    }

    // Após mudança de categoria
    selectCategoriaPessoa.addEventListener("change", () => {
        let categoriaSelecionada = selectCategoriaPessoa.options[selectCategoriaPessoa.selectedIndex].value;

        if(categoriaSelecionada == "Pessoa Física") {
            pessoaFisicaForm.insertAdjacentElement("afterbegin", selectCategoriaPessoaContainer);
            pessoaFisicaForm.style.display = "block";
            pessoaJuridicaForm.style.display = "none";
        }else {
            pessoaJuridicaForm.insertAdjacentElement("afterbegin", selectCategoriaPessoaContainer);
            pessoaFisicaForm.style.display = "none";
            pessoaJuridicaForm.style.display = "block";
        }
    }, false);

});