import { limpiarHTMLMascotas } from "./funciones";
(function () {
    //creamos funcion para llamar las Mascotas desde otra url y traelas
    //global de mascotas que va a ser util para almacenar las tareas
    const tablaMascotas = document.querySelector('#tablaMascotas');
    if (tablaMascotas) {
        let mascotas = [];
        obtenerMascotas();
        async function obtenerMascotas() {
            try {
                //vamos a consultar
                const url = '/mascotas/vermascotas';
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();

                //guardamos las Mascotas en el arreglo
                mascotas = resultado.mascotas;
                // console.log(mascotas);

                //mandamos a llamar funcion para mostar las mascotas en pantalla
                mostrarMascotas();

            } catch (error) {
                console.log(error);
            }
        }

        //funcion para mostar las mascotas en pantalla
        //usamos Scripting
        function mostrarMascotas() {
            //llamamos funcion para limpiar el HTML y asi no habrian copias incesesarias.
            limpiarHTMLMascotas();

            //seleccionamos el id de la tabla donde vamos a inyectar las mascotas
            const tablaMascotas = document.querySelector('#tablaMascotas');
            const tbody = tablaMascotas.querySelector('tbody');

            mascotas.forEach(mascota => {
                const fila = document.createElement('tr');

                const nombre = document.createElement('td');
                nombre.textContent = mascota.nombre;
                fila.appendChild(nombre);

                const especie = document.createElement('td');
                especie.textContent = mascota.especie;
                fila.appendChild(especie);

                const nacimiento = document.createElement('td');
                nacimiento.textContent = mascota.nacimiento;
                fila.appendChild(nacimiento);

                const acciones = document.createElement('td');

                const botonHistoriaClinica = document.createElement('button');
                botonHistoriaClinica.textContent = 'Historial';
                botonHistoriaClinica.classList.add('btn', 'btn-warning');
                botonHistoriaClinica.addEventListener('click', () => {
                    abrirModalActualizar({ ...mascota });
                });
                acciones.appendChild(botonHistoriaClinica);

                const botonActualizar = document.createElement('button');
                botonActualizar.textContent = 'Editar';
                botonActualizar.classList.add('btn', 'btn-primary', 'ms-2');
                botonActualizar.addEventListener('click', () => {
                    abrirModalActualizar({ ...mascota });
                });
                acciones.appendChild(botonActualizar);

                const botonEliminar = document.createElement('button');
                botonEliminar.textContent = 'Borrar';
                botonEliminar.classList.add('btn', 'btn-danger', 'ms-2');
                botonEliminar.addEventListener('click', () => {
                    //funcion para eliminar Mascota
                    confirmarEliminarMascota({ ...mascota });
                });

                acciones.appendChild(botonEliminar);

                fila.appendChild(acciones);

                tbody.appendChild(fila);
            });
        }

        async function eliminarMascota(mascota) {
            //Destructuring
            const { id, nombre, nacimiento, especie, raza, color, sexo } = mascota;

            //FormData
            const datos = new FormData();
            //vamos construyendo nuestra peticion
            datos.append('id', id);
            datos.append('nombre', nombre);
            datos.append('nacimiento', nacimiento);
            datos.append('especie', especie);
            datos.append('raza', raza);
            datos.append('color', color);
            datos.append('sexo', sexo);

            try {
                const url = '/mascotas/eliminarmascota'
                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.resultado) {

                    Swal.fire('Eliminado!', resultado.mensaje, 'success');
                    //.filter() va a crear un arreglo, va a sacar todos excepto uno
                    //o uno excepto todos 
                    //aca nos va a traer todas las tareas que sean diferentes a mascotaMemoria.id
                    mascotas = mascotas.filter(mascotaMemoria => mascotaMemoria.id !== mascota.id);
                    mostrarMascotas();
                }

            } catch (error) {
                console.log(error);
            }
        }

        //Funcion del Modal para actualizar datos de la mascota
        //Va a mostar el modal con los datos de la mascota
        function abrirModalActualizar(mascota) {

            const mascotaId = mascota.id; // ID de la mascota que deseas editar

            // Obtener referencia al modal y al modal body
            const modalActualizar = new bootstrap.Modal(document.querySelector('#modalActualizar'));
            const modalBody = document.querySelector('#modalBody');

            // Limpiar contenido anterior del modal body
            modalBody.innerHTML = '';

            // Crear elementos del formulario
            const form = document.createElement('form');

            const nombreDiv = document.createElement('div');
            const nombreLabel = document.createElement('label');
            const nombreInput = document.createElement('input');

            const especieDiv = document.createElement('div');
            const especieLabel = document.createElement('label');
            const especieInput = document.createElement('input');

            const nacimientoDiv = document.createElement('div');
            const nacimientoLabel = document.createElement('label');
            const nacimientoInput = document.createElement('input');

            const razaDiv = document.createElement('div');
            const razaLabel = document.createElement('label');
            const razaInput = document.createElement('input');

            const colorDiv = document.createElement('div');
            const colorLabel = document.createElement('label');
            const colorInput = document.createElement('input');

            const sexoDiv = document.createElement('div');
            const sexoLabel = document.createElement('label');
            const sexoInput = document.createElement('input');

            //***************************************************************//
            //Clases 
            nombreLabel.classList.add('form-label');
            nombreInput.classList.add('form-control');
            nombreDiv.classList.add('mb-3');

            // Configurar atributos y propiedades de los elementos
            //Nombre
            nombreLabel.textContent = 'Nombre:';
            nombreLabel.setAttribute('for', 'nombre');
            nombreInput.type = 'text';
            nombreInput.name = 'nombre';
            nombreInput.id = 'nombre';
            nombreInput.value = mascota.nombre;

            //clases
            especieLabel.classList.add('form-label');
            especieInput.classList.add('form-control');
            especieDiv.classList.add('mb-3');

            //Especie
            especieLabel.textContent = 'Especie:';
            especieLabel.setAttribute('for', 'especie');
            especieInput.type = 'text';
            especieInput.name = 'especie';
            especieInput.id = 'especie';
            especieInput.value = mascota.especie;

            //clases

            nacimientoLabel.classList.add('form-label');
            nacimientoInput.classList.add('form-control');
            nacimientoDiv.classList.add('mb-3');

            //Nacimiento
            nacimientoLabel.textContent = 'Fecha de nacimiento:';
            nacimientoLabel.setAttribute('for', 'nacimiento');
            nacimientoInput.type = 'date';
            nacimientoInput.name = 'nacimiento';
            nacimientoInput.id = 'nacimiento';
            nacimientoInput.value = mascota.nacimiento;
            nacimientoDiv.classList.add('mb-3');

            //clases
            colorLabel.classList.add('form-label');
            colorInput.classList.add('form-control');
            colorDiv.classList.add('mb-3');

            //Color
            colorLabel.textContent = 'Color:';
            colorLabel.setAttribute('for', 'color');
            colorInput.type = 'text';
            colorInput.name = 'color';
            colorInput.id = 'color';
            colorInput.value = mascota.color;

            //clases
            razaLabel.classList.add('form-label');
            razaInput.classList.add('form-control');
            razaDiv.classList.add('mb-3');

            //raza
            razaLabel.textContent = 'Raza:';
            razaLabel.setAttribute('for', 'raza');
            razaInput.type = 'text';
            razaInput.name = 'raza';
            razaInput.id = 'raza';
            razaInput.value = mascota.raza;

            //clases
            sexoLabel.classList.add('form-label');
            sexoInput.classList.add('form-control');
            sexoDiv.classList.add('mb-3');

            //Sexo
            sexoLabel.textContent = 'Sexo:';
            sexoLabel.setAttribute('for', 'sexo');
            sexoInput.type = 'text';
            sexoInput.name = 'sexo';
            sexoInput.id = 'sexo';
            sexoInput.value = mascota.sexo;
            //***************************************************************//

            //***************************************************************//
            // Agregar elementos al formulario
            //Nombre
            nombreDiv.appendChild(nombreLabel);
            nombreDiv.appendChild(nombreInput);
            form.appendChild(nombreDiv);

            //Especie
            especieDiv.appendChild(especieLabel);
            especieDiv.appendChild(especieInput);
            form.appendChild(especieDiv);

            //Nacimiento
            nacimientoDiv.appendChild(nacimientoLabel);
            nacimientoDiv.appendChild(nacimientoInput);
            form.appendChild(nacimientoDiv);

            //Raza
            razaDiv.appendChild(razaLabel);
            razaDiv.appendChild(razaInput);
            form.appendChild(razaDiv);

            //Color
            colorDiv.appendChild(colorLabel);
            colorDiv.appendChild(colorInput);
            form.appendChild(colorDiv);

            //Sexo
            sexoDiv.appendChild(sexoLabel);
            sexoDiv.appendChild(sexoInput);
            form.appendChild(sexoDiv);
            //***************************************************************//

            // Agregar formulario al modal body
            modalBody.appendChild(form);

            // Mostrar el modal
            modalActualizar.show();

            //Si se da click al boton de guardar
            //Funcion para Editar los datos de la mascota
            // Si ya hay un evento click registrado en el botón de guardar, eliminarlo
            //Para que no se acumulen múltiples eventos y se realicen múltiples llamadas a la función
            // En este código, se utiliza addEventListener para registrar el evento click en el botón de guardar por primera vez.Luego, dentro de la función abrirModalActualizar(), se verifica si ya existe un evento click registrado en el botón.Si es así, se elimina ese evento usando removeEventListener antes de agregar el nuevo evento.
            //De esta manera, te aseguras de que solo haya un evento click registrado en el botón de guardar en todo momento, evitando la acumulación de eventos y llamadas duplicadas a la función editarValoresMascota().
            // Puedes hacer simplemente
            const editarMascota = document.querySelector('#btnGuardar');
            editarMascota.onclick = () => {
                const indiceMascota = mascotas.findIndex(mascota => mascota.id === mascotaId);
                editarValoresMascota(indiceMascota);
            };
        }

        async function editarValoresMascota(indiceMascota) {
            const mascota = mascotas[indiceMascota];

            // Obtener los nuevos valores del formulario
            const nombreInput = document.querySelector('#nombre');
            const especieInput = document.querySelector('#especie');
            const nacimientoInput = document.querySelector('#nacimiento');
            const colorInput = document.querySelector('#color');
            const razaInput = document.querySelector('#raza');
            const sexoInput = document.querySelector('#sexo');

            const nuevoNombre = nombreInput.value;
            const nuevaEspecie = especieInput.value;
            const nuevoNacimiento = nacimientoInput.value;
            const nuevoColor = colorInput.value;
            const nuevaRaza = razaInput.value;
            const nuevoSexo = sexoInput.value;

            // Verificar si alguno de los campos está vacío
            if (!nuevoNombre || !nuevaEspecie || !nuevoNacimiento || !nuevoColor || !nuevaRaza || !nuevoSexo) {
                Swal.fire(
                    'Error',
                    'Por favor, completa todos los campos',
                    'error'
                );
                return; // Detener la ejecución del código
            }

            // Actualizar los valores de la mascota en el arreglo mascotas
            mascota.nombre = nuevoNombre;
            mascota.especie = nuevaEspecie;
            mascota.nacimiento = nuevoNacimiento;
            mascota.color = nuevoColor;
            mascota.raza = nuevaRaza;
            mascota.sexo = nuevoSexo;

            //Creamos la Peticion
            //FormData
            const datos = new FormData();
            // vamos construyendo nuestra peticion
            datos.append('id', mascota.id);
            datos.append('nombre', mascota.nombre);
            datos.append('nacimiento', mascota.nacimiento);
            datos.append('especie', mascota.especie);
            datos.append('raza', mascota.raza);
            datos.append('color', mascota.color);
            datos.append('sexo', mascota.sexo);



            try {
                const url = '/mascotas/editarmascota'
                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.resultado) {
                    Swal.fire('Se Ha Editado!', resultado.mensaje, 'success');
                    //aca nos va a traer todas las tareas que sean diferentes a tareaMemoria.id
                    mascotas[indiceMascota] = mascota; // Reemplazar la mascota en el arreglo mascotas con la mascota editada
                }

            } catch (error) {
                console.log(error);
            }

            // Actualizar la información en la interfaz de usuario
            mostrarMascotas(); // Volver a mostrar la tabla actualizada
        }
        //*****************************************************//
        //Funcion para mensaje de confirmacion de eliminar mascota
        function confirmarEliminarMascota(mascota) {
            Swal.fire({
                title: 'Eliminar Mascota?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'NO'
            }).then((result) => {
                //validamos que si se haya dado click en eliminar
                if (result.isConfirmed) {
                    //llamamos funcion para eliminar Mascota
                    eliminarMascota(mascota);
                }
            })
        }
    }
})();