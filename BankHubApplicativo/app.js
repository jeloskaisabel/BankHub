document.addEventListener('DOMContentLoaded', function() {
    fetchPersonas();
});

function fetchPersonas() {
    fetch('https://localhost:7228/api/Personas')
        .then(response => response.json())
        .then(data => {
            const list = document.getElementById('personasList');
            list.innerHTML = '';  // Limpiar lista existente
            data.forEach(persona => {
                list.innerHTML += `
                    <tr>
                        <td>${persona.nombre}</td>
                        <td>${persona.apellido}</td>
                        <td>${persona.fechaNacimiento ? new Date(persona.fechaNacimiento).toLocaleDateString() : ''}</td>
                        <td>${persona.documentoIdentidad}</td>
                        <td>${persona.direccion}</td>
                        <td>${persona.telefono}</td>
                        <td>${persona.email}</td>
                        <td>${persona.departamento}</td> <!-- Mostrar departamento -->
                        <td>
                            <button onclick="editPersona(${persona.id})" class="btn btn-primary">Editar</button>
                            <button onclick="deletePersona(${persona.id})" class="btn btn-danger">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => console.error('Error:', error));
}

function savePersona() {
    const id = document.getElementById('personaId').value;
    const persona = {
        nombre: document.getElementById('nombre').value,
        apellido: document.getElementById('apellido').value,
        fechaNacimiento: document.getElementById('fechaNacimiento').value,
        documentoIdentidad: document.getElementById('documentoIdentidad').value,
        direccion: document.getElementById('direccion').value,
        telefono: document.getElementById('telefono').value,
        email: document.getElementById('email').value,
        departamento: document.getElementById('departamento').value // Obtener valor del campo departamento
    };

    const method = id ? 'PUT' : 'POST';
    const url = `https://localhost:7228/api/Personas${id ? `/${id}` : ''}`;

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(persona)
    })
    .then(response => response.json())
    .then(data => {
        alert('Operación exitosa!');
        fetchPersonas();
    })
    .catch(error => console.error('Error:', error));
}

function editPersona(id) {
    fetch(`https://localhost:7228/api/Personas/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('personaId').value = data.id;
            document.getElementById('nombre').value = data.nombre;
            document.getElementById('apellido').value = data.apellido;
            document.getElementById('fechaNacimiento').value = data.fechaNacimiento.split('T')[0];
            document.getElementById('documentoIdentidad').value = data.documentoIdentidad;
            document.getElementById('direccion').value = data.direccion;
            document.getElementById('telefono').value = data.telefono;
            document.getElementById('email').value = data.email;
            document.getElementById('departamento').value = data.departamento; // Poblar campo departamento
        });
}

function deletePersona(id) {
    if(confirm('¿Está seguro de que desea eliminar esta persona?')) {
        fetch(`https://localhost:7228/api/Personas/${id}`, {
            method: 'DELETE'
        })
        .then(() => {
            alert('Persona eliminada');
            fetchPersonas();
        })
        .catch(error => console.error('Error:', error));
    }
}
