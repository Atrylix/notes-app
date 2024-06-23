function viewNote(noteTitle, noteContent, noteId) {
    redirect('/create?title=' + noteTitle + '&content=' + noteContent + '&id=' + noteId);
}

function savenote() {
    let title = document.getElementById('title').value;
    let content = document.getElementById('content').value;
    if (title && content) {
        console.log(title);
        console.log(content);

            fetch('http://localhost/sites/notes-app/save-note', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    title: title,
                    content: content
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data['success'] === true) {
                    window.location.replace('http://localhost/sites/notes-app');
                }
                return data;
            })
            .catch((error) => {
                console.error('Error:', JSON.stringify(error));
            });
    }
}

function modifyNote(noteId) {
    let title = document.getElementById('title').value;
    let content = document.getElementById('content').value;

    let confirmModify = confirm('Doing this, you will overwrite your original note. Do you wish to continue?');

    if (confirmModify) {
        if (title && content) {
            fetch('http://localhost/sites/notes-app/modify-note', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    noteId: noteId,
                    title: title,
                    content: content
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .then(window.location.replace('http://localhost/sites/notes-app'))
            .catch((error) => {
                console.error('Error:', JSON.stringify(error));
            });
        }
    }
}

function deleteNote(noteId) {
    let confirmDelete = confirm('Are you sure you want to delete this note? You cannot undo this action.');
    
    if (confirmDelete) {
        fetch('http://localhost/sites/notes-app/delete-note', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: noteId })
        })
    .then(response => response.json())
    .then(window.location.replace('http://localhost/sites/notes-app'))
    .catch((error) => {
            console.error('Error:', JSON.stringify(error));
        });
    }
}

function clearNotes() {
    let confirmDelete = confirm('Are you sure you want to clear all of your notes? You cannot undo this action.');

    if (confirmDelete) {
        fetch('http://localhost/sites/notes-app/clear-notes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(window.location.replace('http://localhost/sites/notes-app'))
        .catch((error) => {
            console.error('Error:', JSON.stringify(error));
        });
    }
}