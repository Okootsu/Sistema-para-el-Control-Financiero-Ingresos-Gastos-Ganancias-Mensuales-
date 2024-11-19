// Funcion para mostrar el fomulario de ingresos
const modal_ingresos = document.querySelector("#modal_ingresos");
function abrir_ingresos() {
    modal_ingresos.showModal();
    modal_opciones.close();
}
function cerrar_ingresos() {
    modal_ingresos.close();
}

// Funcion para mostrar el fomulario de gastos
const modal_gastos = document.querySelector("#modal_gastos");
function abrir_gastos() {
    modal_gastos.showModal();
    modal_opciones.close();
}
function cerrar_gastos() {
    modal_gastos.close();
}

// Funcion para mostrar el modal de las opciones
const modal_opciones = document.querySelector("#modal_opciones");
function abrir_opciones() {
    modal_opciones.showModal();
}
function cerrar_opciones() {
    modal_opciones.close();
}

// Funcion para eliminar los registros de la tabla de ingresos
function eliminar_ingreso(id) {
    if (confirm("¿Desea realizar esta accion? esta operacion es irreversible")) {
        window.location.href= "eliminar_registro_ingreso.php?id=" + id;
    }
}

// Funcion para eliminar los registros de la tabla de gastos
function eliminar_gasto(id) {
    if (confirm("¿Desea realizar esta accion? esta operacion es irreversible")) {
        window.location.href= "php/eliminar_registro_gasto.php?id=" + id;
    }
}

// Funcion para eliminar usuario
function eliminar_usuario(id) {
    if (confirm("¿Desea realizar esta accion? esta operacion es irreversible")) {
        window.location.href= "php/eliminar_usuario.php?id=" + id;
    }
}

// Seleccionamos todos los campos con las clases especificadas
var tasaBCVElements = document.getElementsByClassName('tasa_bcv');
var montoDolaresElements = document.getElementsByClassName('monto_dolares');
var montoBolivaresElements = document.getElementsByClassName('monto_bolivares');
    
// Añadimos eventos de escucha a todos los campos relevantes
for (var i = 0; i < tasaBCVElements.length; i++) {
    tasaBCVElements[i].addEventListener('input', calcularBolivares);
    montoDolaresElements[i].addEventListener('input', calcularBolivares);
}

// Función genérica para calcular los bolívares
function calcularBolivares() {
    for (var i = 0; i < tasaBCVElements.length; i++) {
        var tasaBCV = parseFloat(tasaBCVElements[i].value) || 0;
        var montoDolares = parseFloat(montoDolaresElements[i].value) || 0;
        var montoBolivares = tasaBCV * montoDolares;
        montoBolivaresElements[i].value = montoBolivares.toFixed(2);
    }
}