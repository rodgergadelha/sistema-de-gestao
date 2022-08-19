window.addEventListener("DOMContentLoaded", (event) => {
    let superCheckbox = document.getElementById("super-checkbox");

    superCheckbox.addEventListener('change', () => {
        for(checkbox of document.getElementsByName("checkbox[]")) {
            checkbox.checked = superCheckbox.checked;
        }
    }, false);

});