document.getElementById('formSEmpleado').addEventListener('input', function(event) {
    event.preventDefault(); 
    const searchTerm = document.getElementById('idsempleado').value.toLowerCase();
    const tableRows = document.querySelectorAll('#IdTableEmp tbody tr'); 

    tableRows.forEach(row => {
        const rowData = row.textContent.toLowerCase();
        if (rowData.includes(searchTerm)) {
            row.style.display = ''; 
        } else {
            row.style.display = 'none'; 
        }
    });
});

// Mostrar el modal
function showModal(empleado) {
    document.getElementById('editarModal').classList.add('show');
    document.getElementById('idempleadou').value = empleado.idempleado;
    document.getElementById('nombreu').value = empleado.nombre;
    document.getElementById('apellidou').value = empleado.apellido;
    document.getElementById('duiu').value = empleado.dui;
    document.getElementById('salariou').value = empleado.salario;
    document.getElementById('usuariou').value = empleado.usuario;
    document.getElementById('pswu').value = empleado.psw;
    const rol = empleado.rol;

    if(rol === 1){
        const selectElement = document.getElementById('rolu');
        selectElement.innerHTML = '';
        const option1 = document.createElement("option");
        option1.value = 1;
        option1.textContent = "Administrador";
        option1.selected= true;

        const option2 = document.createElement("option");
        option2.value = 2;
        option2.textContent = "Empleado";

        selectElement.appendChild(option1);
        selectElement.appendChild(option2);
    } else if(rol === 2){
        const selectElement = document.getElementById('rolu');
        selectElement.innerHTML = '';
        const option1 = document.createElement("option");
        option1.value = 1;
        option1.textContent = "Administrador";

        const option2 = document.createElement("option");
        option2.value = 2;
        option2.textContent = "Empleado";
        option2.selected= true;

        selectElement.appendChild(option1);
        selectElement.appendChild(option2);
    }
}

function hideModal() {
    document.getElementById('editarModal').classList.remove('show');
}
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
  function VlidarNumerodecimales(input) {
    // Permite solo números y un punto decimal
    let valor = input.value.replace(/[^0-9.]/g, '');
  
    // Asegura que solo haya un punto decimal
    const partes = valor.split('.');
    if (partes.length > 2) {
      valor = partes[0] + '.' + partes.slice(1).join(''); // Mantiene el primer punto
    }
  
    // Limita a dos números después del punto decimal
    if (partes[1]?.length > 2) {
      valor = partes[0] + '.' + partes[1].slice(0, 2);
    }
  
    // Actualiza el valor del campo de entrada
    input.value = valor;
  }
  
  