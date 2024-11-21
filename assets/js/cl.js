function editarCliente(cliente){
    // Supongamos que tienes un formulario con campos específicos para editar cliente
        document.getElementById('idclienteu').value = cliente.idcliente;
        document.getElementById('nombreu').value = cliente.nombres;
        document.getElementById('apellidou').value = cliente.apellidos;
        document.getElementById('correou').value = cliente.correo;
    
        // Aquí puedes abrir un modal o mostrar el formulario de edición
        document.getElementById('editarModal').classList.add('show');
}
function hideModal() {
        document.getElementById('editarModal').classList.remove('show');
}

document.getElementById('formSCliente').addEventListener('input', function(event) {
        event.preventDefault(); 
        const searchTerm = document.getElementById('idscliente').value.toLowerCase();
        const tableRows = document.querySelectorAll('#IdTableClient tbody tr'); 
    
        tableRows.forEach(row => {
            const rowData = row.textContent.toLowerCase();
            if (rowData.includes(searchTerm)) {
                row.style.display = ''; 
            } else {
                row.style.display = 'none'; 
            }
        });
});
function ValidarDui(input) {
    // Solo permite números removiendo letras u otros caracteres no numéricos
    let valor = input.value.replace(/[^0-9]/g, '');
  
    // Limita a un máximo de 9 caracteres numéricos (8 números + 1 guion)
    if (valor.length > 9) {
      valor = valor.slice(0, 9);
    }
  
    // Agrega el guion en la posición 9 si hay al menos 9 caracteres
    if (valor.length > 8) {
      valor = valor.slice(0, 8) + '-' + valor.slice(8);
    }
  
    // Asigna el valor actualizado al campo de entrada
    input.value = valor;
  }
  function ValidarCorreo(input) {
    // Expresión regular para validar un correo electrónico
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  
    // Validar el correo actual
    const correo = input.value;
  
    if (!regex.test(correo)) {
      alert("El correo electrónico no es válido. Por favor, verifica.");
      input.value = ""; // Limpia el campo si no es válido
    }
  }
  