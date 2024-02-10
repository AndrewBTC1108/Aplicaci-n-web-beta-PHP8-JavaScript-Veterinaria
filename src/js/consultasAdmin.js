import { limpiarHTMLConsultasAD, cargarHorasModal } from "./funciones";
(function () {
    const fechaAdmin = document.querySelector('#fechaAdmin');
    let consultasAdmin = [];

    /*********************************AREA DE EDITAR CONSULTAS EN EL  MODAL***************************************************/
    const fechaModalAD = document.querySelector('#fechaModalAD'); //tomar el id del select de fecha

    const horaIDModalAD = document.querySelectorAll('#horaIDModalAD');//Para tomar el id del select de horas

    const editarCitaModal = document.querySelector('#btnGuardar');//boton para editar la cita

    const tablaConsultasAd = document.querySelector('#tablaConsultasAd');

    let seleccionHoraAD; //aca depositaremos el value(id de la hora)

    // Obtén el select
    const selectModalHoraAD = document.getElementById("horaIDModalAD");

    if (fechaAdmin) {

        let seleccionFecha; //variable global para seleccionar la fecha
        fechaAdmin.addEventListener('change', e => { /* agregamos evento de cambio, cada que se cambie la fecha en el input esta se guardara en la variable 
                                                                seleccionFecha y se llamara la funcion para consultar las citas agendadas*/
            seleccionFecha = e.target.value;
            cargarConsultasDesdeAPI();
        });

        async function cargarConsultasDesdeAPI() {
            // Vaciamos el array
            consultasAdmin = [];

            try {
                const url = `/admin/TotalConsultas?fecha=${seleccionFecha}`;
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();

                consultasAdmin = resultado.consultas;

                console.log(consultasAdmin);

                mostrarConsultas();
            } catch (error) {
                console.log(error);
            }
        }

        function mostrarConsultas() {
            //llamamos funcion para limpiar el HTML y asi no habrian copias incesesarias.
            limpiarHTMLConsultasAD();
            formatearConsultas(consultasAdmin);
            const tbody = tablaConsultasAd.querySelector('tbody');
            consultasAdmin.forEach(consulta => {
                const fila = document.createElement('tr');

                const nombre = document.createElement('td');
                nombre.textContent = consulta.usuario;
                fila.appendChild(nombre);

                const mascota = document.createElement('td');
                mascota.textContent = consulta.mascota;
                fila.appendChild(mascota);

                const hora = document.createElement('td');
                hora.textContent = consulta.hora;
                fila.appendChild(hora);

                const motivo = document.createElement('td');
                motivo.textContent = consulta.motivo;
                fila.appendChild(motivo);

                const acciones = document.createElement('td');

                const botonActualizar = document.createElement('button');
                botonActualizar.textContent = 'Editar';
                botonActualizar.classList.add('btn', 'btn-primary', 'ms-2');
                botonActualizar.addEventListener('click', () => {
                    abrirModalActualizar({ ...consulta });
                });
                acciones.appendChild(botonActualizar);

                const botonEliminar = document.createElement('button');
                botonEliminar.textContent = 'Cancelar';
                botonEliminar.classList.add('btn', 'btn-danger', 'ms-2');
                botonEliminar.addEventListener('click', () => {
                    //funcion para eliminar Mascota
                    confirmarEliminarCita({ ...consulta });
                });

                acciones.appendChild(botonEliminar);

                fila.appendChild(acciones);

                tbody.appendChild(fila);
            });
        }

        //Formateamos las citas por default el array estara vacio
        function formatearConsultas(arrayUsuarios = []) {
            //.map(), crea un arreglo nuevo sin necesidad de mutar el original
            consultasAdmin = arrayUsuarios.map(consulta => {
                //nos retornara un objeto
                return {
                    usuario: consulta.usuario_id.nombre,
                    fecha: consulta.fecha,
                    id: consulta.id,
                    hora: consulta.horaID.hora,
                    mascota: consulta.mascota_id.nombre,
                    motivo: consulta.motivo
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

                    consultasAdmin = consultasAdmin.filter(citaMemoria => citaMemoria.id !== cita.id);
                    cargarConsultasDesdeAPI();
                }
            } catch (error) {
                console.log(error);
            }
        }

        function abrirModalActualizar(consulta) {
            // console.log(consulta);
            const citaId = consulta.id; // ID de la cita que deseas editar
            // console.log(consulta);
            fechaModalAD.value = consulta.fecha;
            // Carga las horas disponibles utilizando la fecha inicial
            cargarHorasModal(consulta.fecha, selectModalHoraAD);

            // Agrega un evento de cambio al input type:date para cargar las horas cuando cambie
            fechaModalAD.addEventListener('change', e => {
                let seleccionFecha = e.target.value;
                cargarHorasModal(seleccionFecha, selectModalHoraAD);
            });

            //(arrow function)
            horaIDModalAD.forEach(index => index.addEventListener('change', e => seleccionHoraAD = e.target.value));//Vamos a iterar en cada uno de ellos, para agregar un evento y capturar su id

            editarCitaModal.onclick = () => {
                const indiceCita = consultasAdmin.findIndex(consulta => consulta.id === citaId);
                editarValoresCita(indiceCita);
            };

            // Obtener referencia al modal y al modal body
            const modalActualizar = new bootstrap.Modal(document.querySelector('#modalActualizarCitaAD'));

            // Mostrar el modal
            modalActualizar.show();
        }

        async function editarValoresCita(indiceCita) {
            const cita = consultasAdmin[indiceCita];
    
            const nuevaFecha = fechaModalAD.value ? fechaModalAD.value : document.querySelector('#fechaModalAD').value;
            const nuevaHora = !seleccionHoraAD ? document.querySelector('#horaIDModalAD').value : seleccionHoraAD;

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

                    document.querySelector('#fechaModalAD').value = '';
                    document.querySelector('#horaIDModalAD').value = '';
                    return; // Detener la ejecución del código
                } else {
                    Swal.fire(
                        resultado.tipo,
                        resultado.mensaje,
                        'success'
                    );
                    consultasAdmin[indiceCita] = cita; // Reemplazar la mascota en el arreglo mascotas con la mascota editada
                    cargarConsultasDesdeAPI();
                    // Actualizar la información en la interfaz de usuario
                    mostrarConsultas(); // Volver a mostrar la tabla actualizada
                }

            } catch (error) {
                console.log(error);
            }

            document.querySelector('#fechaModalAD').value = '';
            document.querySelector('#horaIDModalAD').value = '';
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
                    //llamamos funcion para eliminar Mascota
                    eliminarCita(cita);
                }
            })
        }
    }
})();