function GenerarReporte() {
        const { jsPDF } = window.jspdf; // Inicializar jsPDF
        const doc = new jsPDF();

        doc.text("Reporte de Ventas", 14, 10); // Título del PDF
        doc.autoTable({
            html: "#ReportTable", // Pasar la tabla por ID
            startY: 20,
            styles: { cellPadding: 3, fontSize: 10 },
        });

        doc.save("reporte_ventas.pdf"); // Descargar el PDF
}

document.getElementById('BtnEnviarReporte').addEventListener('click', function() {
    let tt=0;
    // Capturar el formulario completo
    const form = document.getElementById('ReporteForm');
    const formData = new FormData(form);

    /* Opcional: Mostrar los datos capturados para verificar
    for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }*/

    // Enviar los datos al servidor mediante fetch
    fetch('../controllers/ReporteController.php', {
        method: 'POST',
        body: formData, // Envía los datos del formulario
    })
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta del servidor:', data);
        const reporte = data.data;
        const tbody = document.getElementById('ReportTBody');
        tbody.innerHTML = '';

        // Itera sobre los pedidos solo si es un array válido
        if (Array.isArray(reporte)) {
            reporte.forEach(factura => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="text-align:center;">${factura.idfactura}</td>
                    <td>${factura.fecha}</td>
                    <td>${factura.total}</td>
                    <td>${factura.cliente}</td>
                    <td>${factura.empleado}</td>`;

                    
                tbody.appendChild(row);
                let subtotal = parseFloat(factura.total)
                tt += subtotal;
                
                document.getElementById('idTotalGeneral').value = tt.toFixed(2);
                document.getElementById('idTotalGeneral').innerText = tt.toFixed(2);
            });
        } else if(data===0){
            
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
