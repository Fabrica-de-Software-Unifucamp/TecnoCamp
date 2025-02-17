document.addEventListener("DOMContentLoaded", function () {
    var infoModal = document.getElementById("infoModal");
    var formModal = document.getElementById("formModal");

    var btnInfo = document.getElementById("openModalBtn");
    var btnForm = document.getElementById("openFormModal");

    var closeInfo = document.querySelector(".close-info");
    var closeForm = document.querySelector(".close-form");

    btnInfo.onclick = function () { infoModal.style.display = "flex"; };
    btnForm.onclick = function () { formModal.style.display = "flex"; };

    closeInfo.onclick = function () { infoModal.style.display = "none"; };
    closeForm.onclick = function () { formModal.style.display = "none"; };

    window.onclick = function (event) {
        if (event.target == infoModal) infoModal.style.display = "none";
        if (event.target == formModal) formModal.style.display = "none";
    };

    document.getElementById("cpf").addEventListener("input", function (e) {
        var valor = e.target.value.replace(/\D/g, "");
        if (valor.length > 3) valor = valor.replace(/^(\d{3})(\d)/, "$1.$2");
        if (valor.length > 6) valor = valor.replace(/(\d{3})\.(\d{3})(\d)/, "$1.$2.$3");
        if (valor.length > 9) valor = valor.replace(/(\d{3})\.(\d{3})\.(\d{3})(\d)/, "$1.$2.$3-$4");
        e.target.value = valor;
    });

    document.getElementById("formulario").addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = {
            nome: document.getElementById("nome").value,
            email: document.getElementById("email").value,
            endereco: document.getElementById("endereco").value,
            cpf: document.getElementById("cpf").value,
            data_nascimento: document.getElementById("data_nascimento").value,
            telefone: document.getElementById("telefone").value,
            escola: document.getElementById("escola") ? document.getElementById("escola").value : null
        };

        fetch("http://192.168.10.149:9090/index.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            alert("Dados enviados com sucesso!");
            formModal.style.display = "none";
        })
        .catch(error => {
            alert("Erro ao enviar os dados!");
            console.error("Error:", error);
        });
    });
});
