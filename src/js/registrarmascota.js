(function () {
    let formRegsMascota = document.querySelector('#formRegsMascota');
    if (formRegsMascota) {
        formRegsMascota.addEventListener('submit', async function (e) {
            e.preventDefault();

            let nombre = document.querySelector('#nombre').value
            let nacimiento = document.querySelector('#nacimiento').value
            let especie = document.querySelector('#especie').value
            let raza = document.querySelector('#raza').value
            let color = document.querySelector('#color').value
            let sexo = document.querySelector('#sexo').value

            // Verificar si alguno de los campos está vacío
            if (!nombre || !nacimiento || !especie || !raza || !color || !sexo) {
                Swal.fire(
                    'Error',
                    'Por favor, completa todos los campos',
                    'error'
                );
                return; // Detener la ejecución del código
            }

            //Construir la peticion
            const datos = new FormData();
            datos.append('nombre', nombre);
            datos.append('nacimiento', nacimiento);
            datos.append('especie', especie);
            datos.append('raza', raza);
            datos.append('color', color);
            datos.append('sexo', sexo);

            try {
                const url = '/nuevamascota/guardar'

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                //Respuesta de la peticion
                const resultado = await respuesta.json();

                if (resultado.tipo === 'exito') {
                    Swal.fire(
                        resultado.mensaje,
                        resultado.mensaje,
                        'success'
                    );

                    // Vaciar los campos del formulario
                    document.querySelector('#nombre').value = '';
                    document.querySelector('#nacimiento').value = '';
                    document.querySelector('#especie').value = '';
                    document.querySelector('#raza').value = '';
                    document.querySelector('#color').value = '';
                    document.querySelector('#sexo').value = '';
                    document.querySelector('#peso').value = '';

                }
            } catch (error) {
                console.log(error);
            }
        });
    }
})();
