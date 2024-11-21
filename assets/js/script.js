function editarCliente(cliente){
// Supongamos que tienes un formulario con campos específicos para editar cliente
    document.getElementById('cliente_id').value = cliente.idcliente;
    document.getElementById('nombres').value = cliente.nombres;
    document.getElementById('apellidos').value = cliente.apellidos;
    document.getElementById('correo').value = cliente.correo;

    // Aquí puedes abrir un modal o mostrar el formulario de edición
    document.getElementById('editarForm').style.display = 'block';
}

// Abrir el modal
/*document.getElementById("openModalBtn").addEventListener("click", function() {
    document.getElementById("myModal").style.display = "block"; // Mostrar el modal
});

// Cerrar el modal
document.getElementById("closeModalBtn").addEventListener("click", function() {
    document.getElementById("myModal").style.display = "none"; // Ocultar el modal
});
document.getElementById("closeModalBtn2").addEventListener("click", function() {
    document.getElementById("myModal").style.display = "none"; // Cerrar modal también desde el botón "Cerrar"
});*/



function asignarMesa(mesa){
    const idmesa = mesa.idmesa;
    const estadoMesa = mesa.estadoMesa;
    const action = 'update';
    document.getElementById("myModal").style.display = "none";

    fetch('RESTAURANTE/controllers/MesaController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',  
        },
        body: JSON.stringify({
            action: action,
            idmesa: idmesa,
            estadomesa: estadoMesa
        })
    })
    .then(response => response.json())  
    .then(data => {
        console.log('Respuesta del servidor:', data);
        alert('Datos enviados correctamente');
        if (data.mensaje === 'Mesa actualizada correctamente') {
            window.location.href = window.location.href;  
        }
    })
    .catch(error => {
        console.error('Error al enviar los datos:', error);
    });

}


function editFactura(factura) {

    const idfactura = factura.idfactura;
    fetch('../controllers/DetalleFacturaController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'consult',
            idfactura: idfactura
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta del servidor:', data);

        // Verifica si data tiene la estructura esperada
        if (!data || !data.data) {
            console.error('Estructura de datos inesperada:', data);
            alert('Error: No se pudieron obtener los datos del servidor.');
            return;
        }

        const detalleFacturaData = data.data;

        const url = `OrdenesXmesas.php?factura=${encodeURIComponent(JSON.stringify(factura))}&detallefactura=${encodeURIComponent(JSON.stringify(detalleFacturaData))}`;

        window.location.href = url;
        loadScript('om.js','om-script')
    })
    .catch(error => {
        console.error('Error al enviar los datos:', error);
    });
}
// Cerrar el modal
document.addEventListener("DOMContentLoaded", function() {

});
function calculartotal(){
    const totalserver = document.getElementById('idTotalServer').value
    document.getElementById('total').value = totalserver;
}
/*function asignarMesa(mesa){
    const idmesa = mesa.id_mesa;
    const estadoMesa = mesa.estadoMesa;
    const action = 'update';
    document.getElementById("myModal").style.display = "none";

    fetch('RESTAURANTE/controllers/MesaController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',  
        },
        body: JSON.stringify({
            Ation: action,
            IdMesa: idmesa,
            EstadoMesa: estadoMesa
        })
    })
    .then(response => response.json())  
    .then(data => {
        console.log('Respuesta del servidor:', data);
        alert('Datos enviados correctamente');
        if (data.mensaje === 'Mesa actualizada correctamente') {
            window.location.href = window.location.href;  
        }
    })
    .catch(error => {
        console.error('Error al enviar los datos:', error);
    });

}*/

/* iterar sobre los forms que sirven para agregar un nuevo pedido a la factura*/


 //cargar .js para el acceso dianmico al DOM
 //remover scripts antiguos si existen
 function removeScript(scriptId) {
    const oldScript = document.getElementById(scriptId);
    if (oldScript) {
        oldScript.parentNode.removeChild(oldScript);
    }
  }
function loadScript(scriptName, scriptId) {
    removeScript(scriptId)
    const script = document.createElement('script');
    script.src = `js/${scriptName}`;
    script.id = scriptId;
    document.head.appendChild(script);
  }





