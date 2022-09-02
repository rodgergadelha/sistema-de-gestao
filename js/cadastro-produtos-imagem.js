window.addEventListener("DOMContentLoaded", (event) => {
    let imagemInput = document.getElementById("carregar-imagem-produto");
    let imagemProduto = document.getElementById("imagem-produto");

    imagemInput.addEventListener("change", () => {
        const [file] = imagemInput.files;
        if(file) {
            imagemProduto.src = URL.createObjectURL(file);
        }
    });
});