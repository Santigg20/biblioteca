/**
 * Valida los campos de título, autor e ISBN antes de enviar el formulario.
 *
 * @param {string} titulo Título ingresado del libro.
 * @param {string} autor  Autor ingresado del libro.
 * @param {string} isbn   ISBN ingresado del libro.
 * @returns {boolean} True si los datos son válidos, false si hay algún error.
 */
function validarDatosLibro(titulo, autor, isbn) {
    if (titulo === "" || autor === "" || isbn === "") {
        alert('Por favor, rellena todos los campos antes de guardar.');
        return false;
    }

    // Validación simple para que el formato ISBN no contenga caracteres extraños
    if (isbn.length < 10) {
        alert('El campo ISBN parece demasiado corto o inválido.');
        return false;
    }

    return true;
}

/**
 * Revisa los parámetros de la URL y muestra una notificación si el libro se registró.
 *
 * @param {string} searchQuery Cadena de consulta de la URL (`window.location.search`).
 * @returns {boolean} True si se detectó el parámetro de registro exitoso.
 */
function verificarRegistroExitoso(searchQuery) {
    const urlParams = new URLSearchParams(searchQuery);

    if (urlParams.get('success') === '1') {
        // Limpiar el parámetro de la URL estética
        window.history.replaceState({}, document.title, window.location.pathname);
        alert('¡Libro registrado con éxito en el inventario!');
        return true;
    }

    return false;
}

/**
 * Inicializa los eventos del formulario y la revisión de notificaciones al cargar el DOM.
 */
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formLibro');

    form.addEventListener('submit', (e) => {
        const titulo = document.getElementById('titulo').value.trim();
        const autor = document.getElementById('autor').value.trim();
        const isbn = document.getElementById('isbn').value.trim();

        if (!validarDatosLibro(titulo, autor, isbn)) {
            e.preventDefault(); // Detiene el envío del formulario
        }
    });

    verificarRegistroExitoso(window.location.search);
});