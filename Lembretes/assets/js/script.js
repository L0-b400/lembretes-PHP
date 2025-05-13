// Script para abrir e fechar o menu na versão mobile
const menuToggle = document.getElementById('menu-toggle');
const navLinks = document.querySelector('.nav-links');

if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}

const mobileNav = document.querySelector(".hamburger");
const navbar = document.querySelector(".menubar");

if (mobileNav && navbar) {
    const toggleNav = () => {
        navbar.classList.toggle("active");
        mobileNav.classList.toggle("hamburger-active");
    };

    mobileNav.addEventListener("click", toggleNav);
}

const hamburger = document.querySelector('.hamburger');
    const menubar = document.querySelector('.menubar');

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('hamburger-active');
        menubar.classList.toggle('active');
    });