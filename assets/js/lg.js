const flogin = document.getElementById('loginform');
flogin.addEventListener('submit', function (event){
   event.preventDefault();
   const username = flogin.username.value;
   const password = flogin.password.value;
   const data = {
    username: username,
    password: password
   }
   fetch('../controllers/EmpleaedoController.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',  
    },
    body: JSON.stringify({data})
    })
    .then(response => response.json())  
    .then(data => {
    console.log('Respuesta del servidor:', data);
    alert('Datos enviados correctamente');
    if (data.mensaje === 1) {
        window.location.href ='../views/Mesas.php';  
    }
    })
    .catch(error => {
    console.error('Error al enviar los datos:', error);
    });
})