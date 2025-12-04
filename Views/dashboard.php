<?php if($_SESSION['role'] === 'admin'){
    header('Location: /admin');
    die;
}?> 

<script src="/Assets/dashboard.js"> </script>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Notes CRUD</title>

    <link href="/Assets/style.css" rel="stylesheet" type="text/css">
    
</head>
<body class="dashboard-page">
    
    <div class="profile-container">
        <div class="profile-avatar">
            👤
        </div>
    </div>
    
    <div class="container">
        <h2>Minhas Notas</h2>

        <div class="editor-card">
            <div class="input-group">
                <input type="text" id="noteTitle" placeholder="Título da nota...">
                <textarea id="noteContent" placeholder="Escreva sua nota aqui..."></textarea>
            </div>
            <div class="actions">
                <button class="btn-save" id="saveBtn" onclick="handleForm()">Salvar Nota</button>
            </div>
        </div>

        <div id="notesList" class="notes-list">
            </div>
    </div>

    <div id="viewModal" class="modal-overlay" onclick="closeModal(event)">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal(event, true)">&times;</span>
            <div class="modal-header">
                <h3 id="modalTitle">Título da Nota</h3>
            </div>
            <div class="modal-body" id="modalBody">
                Conteúdo...
            </div>
        </div>
    </div>

</body>
</html>