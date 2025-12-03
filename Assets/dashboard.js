// --- Estado da Aplicação ---
        let notes = [];
        let oldTitle = ''
        let editing = false;
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
            }else{
                let data = new URLSearchParams()
                data.append(`noteTitle`, title)
                data.append(`noteContent`, content)
                data.append(`saveNote`, true)

                const options = {
                    method: 'POST',
                    body: data
                }
                fetch('/crud', options)
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

            let data = new URLSearchParams()
            data.append(`getNotes`, true)

            const options = {
                method: 'POST',
                body: data
            }
            fetch('/crud', options).then(function (response){
                return response.json();
                
            }).then(function (json){
                    notes = json;
                    
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
                })
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
                document.getElementById('modalBody').innerText = note.note;
                document.getElementById('viewModal').style.display = 'flex';
            }
        }

        function editNote(id) {
            editing = true;
            const note = notes.find(n => n.id === id);
            if (note) {
                oldTitle = note.title;
                document.getElementById('noteTitle').value = note.title;
                document.getElementById('noteContent').value = note.note;
                document.getElementById('noteTitle').focus();
                
                // Configura estado de edição
                editingId = id;
                document.getElementById('saveBtn').innerText = "Atualizar Nota";
                
                // Rola para o topo suavemente
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        function handleForm(){
            if(editing === false){
                saveNote();
            }else{
                const note = notes.find(n => n.id === id);
                document.getElementById('noteTitle').value = note.title;
                document.getElementById('noteContent').value = note.note;

                let data = new URLSearchParams();
                data.appen(`oldTitle`, note.title);
                data.appen(`oldContent`, note.note);
		        data.appen(`newTitle`, newTitle);
		        data.appen(`newNote`, newNote);
                data.append(`editNote`, true);

                const options = {
                    method: 'POST',
                    body: data
                }
                fetch('/crud', options)                
            }
        }

        

        function deleteNote(id) {
            if(confirm("Tem certeza que deseja excluir esta nota?")) {
                const note = notes.find(n => n.id === id);
                // Se estávamos editando essa nota, cancela a edição
                // if (editingId === id) {
                    // editingId = null;
                    // document.getElementById('saveBtn').innerText = "Salvar Nota";
                    // document.getElementById('noteTitle').value = '';
                    // document.getElementById('noteContent').value = '';

                let data = new URLSearchParams()
                data.append(`noteTitle`, note.title)
                data.append(`deleteNotes`, true)

                const options = {
                    method: 'POST',
                    body: data
                }
                fetch('/crud', options)                    

            }
            renderNotes();
            
        }

        // --- Modal Utils ---
        function closeModal(event, force = false) {
            if (force || event.target.className === 'modal-overlay') {
                document.getElementById('viewModal').style.display = 'none';
            }
        }