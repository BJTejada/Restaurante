document.getElementById('formSMesa').addEventListener('input', function(event) {
    event.preventDefault(); 
    const searchTerm = document.getElementById('idsmesa').value.toLowerCase();
    const tableRows = document.querySelectorAll('#IdTableMesas tbody tr'); 

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
    document.getElementById('idmesau').value = item.idmesa;
    document.getElementById('idnumerou').value = item.numero;
    document.getElementById('idzonau').value = item.zona;
    document.getElementById('idcapacidadu').value = item.capacidad;

}

function hideModal() {
    document.getElementById('editarModal').classList.remove('show');
}
function VlidarNumero(input) {
    input.value = input.value.replace(/[^0-9]/g, ''); // Solo permite dígitos
            
    // Evitar números que comiencen con 0
    if (input.value.startsWith("0")) {
        input.value = input.value.substring(1);
    }
  }