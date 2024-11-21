document.getElementById('formSMenu').addEventListener('input', function(event) {
    event.preventDefault(); 
    const searchTerm = document.getElementById('idsmenu').value.toLowerCase();
    const tableRows = document.querySelectorAll('#IdTableMenu tbody tr'); 

    tableRows.forEach(row => {
        const rowData = row.textContent.toLowerCase();
        if (rowData.includes(searchTerm)) {
            row.style.display = ''; 
        } else {
            row.style.display = 'none'; 
        }
    });
});

function showModal(item) {
    document.getElementById('editarModal').classList.add('show');
    document.getElementById('idmenuu').value = item.idmenu;
    document.getElementById('idnombreu').value = item.nombre;
    document.getElementById('iddescripcionu').value = item.descripcion;
    document.getElementById('idpreciou').value = item.precio;
    const cat = item.idcategoria;

    if(cat === 1){
        const selectElement = document.getElementById('idcategoriau');
        selectElement.innerHTML = '';
        const option1 = document.createElement("option");
        option1.value = 1;
        option1.textContent = "bebida";
        option1.selected= true;

        const option2 = document.createElement("option");
        option2.value = 2;
        option2.textContent = "plato";

        const option3 = document.createElement("option");
        option3.value = 3;
        option3.textContent = "entrada";

        selectElement.appendChild(option1);
        selectElement.appendChild(option2);
        selectElement.appendChild(option3);
    } else if(cat === 2){
        const selectElement = document.getElementById('idcategoriau');
        selectElement.innerHTML = '';
        const option1 = document.createElement("option");
        option1.value = 1;
        option1.textContent = "bebida";

        const option2 = document.createElement("option");
        option2.value = 2;
        option2.textContent = "plato";
        option2.selected= true;

        const option3 = document.createElement("option");
        option3.value = 3;
        option3.textContent = "entrada";

        selectElement.appendChild(option1);
        selectElement.appendChild(option2);
        selectElement.appendChild(option3);
    } else if(cat === 3){
        const selectElement = document.getElementById('idcategoriau');
        selectElement.innerHTML = '';
        const option1 = document.createElement("option");
        option1.value = 1;
        option1.textContent = "bebida";

        const option2 = document.createElement("option");
        option2.value = 2;
        option2.textContent = "plato";

        const option3 = document.createElement("option");
        option3.value = 3;
        option3.textContent = "entrada";
        option3.selected= true;
        selectElement.appendChild(option1);
        selectElement.appendChild(option2);
        selectElement.appendChild(option3);
    }
}

function hideModal() {
    document.getElementById('editarModal').classList.remove('show');
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