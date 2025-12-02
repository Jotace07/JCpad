<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Notes CRUD</title>

    <link href="/Assets/style.css" rel="stylesheet" type="text/css">
    
</head>
<body class="dashboard-page">
    <div class="container">
        <h2>Minhas Notas</h2>

        <div class="editor-card">
            <div class="input-group">
                <input type="text" id="noteTitle" placeholder="Título da nota...">
                <textarea id="noteContent" placeholder="Escreva sua nota aqui..."></textarea>
            </div>
            <div class="actions">
                <button class="btn-save" id="saveBtn" onclick="saveNote()">Salvar Nota</button>
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

    <script>
        // --- Estado da Aplicação ---
        let notes = [];
        let editingId = null; // Se não for null, estamos editando

        // Inicializa (carrega do localStorage se quiser persistência, aqui faremos em memória)
        // notes = JSON.parse(localStorage.getItem('myNotes')) || [];
        renderNotes();

        // --- Funções Principais ---

        function saveNote() {
            const titleInput = document.getElementById('noteTitle');
            const contentInput = document.getElementById('noteContent');
            const saveBtn = document.getElementById('saveBtn');

            const title = titleInput.value.trim();
            const content = contentInput.value.trim();

            if (!title || !content) {
                alert("Por favor, preencha o título e o conteúdo.");
                return;
            }

            if (editingId) {
                // Modo Edição
                const noteIndex = notes.findIndex(n => n.id === editingId);
                if (noteIndex > -1) {
                    notes[noteIndex].title = title;
                    notes[noteIndex].content = content;
                }
                editingId = null;
                saveBtn.innerText = "Salvar Nota";
            } else {
                // Modo Criação
                const newNote = {
                    id: Date.now(),
                    title: title,
                    content: content
                };
                notes.push(newNote);
            }

            // Limpa inputs
            titleInput.value = '';
            contentInput.value = '';
            
            renderNotes();
        }

        function renderNotes() {
            const listEl = document.getElementById('notesList');
            listEl.innerHTML = '';

            if (notes.length === 0) {
                listEl.innerHTML = '<p style="text-align:center; color: var(--text-secondary)">Nenhuma nota salva.</p>';
                return;
            }

            notes.forEach(note => {
                const item = document.createElement('div');
                item.className = 'note-item';
                item.innerHTML = `
                    <div class="note-title">${note.title}</div>
                    <div class="menu-container">
                        <button class="kebab-btn" onclick="toggleMenu(${note.id})">⋮</button>
                        <div id="menu-${note.id}" class="dropdown-menu">
                            <div class="dropdown-item" onclick="viewNote(${note.id})">Visualizar</div>
                            <div class="dropdown-item" onclick="editNote(${note.id})">Editar</div>
                            <div class="dropdown-item delete" onclick="deleteNote(${note.id})">Excluir</div>
                        </div>
                    </div>
                `;
                listEl.appendChild(item);
            });
        }

        // --- Ações do Menu ---

        function toggleMenu(id) {
            // Fecha todos os outros menus antes de abrir este
            document.querySelectorAll('.dropdown-menu').forEach(el => {
                if (el.id !== `menu-${id}`) el.classList.remove('show');
            });
            
            const menu = document.getElementById(`menu-${id}`);
            menu.classList.toggle('show');
        }

        // Fechar menus ao clicar fora
        window.onclick = function(event) {
            if (!event.target.matches('.kebab-btn')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
            if (event.target == document.getElementById('viewModal')) {
                closeModal(event, true);
            }
        }

        function viewNote(id) {
            const note = notes.find(n => n.id === id);
            if (note) {
                document.getElementById('modalTitle').innerText = note.title;
                document.getElementById('modalBody').innerText = note.content;
                document.getElementById('viewModal').style.display = 'flex';
            }
        }

        function editNote(id) {
            const note = notes.find(n => n.id === id);
            if (note) {
                document.getElementById('noteTitle').value = note.title;
                document.getElementById('noteContent').value = note.content;
                document.getElementById('noteTitle').focus();
                
                // Configura estado de edição
                editingId = id;
                document.getElementById('saveBtn').innerText = "Atualizar Nota";
                
                // Rola para o topo suavemente
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        function deleteNote(id) {
            if(confirm("Tem certeza que deseja excluir esta nota?")) {
                notes = notes.filter(n => n.id !== id);
                // Se estávamos editando essa nota, cancela a edição
                if (editingId === id) {
                    editingId = null;
                    document.getElementById('saveBtn').innerText = "Salvar Nota";
                    document.getElementById('noteTitle').value = '';
                    document.getElementById('noteContent').value = '';
                }
                renderNotes();
            }
        }

        // --- Modal Utils ---
        function closeModal(event, force = false) {
            if (force || event.target.className === 'modal-overlay') {
                document.getElementById('viewModal').style.display = 'none';
            }
        }

    </script>
</body>
</html>