<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Atividades - EURO CONSULTORIA</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/nav.css">
</head>
<body onload="adicionarRequerente()">
    <?php include "assets/navbar.php" ?>

    <div class="container">
        <header class="header">
            <img src="assets/img/Logo01.png" alt="Logo EURO CONSULTORIA" style="width: 120px;" class="logo">
            <h1>EURO CONSULTORIA - Controle de Atividades</h1>
        </header>

        <label for="activityType">Escolha o tipo de atividade:</label>
        <select id="activityType" name="activityType" form="activityForm">
            <option value="lembrete">Lembrete</option>
            <option value="apresentacao">Apresentação nas Famílias</option>
            <option value="negociacao">Negociação com Clientes</option>
            <option value="aditivo">Aditivo</option>
        </select>

        <button onclick="showForm()">AVANÇAR</button>

        <!-- Formulário de Lembrete -->
        <div id="lembreteForm" class="form">
            <h2>Cadastro de Lembrete</h2>
            <form method="POST" action="process/processa_dados.php">
                <input type="text" name="familia" placeholder="Nome da Família" required>
                <div id="requerentes">
                    <div class="requerente">
                        <input type="text" name="requerente[]" placeholder="Nome do Requerente" required>
                    </div>
                </div>
                <button type="button" onclick="adicionarRequerente()">Adicionar mais requerente</button><br><br>
                <label for="data_lembrete">Data do Lembrete</label>
                <input type="date" id="data_lembrete" name="data_lembrete" required>
                <label for="data_pagamento">Data do Pagamento</label>
                <input type="date" id="data_pagamento" name="data_pagamento" placeholder="Data de Pagamento (opcional)">
                <button type="submit" name="action" value="lembrete">Cadastrar Lembrete</button>
            </form>
        </div>

        <!-- Outros Formulários -->
        <div id="apresentacaoForm" class="form">
            <h2>Cadastro de Apresentação nas Famílias</h2>
            <form method="POST" action="https://euro.infinityfreeapp.com/processa_dados.php">
                <input type="text" name="familia" placeholder="Nome da Família" required>
                <input type="date" name="data_apresentacao" required>
                <button type="submit" name="action" value="apresentacao">Cadastrar Apresentação</button>
            </form>
        </div>

        <div id="negociacaoForm" class="form">
            <h2>Cadastro de Negociação com Clientes</h2>
            <form method="POST" action="https://euro.infinityfreeapp.com/processa_dados.php">
                <input type="text" name="familia" placeholder="Nome da Família" required>
                <input type="number" name="valor_acordado" placeholder="Valor Acordado" required>
                <input type="date" name="data_negociacao" required>
                <input type="text" name="tipo_negociacao" placeholder="Tipo de Negociação" required>
                <textarea name="descricao" placeholder="O que foi acordado" required></textarea>
                <button type="submit" name="action" value="negociacao">Cadastrar Negociação</button>
            </form>
        </div>

        <div id="aditivoForm" class="form">
            <h2>Cadastro de Aditivo</h2>
            <form method="POST" action="https://euro.infinityfreeapp.com/processa_dados.php">
                <input type="text" name="familia" placeholder="Nome da Família" required>
                <input type="date" name="data_negociacao" required>
                <textarea name="descricao" placeholder="Descrição do Aditivo" required></textarea>
                <input type="number" name="valor_acordado" placeholder="Valor Acordado" required>
                <button type="submit" name="action" value="aditivo">Cadastrar Aditivo</button>
            </form>
        </div>
    </div>

  
    <script > 
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
    </script>
    
</body>

</html>
