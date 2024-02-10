import { cargarHorasModal, mostrarMascotasAD } from "./funciones";
(function () {
    // Capturamos el ID del input text para validar
    const usuarioADInput = document.querySelector('#usuarioAD');

    // Validamos que exista el input text para que funcione correctamente
    if (usuarioADInput) {
        // Creamos un array para los usuarios que provienen de la API
        let usuariosAD = [];
        let usuariosFiltrados = [];
        const listadoUsuarios = document.querySelector('#listado-usuarios');

        /**FECHAS**/
        const fechaAD = document.querySelector('#fechaAD');
        const mascotaAD = document.querySelectorAll('#mascota_idAD');
        const horaAD = document.querySelectorAll('#horaIDAD');
        const horaADID = document.getElementById('horaIDAD');
        const mascotaADID = document.getElementById('mascota_idAD');
        const motivoAD = document.querySelector('#motivoAD');
        /****/

        /**FORMULARIO DE CONSULTAS**/
        const formularioCitaAD = document.querySelector('#nuevaCitaAD');
        /**************************/

        let seleccionHoraAD;
        let seleccionMascotaAD;
        let seleccionFechaAD;
        let seleccionIdUsuario;

        obtenerUsuarios();

        usuarioADInput.addEventListener('input', buscarUsuarios);
        

        async function obtenerUsuarios() {
            try {
                const url = '/admin/TotalUsuarios';
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();
                formatearUsuarios(resultado);
            } catch (error) {
                console.log(error);
            }
        }

        //Formateamos los ponentes por default el array estara vacio
        function formatearUsuarios(arrayUsuarios = []) {
            //.map(), crea un arreglo nuevo sin necesidad de mutar el original
            usuariosAD = arrayUsuarios.map(usuario => {
                //nos retornara un objeto
                return {
                    id: usuario.id,
                    nombre: `${usuario.nombre.trim()} ${usuario.apellido.trim()}`
                }
            });
        }

        function buscarUsuarios(e) {
            //variable de busqueda
            const busqueda = e.target.value;

            //validamos que lo que estemos digitando se mayor a 3 caracteres para que comience la busqueda
            if (busqueda.length >= 3) {
                //expresion regular buscar un patron en un valor, cuando esta en -1 significa que no encontro nada
                //expresion regular para que busque sin importar si es miniscula o mayuscula
                const expresion = new RegExp(busqueda.normalize('NFD').replace(/[\u0300-\u036f]/g, ""), "i");
                usuariosFiltrados = usuariosAD.filter(usuario => {
                    if (usuario.nombre.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase().search(expresion) != -1) {
                        return usuario;
                    }
                });
            } else {
                //para limpiar el arreglo y asi limpiar mostrarPonetes();
                usuariosFiltrados = [];
            }

            mostrarUsuarios();
        }

        function mostrarUsuarios() {
            // para limpiar el HTML
            while (listadoUsuarios.firstChild) {
                listadoUsuarios.removeChild(listadoUsuarios.firstChild);
            }

            if (usuariosFiltrados.length > 0) {
                usuariosFiltrados.forEach(usuario => {
                    const usuarioHTML = document.createElement('LI');
                    usuarioHTML.classList.add('listado-ponentes__ponente');
                    usuarioHTML.textContent = usuario.nombre;
                    usuarioHTML.dataset.usuarioId = usuario.id;

                    // Añadir evento de clic a cada elemento <li>
                    usuarioHTML.addEventListener('click', () => {
                        // Llenar el campo de búsqueda con el texto del elemento clicado
                        usuarioADInput.value = usuario.nombre;
                        // Asignar el ID del usuario al campo de búsqueda (usando un atributo personalizado)
                        usuarioADInput.dataset.usuarioId = usuario.id;
                        seleccionIdUsuario = usuario.id;
                        //llamamos funcion
                        mostrarMascotasAD(seleccionIdUsuario, mascotaADID);
                        // Limpiar la lista de sugerencias
                        while (listadoUsuarios.firstChild) {
                            listadoUsuarios.removeChild(listadoUsuarios.firstChild);
                        }
                    });

                    // Añadir al DOM
                    listadoUsuarios.appendChild(usuarioHTML);
                });
            } else {
                // validamos que lo que hayamos escrito en el input sea mayor o igual a 3
                if (usuarioADInput.value.length >= 3) {
                    const noResultados = document.createElement('P');
                    noResultados.classList.add('listado-ponentes__no-resultado');
                    noResultados.textContent = 'No hay resultados para tu búsqueda'
                    listadoUsuarios.appendChild(noResultados);
                }
            }
        }
        /************************************************Fechas y hora****************************************************************/
        fechaAD.addEventListener('change', e => {
            seleccionFechaAD = e.target.value;
            cargarHorasModal(seleccionFechaAD, horaADID);
        });
        /*****************************************************************************************************************************/
        /************************************************ELEJIR MASCOTAS Y HORA****************************************************************/
        mascotaAD.forEach(index => index.addEventListener('change', e => seleccionMascotaAD = e.target.value));//Vamos a iterar en cada uno de ellos, para agregar un evento y capturar su id
        horaAD.forEach(index => index.addEventListener('change', e => seleccionHoraAD = e.target.value));
        /**************************************************************************************************************************************/

        /**PARA CREAR UNA CONSULTA**/
        formularioCitaAD.addEventListener('submit', async function (e) {
            e.preventDefault();
            let usuario = seleccionIdUsuario;
            let fecha = seleccionFechaAD
            let hora = seleccionHoraAD;
            let mascota = seleccionMascotaAD;
            let motivo = motivoAD.value;

            // Verificar si alguno de los campos está vacío
            if (!usuario || !fecha || !hora || !mascota || !motivo) {
                Swal.fire(
                    'Error',
                    'Por favor, completa todos los campos',
                    'error'
                );
                return; // Detener la ejecución del código
            }

            //Construir la peticion
            const datos = new FormData();
            datos.append('mascota_id', mascota);
            datos.append('fecha', fecha);
            datos.append('horaID', hora);
            datos.append('motivo', motivo);
            datos.append('usuario_id', usuario);

            try {
                const url = '/cita/crearConsulta';
                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                //respuesta de la peticion
                const resultado = await respuesta.json();

                if (resultado.tipo === 'error') {
                    Swal.fire(
                        'Error',
                        resultado.mensaje,
                        'error'
                    );
                    
                    document.querySelector('#usuarioAD').value = '';
                    document.querySelector('#fechaAD').value = '';
                    document.querySelector('#mascota_idAD').value = '';
                    document.querySelector('#horaIDAD').value = '';
                    document.querySelector('#motivoAD').value = '';
                    return; // Detener la ejecución del código
                } else {
                    Swal.fire(
                        resultado.tipo,
                        resultado.mensaje,
                        'success'
                    );
                    document.querySelector('#usuarioAD').value = '';
                    document.querySelector('#fechaAD').value = '';
                    document.querySelector('#mascota_idAD').value = '';
                    document.querySelector('#horaIDAD').value = '';
                    document.querySelector('#motivoAD').value = '';
                }
            } catch (error) {
                console.log(error);
            }
        });
    }
})();