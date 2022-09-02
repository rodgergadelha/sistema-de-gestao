window.addEventListener("DOMContentLoaded", (event) => {
    let container = document.getElementsByClassName("container")[0];
    let table = document.getElementsByTagName("table")[0];
    let searchInput = document.getElementsByClassName("pesquisar")[0];

    container.style.height = container.offsetHeight+"px";

    searchInput.addEventListener("keyup", () => {
        search(searchInput, table);
    });

    function search(input, ul) {
        let filter, li, i, txtValue, codeValue;
        filter = input.value.toUpperCase();
        li = ul.getElementsByTagName("tr");
        
        for (i = 1; i < li.length; i++) {
            txtValue = li[i].textContent || li[i].innerText;
            
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            }else {
                li[i].style.display = "none";
            }
        }

    }

});