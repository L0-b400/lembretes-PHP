    const mobileNav = document.querySelector(".hamburger");
    const navbar = document.querySelector(".menubar");

    const toggleNav = () => {
    navbar.classList.toggle("active");
    mobileNav.classList.toggle("hamburger-active");
    };
    mobileNav.addEventListener("click", () => toggleNav());

    const hamburger = document.querySelector('.hamburger');
    const menubar = document.querySelector('.menubar');

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('hamburger-active');
        menubar.classList.toggle('active');
    });

 function adicionarRequerente() {
            var div = document.createElement("div");
            div.classList.add("requerente");
            div.innerHTML = '<input type="text" name="requerente[]" placeholder="Nome do Requerente" required>';
            div.innerHTML += '<a onclick="removerRequerente(this)" style="color: red; font-size: 12px; cursor: pointer;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'">Excluir</a>';
            document.getElementById("requerentes").appendChild(div);
        }

        function removerRequerente(button) {
            button.parentNode.remove();
        }

function showForm() {
    var activityType = document.getElementById('activityType').value;
    var forms = document.querySelectorAll('.form');
    forms.forEach(function(form) {
        form.style.display = 'none';
    });

    var formToShow = document.getElementById(activityType + 'Form');
    if (formToShow) {
        formToShow.style.display = 'block';
    }
}