window.addEventListener("DOMContentLoaded", (event) => {
    let superCheckbox = document.getElementById("super-checkbox");

    superCheckbox.addEventListener('change', () => {
        for(checkbox of document.getElementsByName("checkbox[]")) {
            // Marcando apenas as checkboxes que aparecem ao usuário
            if(checkbox.parentNode.parentNode.style.display != "none") checkbox.checked = superCheckbox.checked;
        }
    }, false);

});