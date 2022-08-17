window.addEventListener("DOMContentLoaded", (event) => {
    let fluxoData = document.getElementById("fluxo-data");

    fluxoData.addEventListener("change", () => {
        document.getElementById("date-form").submit();
    }, false);
});