//API para cargar las horas y las mascotas disponibles segun la fecha seleccionada(CUANDO SE CREA UNA NUEVA CONSULTA)
export async function cargarHorasyMascotas(fechaSeleccionada, selectHora, selectMascota) {
    try {
        const url = `/horasU?fecha=${fechaSeleccionada}`; //escribimos a la url
        const respuesta = await fetch(url); //llamamos
        const resultado = await respuesta.json(); //respuesta de verHoras

        let datos = resultado.horasDisponibles;
        let Mascotas = resultado.mascotasDisponibles;

        console.log(resultado);

        //reiniciamos el select, cada que se llame la funcion
        selectHora.innerHTML = '';

        // Itera sobre los elementos del objeto y crea las opciones
        for (let key in datos) {
            if (datos.hasOwnProperty(key)) { // datos.hasOwnProperty(key) verifica si la clave actual es una propiedad directa del objeto datos
                let option = document.createElement("option"); // ceamos un option (DOM) para el select
                option.value = datos[key].id; //agregamos el id al valor del option ej: value="1"
                option.text = datos[key].hora; //agregamos texto al option, la hora
                selectHora.appendChild(option); //añadimos al select este option y asi susesivamente con los demas
                selectHora.value = '';
            }
        }

        //reiniciamos el select, cada que se llame la funcion
        selectMascota.innerHTML = '';

        // Itera sobre los elementos del objeto y crea las opciones
        for (let key in Mascotas) {
            if (Mascotas.hasOwnProperty(key)) { // datos.hasOwnProperty(key) verifica si la clave actual es una propiedad directa del objeto datos
                let option = document.createElement("option"); // ceamos un option (DOM) para el select
                option.value = Mascotas[key].id; //agregamos el id al valor del option ej: value="1"
                option.text = Mascotas[key].nombre; //agregamos texto al option, la hora
                selectMascota.appendChild(option); //añadimos al select este option y asi susesivamente con los demas
                selectMascota.value = '';
            }
        }
    } catch (error) {
        console.log(error);
    }
}
//API para cargar las horas y las mascotas disponibles segun la fecha seleccionada
export async function cargarHorasModal(fechaSeleccionada, selectHora) {
    try {
        const url = `/horasUModal?fecha=${fechaSeleccionada}`; //escribimos a la url
        const respuesta = await fetch(url); //llamamos
        const resultado = await respuesta.json(); //respuesta de verHoras
        // console.log(resultado);

        let datos = resultado.horasDisponibles;

        //reiniciamos el select, cada que se llame la funcion
        selectHora.innerHTML = '';

        // Itera sobre los elementos del objeto y crea las opciones
        for (let key in datos) {
            if (datos.hasOwnProperty(key)) { // datos.hasOwnProperty(key) verifica si la clave actual es una propiedad directa del objeto datos
                let option = document.createElement("option"); // ceamos un option (DOM) para el select
                option.value = datos[key].id; //agregamos el id al valor del option ej: value="1"
                option.text = datos[key].hora; //agregamos texto al option, la hora
                selectHora.appendChild(option); //añadimos al select este option y asi susesivamente con los demas
                selectHora.value = '';
            }
        }
    } catch (error) {
        console.log(error);
    }
}
//Limpia el HTML en la seccion de consultas
export function limpiarHTMLConsultas() {
    //seleccionamos el id de la tabla donde vamos a inyectar las mascotas
    const tablaCitas = document.querySelector('#tablaCitas');
    const thead = tablaCitas.querySelector('thead');
    const tbody = tablaCitas.querySelector('tbody');

    //mientras haya elmentos
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }

    while (thead.firstChild) {
        thead.removeChild(thead.firstChild);
    }
}
//Limpia el HTML en la seccion de consultas
export function limpiarHTMLConsultasAD() {
    //seleccionamos el id de la tabla donde vamos a inyectar las mascotas
    const tablaCitas = document.querySelector('#tablaConsultasAd');
    const tbody = tablaCitas.querySelector('tbody');

    //mientras haya elmentos
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
}
//limpia el HTML en la seccion de mascotas
export function limpiarHTMLMascotas() {
    //seleccionamos el id de la tabla donde vamos a inyectar las mascotas
    const tablaMascotas = document.querySelector('#tablaMascotas');
    const tbody = tablaMascotas.querySelector('tbody');

    //mientras haya elmentos
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
}

/*************************************************PANEL DE ADMIN***************************************************************/

export async function mostrarMascotasAD(usuarioSeleccionado, selectMascota) {
    try {
        const url = `/admin/TotalMascotas?usuario_id=${usuarioSeleccionado}`;
        const respuesta = await fetch(url); //llamamos
        const resultado = await respuesta.json(); //respuesta de verHoras
        // console.log(resultado);

        let datos = resultado.mascotasDisponibles;

        //reiniciamos el select, cada que se llame la funcion
        selectMascota.innerHTML = '';

        // Itera sobre los elementos del objeto y crea las opciones
        for (let key in datos) {
            if (datos.hasOwnProperty(key)) { // datos.hasOwnProperty(key) verifica si la clave actual es una propiedad directa del objeto datos
                let option = document.createElement("option"); // ceamos un option (DOM) para el select
                option.value = datos[key].id; //agregamos el id al valor del option ej: value="1"
                option.text = datos[key].nombre; //agregamos texto al option, la hora
                selectMascota.appendChild(option); //añadimos al select este option y asi susesivamente con los demas
                selectMascota.value = '';
            }
        }
    } catch (error) {
        console.log(error);
    }
}