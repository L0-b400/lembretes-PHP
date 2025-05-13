<!-- Navbar -->
    <nav>
      <div class="logo">
        <a href="#"><img src="Logo01.png" alt="logo" /></a>
        <a href="#"><h1>Euro Consultoria</h1></a>
      </div>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="consulta.php">Consulta</a></li>
        <li><a href="#">Main</a></li>
        <li><a href="https://wa.me/5551996811385" target="_blank">Fale conosco pelo WhatsApp</a></li>
      </ul>
      <div class="hamburger">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
      </div>
    </nav>

    <div class="menubar">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="consulta.php">Consulta</a></li>
        <li><a href="#">Main</a></li>
        <li><a href="https://wa.me/5551996811385" target="_blank">Fale conosco pelo WhatsApp</a></li>
      </ul>
    </div>

<script>
    const hamburger = document.querySelector('.hamburger');
    const menubar = document.querySelector('.menubar');

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('hamburger-active');
        menubar.classList.toggle('active');
    });
</script>
