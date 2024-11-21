function obtenerDetalleFadtura(factura) {
    let tt=0;
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

        // Verifica si data tiene la estructura esperada
        if (!data || !data.data) {
            console.error('Estructura de datos inesperada:', data);
            alert('Error: No se pudieron obtener los datos del servidor.');
            return;
        }

        const detalleFactura = data.data;
        const tbody = document.getElementById('DetalleFacturaTBody');
        tbody.innerHTML = '';

        // Itera sobre los pedidos solo si es un array válido
        if (Array.isArray(detalleFactura)) {
            detalleFactura.forEach(pedido => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="display: none;">${pedido.iddetallefactura}</td>
                    <td>${pedido.nombre}</td>
                    <td>${pedido.precio}</td>
                    <td>${pedido.cantidad}</td>
                    <td>${pedido.subtotal}</td>`;

                                    // Crear un <td> para el botón
                    const tdButton = document.createElement('td');
                    const button = document.createElement('button');
                    button.style.backgroundColor = 'red';
                    button.style.color = 'white';
                    button.type = 'button';
                    button.innerHTML = '&times;'; // Símbolo de "cerrar"
                    button.onclick = function () {
                    // Llama a la función `deletedetallefactura` con los parámetros
                    deletedetallefactura(pedido, factura);
                    };
                    // Añade el botón al <td> y el <td> a la fila
                tdButton.appendChild(button);
                row.appendChild(tdButton);
                tbody.appendChild(row);
                let cant = parseInt(pedido.cantidad)
                let precio = parseFloat(pedido.precio)
                tt += cant * precio
                
                document.getElementById('total').value = tt.toFixed(2);
            });
        } else if(data===1){
            
        }
    })
    .catch(error => {
        console.error('Error al enviar los datos:', error);
    });
}
document.getElementById('SFormMenu').addEventListener('input', function(event) {
    event.preventDefault(); 

    const searchTerm = document.getElementById('busquedaMenu').value.toLowerCase();
    const tableRows = document.querySelectorAll('#idTableMenu tbody tr'); 

    tableRows.forEach(row => {
        const rowData = row.textContent.toLowerCase();
        if (rowData.includes(searchTerm)) {
            row.style.display = ''; 
        } else {
            row.style.display = 'none'; 
        }
    });
});

document.getElementById("AddCliente").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("myModalCliente").style.display = "block"; // Mostrar el modal
});
document.getElementById("closeModalBtnCliente").addEventListener("click", function() {
    document.getElementById("myModalCliente").style.display = "none"; // Ocultar el modal
});
document.getElementById("closeModalCliente").addEventListener("click", function() {
    document.getElementById("myModalCliente").style.display = "none"; // Cerrar modal también desde el botón "Cerrar"
});
document.getElementById('SFormCliente').addEventListener('input', function(event) {
    event.preventDefault(); 

    const searchTerm = document.getElementById('busquedaCliente').value.toLowerCase();
    const tableRows = document.querySelectorAll('#idTableCliente tbody tr'); 

    tableRows.forEach(row => {
        const rowData = row.textContent.toLowerCase();
        if (rowData.includes(searchTerm)) {
            row.style.display = ''; 
        } else {
            row.style.display = 'none'; 
        }
    });
});

const formularios = document.querySelectorAll('.formNDF');
formularios.forEach(form => {
    form.addEventListener('submit', function(event) {
        event.preventDefault(); 
        let formData = new FormData(this);  
        const Menu = JSON.parse(form.querySelector('input[name="Menu"]').value);
        const Factura = JSON.parse(form.querySelector('input[name="Factura"]').value);

        const Scantidad = form.querySelector('input[name="cantidadNPedido"]').value;
        const SIdFactura = Factura.idfactura;
        const SIdMenu = Menu.idmenu;
        const SSubtotal = Menu.precio * Scantidad;
        const Action ='insertardetalleventa';

        fetch('../controllers/DetalleFacturaController.php',{
            method: 'POST',
            headers:{
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: Action,
                cantidad: Scantidad,
                idmenu: SIdMenu,
                subtotal: SSubtotal,
                idfactura: SIdFactura
            })
        })
        .then(response => response.json())  
        .then(data => {
            if(data.data === 1){
                obtenerDetalleFadtura(Factura)
                form.querySelector('input[name="cantidadNPedido"]').value = '';
            }else if(data.data === 0){
                alert('respuesta de insertar detallefactura'+ data)
            }
        })
        .catch(error => {
            console.error('Error al enviar los datos:', error);
        });

    });
});
function deletedetallefactura(pedido,factura){
     const Action = 'deletedf';
     const IdDf = pedido.iddetallefactura;
    fetch('../controllers/DetalleFacturaController.php',{
        method: 'POST',
        headers:{
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: Action,
            iddf: IdDf
        })
    })
    .then(response => response.json())  
    .then(data => {
        if(data.data === 1){
            obtenerDetalleFadtura(factura)
        }else if(data.data === 0){
            alert('respuesta de eliminar detallefactura'+ data)
        }
    })
    .catch(error => {
        console.error('Error al enviar los datos desde om.js:', error);
    });

}
function asignarCliente(cliente,factura){
    
    document.getElementById('idcliente').value = cliente.idcliente;
    document.getElementById('cliente').value = cliente.nombres +' '+ cliente.apellidos;
    let Action = 'updateclientefactura';
    let IdCliente = cliente.idcliente;
    let IdFactura = factura.idfactura;
    
    fetch('../controllers/FacturaController.php',{
        method: 'POST',
        headers:{
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: Action,
            idcliente: IdCliente,
            idfactura: IdFactura
        })
    })
    .then(response => response.json())  
    .then(data => {
        console.log(data);
        if(data.data === 1){
            
        }else if(data.data === 0){
            alert('no cambio cliente a factura'+ data)
        }
    })
    .catch(error => {
        alert('cliente seleccionado puede volver a la pagina principal');
        console.error('Error al enviar los datos desde om.js:', error);
    });
}


const estadoFacturaDropdown = document.getElementById('estadofactura');
estadoFacturaDropdown.addEventListener('change', (event) => {
    const selectedValue = event.target.value; 
    const idfactura = document.getElementById('idfacturaglobal').value;
    fetch('../controllers/FacturaController.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        action: 'updateestadofactura',
        estadofactura: selectedValue,
        idfactura: idfactura
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data); // Esto es para depurar y ver qué se está recibiendo del backend
        if (data.data === 1) {
            alert('Estado de factura cambiado');
        } else if (data.data === 0) {
            alert('No se pudo cambiar el estado de la factura');
        } else if (data.error) {
            alert('Error: ' + data.error);  // Mostrar el error si existe
        }
      })
      .catch((error) => {
        console.error('Error en el fetch:', error);
      });
  });


const btnCompletarFactura = document.getElementById('btnCompletarFactura');
btnCompletarFactura.addEventListener('click', function(event) {
    event.preventDefault();
    let action = 'completeventa';
    let total = document.getElementById('total').value;
    let idfactura = document.getElementById('idfacturaglobal').value;
    let idmesa = document.getElementById('idmesaglobal').value;
    fetch('../controllers/FacturaController.php',{
        method: 'POST',
        headers:{
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: action,
            total: total,
            idfactura: idfactura,
            idmesa: idmesa
        }),
    })
    .then(response => response.json())  
    .then(data => {
        if(data.data === 1){
            alert('1')
        }else if(data.data === 0){
            alert('no cambio cliente a factura'+ data)
        }
    })
    .catch(error => {

        // Crear la URL con el parámetro idfactura
        let url = `../controllers/factura.php?idfactura=${idfactura}`;

        // Usar fetch para hacer la solicitud GET
        fetch(url)
        .then(response => response.blob())  // Obtener la respuesta como texto
        .then(blob => {
            
            const url = URL.createObjectURL(blob);
            window.open(url, '_blank');
            window.location.replace('../views/Mesas.php');
        })
        .catch(error => {
            console.error('Error al hacer la solicitud GET:', error);
        });


        console.error('Error al enviar los datos desde om.js:', error);
    });
});
/*
function CompletarVenta(){
    let action = 'completeventa';
    let total = document.getElementById('total').value;
    let idfactura = document.getElementById('idfacturaglobal');
    let idmesa = document.getElementById('idmesaglobal');
    fetch('../controllers/FacturaController.php',{
        method: 'POST',
        headers:{
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: action,
            total: total,
            idfactura: idfactura,
            idmesa: idmesa
        })
    })
    .then(response => response.json())  
    .then(data => {
        if(data.data === 1){
            
        }else if(data.data === 0){
            alert('no cambio cliente a factura'+ data)
        }
    })
    .catch(error => {
        console.error('Error al enviar los datos desde om.js:', error);
    });
}*/