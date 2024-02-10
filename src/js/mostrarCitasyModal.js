import { cargarHorasyMascotas, limpiarHTMLConsultas, cargarHorasModal } from "./funciones";
(function () {
    const nuevaConsulta = document.querySelector('#nueva-cita');
    if (nuevaConsulta) {
        let citas = [];
        //llamamos funcion para obtener citas
        obtenerCitas();
        /*********************************AREA DE EDITAR CONSULTAS EN EL  MODAL***************************************************/
        const fechaModal = document.querySelector('#fechaModal'); //tomar el id del select de fecha

        const horaIDModal = document.querySelectorAll('#horaIDModal');//Para tomar el id del select de horas

        const editarCitaModal = document.querySelector('#btnGuardar');//boton para editar la cita

        const tablaCitas = document.querySelector('#tablaCitas');//seleccionamos el id de la tabla donde vamos a inyectar las citas

        let seleccionHora; //aca depositaremos el value(id de la hora)

        // Obtén el select
        const selectModalHora = document.getElementById("horaIDModal");
        /*********************************************************************************************************************/
        /*********************************AREA PARA CREAR CONSULTAS***************************************************/
        const fechas = document.querySelector('#fecha');
        const mascotaID = document.querySelectorAll('#mascota_id');//para tomar el id del select de mascotas

        const horaID = document.querySelectorAll('#horaID');
        const motivoCita = document.querySelector('#motivo');

        let seleccionHoraCita;
        let seleccionMascotaCita;
        let seleccionFechaCita;

        // Obtén el select
        const selectH = document.getElementById("horaID");
        // Obtén el select
        const selectM = document.getElementById("mascota_id");

        // Agrega un evento de cambio al input type:date para cargar las horas cuando cambie
        fechas.addEventListener('change', async (e) => {
            let seleccionFecha = e.target.value;
            seleccionFechaCita = e.target.value;
            cargarHorasyMascotas(seleccionFecha, selectH, selectM);

            //(arrow function)
            horaID.forEach(index => index.addEventListener('change', e => seleccionHoraCita = e.target.value));//Vamos a iterar en cada uno de ellos, para agregar un evento y capturar su id
            mascotaID.forEach(index => index.addEventListener('change', e => seleccionMascotaCita = e.target.value));//Vamos a iterar en cada uno de ellos, para agregar un evento y capturar su id
        });

        /**PARA CREAR UNA CONSULTA POR PRIMER VEZ**/
        nuevaConsulta.addEventListener('submit', async function (e) {
            e.preventDefault();

            let fecha = seleccionFechaCita
            let hora = seleccionHoraCita;
            let mascota = seleccionMascotaCita;
            let motivo = motivoCita.value;

            // Verificar si alguno de los campos está vacío
            if (!fecha || !hora || !mascota || !motivo) {
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

                    document.querySelector('#fecha').value = '';;
                    document.querySelector('#mascota_id').value = '';
                    document.querySelector('#horaID').value = '';
                    document.querySelector('#motivo').value = '';
                    return; // Detener la ejecución del código
                } else {
                    Swal.fire(
                        resultado.tipo,
                        resultado.mensaje,
                        'success'
                    );
                    document.querySelector('#fecha').value = '';;
                    document.querySelector('#mascota_id').value = '';
                    document.querySelector('#horaID').value = '';
                    document.querySelector('#motivo').value = '';

                    obtenerCitas();
                }

            } catch (error) {
                console.log(error);
            }
        });
        /*********************************************************************************************************************/

        async function obtenerCitas() {
            try {
                //hacemos la consulta
                const url = '/citasU';
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();

                citas = resultado.citasUsuario;

                // console.log(citas);

                //llamamos funcion para mostrar las Citas
                mostrarConsultas();
            } catch (error) {
                console.log(error);
            }
        }

        //funcion para mostar las consultas en pantalla
        //usamos Scripting
        function mostrarConsultas() {
            //llamamos funcion para limpiar el HTML y asi no habrian copias incesesarias.
            limpiarHTMLConsultas();
            //formateamos las citas
            formatearConsultas(citas);

            if (citas.length === 0) {
                const tbody = tablaCitas.querySelector('tbody');
                const titulo = document.createElement('h4');
                titulo.textContent = 'No hay citas para mostar';
                tbody.appendChild(titulo);

            } else {
                const thead = tablaCitas.querySelector('thead');
                const tbody = tablaCitas.querySelector('tbody');

                const filaTh = document.createElement('tr');

                const fechaTh = document.createElement('td');
                fechaTh.textContent = 'Fecha';
                filaTh.appendChild(fechaTh);
                thead.appendChild(filaTh);

                const horaTh = document.createElement('td');
                horaTh.textContent = 'Hora';
                filaTh.appendChild(horaTh);
                thead.appendChild(filaTh);

                const mascotaTh = document.createElement('td');
                mascotaTh.textContent = 'MASCOTA';
                filaTh.appendChild(mascotaTh);
                thead.appendChild(filaTh);

                const accionTh = document.createElement('td');
                accionTh.textContent = 'Acciones';
                filaTh.appendChild(accionTh);
                thead.appendChild(filaTh);

                citas.forEach(cita => {
                    const filaTb = document.createElement('tr');

                    const fecha = document.createElement('td');
                    fecha.textContent = cita.fecha;
                    filaTb.appendChild(fecha);

                    const hora = document.createElement('td');
                    hora.textContent = cita.hora;
                    filaTb.appendChild(hora);

                    const mascota = document.createElement('td');
                    mascota.textContent = cita.mascota;
                    filaTb.appendChild(mascota);

                    const acciones = document.createElement('td');

                    const botonActualizar = document.createElement('button');
                    botonActualizar.textContent = 'Editar';
                    botonActualizar.classList.add('btn', 'btn-primary');
                    botonActualizar.addEventListener('click', () => {
                        abrirModalActualizar({ ...cita });
                    });
                    acciones.appendChild(botonActualizar);

                    const botonEliminar = document.createElement('button');
                    botonEliminar.textContent = 'Cancelar';
                    botonEliminar.classList.add('btn', 'btn-danger', 'ms-2');
                    botonEliminar.addEventListener('click', () => {
                        //funcion para eliminar Mascota
                        confirmarEliminarCita({ ...cita });

                    });

                    acciones.appendChild(botonEliminar);

                    filaTb.appendChild(acciones);
                    tbody.appendChild(filaTb);
                });
            }
        }

        //Formateamos las citas por default el array estara vacio
        function formatearConsultas(arrayUsuarios = []) {
            //.map(), crea un arreglo nuevo sin necesidad de mutar el original
            citas = arrayUsuarios.map(consulta => {
                //nos retornara un objeto
                return {
                    fecha: consulta.fecha,
                    id: consulta.id,
                    hora: consulta.horaID.hora,
                    mascota: consulta.mascota_id.nombre
                }
            });
        }
        async function eliminarCita(cita) {
            const { id, mascota_id, fecha, horaID, motivo, usuario_id } = cita;

            const datos = new FormData();
            datos.append('id', id);
            datos.append('mascota_id', mascota_id);
            datos.append('fecha', fecha);
            datos.append('horaID', horaID);
            datos.append('motivo', motivo);
            datos.append('usuario_id', usuario_id);


            try {
                const url = '/citasU/borrarC';
                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.resultado) {
                    Swal.fire('Eliminado!', resultado.mensaje, 'success');

                    citas = citas.filter(citaMemoria => citaMemoria.id !== cita.id);
                    obtenerCitas();
                }
            } catch (error) {
                console.log(error);
            }
        }

        function abrirModalActualizar(cita) {
            const citaId = cita.id; // ID de la cita que deseas editar

            fechaModal.value = cita.fecha;
            // Carga las horas disponibles utilizando la fecha inicial
            cargarHorasModal(cita.fecha, selectModalHora);

            // Agrega un evento de cambio al input type:date para cargar las horas cuando cambie
            fechaModal.addEventListener('change', async (e) => {
                let seleccionFecha = e.target.value;
                cargarHorasModal(seleccionFecha, selectModalHora);
            });

            //(arrow function)
            horaIDModal.forEach(index => index.addEventListener('change', e => seleccionHora = e.target.value));//Vamos a iterar en cada uno de ellos, para agregar un evento y capturar su id

            editarCitaModal.onclick = () => {
                const indiceCita = citas.findIndex(cita => cita.id === citaId);
                editarValoresCita(indiceCita);
            };

            // Obtener referencia al modal y al modal body
            const modalActualizar = new bootstrap.Modal(document.querySelector('#modalActualizarCita'));

            // Mostrar el modal
            modalActualizar.show();
        }

        async function editarValoresCita(indiceCita) {
            const cita = citas[indiceCita];

            const nuevaFecha = fechaModal.value ? fechaModal.value : document.querySelector('#fechaModal').value;
            const nuevaHora = !seleccionHora ? document.querySelector('#horaIDModal').value : seleccionHora;

            // Verificar si alguno de los campos está vacío
            if (!nuevaFecha || !nuevaHora) {
                Swal.fire(
                    'Error',
                    'Por favor, completa todos los campos',
                    'error'
                );
                return; // Detener la ejecución del código
            }

            // Actualizar los valores de la mascota en el arreglo Citas
            cita.fecha = nuevaFecha;
            cita.horaID = nuevaHora;

            //Creamos la Peticion
            // FormData
            const datos = new FormData();
            datos.append('id', cita.id);
            datos.append('fecha', cita.fecha);
            datos.append('horaID', cita.horaID);


            try {
                const url = '/citasU/editarC';
                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();
                // console.log(respuesta);
                // return;

                if (resultado.tipo === 'error') {
                    Swal.fire(
                        'Error',
                        resultado.mensaje,
                        'error'
                    );

                    document.querySelector('#fechaModal').value = '';
                    document.querySelector('#horaIDModal').value = '';
                    return; // Detener la ejecución del código
                } else {
                    Swal.fire(
                        resultado.tipo,
                        resultado.mensaje,
                        'success'
                    );
                    citas[indiceCita] = cita; // Reemplazar la mascota en el arreglo mascotas con la mascota editada
                }

            } catch (error) {
                console.log(error);
            }

            document.querySelector('#fechaModal').value = '';
            document.querySelector('#horaIDModal').value = '';

            obtenerCitas();
            // Actualizar la información en la interfaz de usuario
            mostrarConsultas(); // Volver a mostrar la tabla actualizada
        }

        //Funcion para mensaje de confirmacion de eliminar mascota
        function confirmarEliminarCita(cita) {
            Swal.fire({
                title: 'Eliminar Cita?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'NO'
            }).then((result) => {
                //validamos que si se haya dado click en eliminar
                if (result.isConfirmed) {
                    console.log(cita);
                    //llamamos funcion para eliminar Mascota
                    eliminarCita(cita);
                }
            })
        }
    }
})();