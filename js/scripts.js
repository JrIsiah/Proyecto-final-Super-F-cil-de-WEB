let contador = 1;

function agregarArticulo() {
    contador++;
    const div = document.createElement('div');
    div.classList.add('articulo');
    div.innerHTML = `
        <label for="articulo_${contador}">Artículo ${contador}:</label>
        <input type="text" name="items[${contador}][articulo_id]" required><br>
        <label for="cantidad_${contador}">Cantidad:</label>
        <input type="number" name="items[${contador}][cantidad]" required><br>
        <label for="precio_${contador}">Precio:</label>
        <input type="number" name="items[${contador}][precio]" required><br>
        <label for="total_${contador}">Total:</label>
        <input type="number" name="items[${contador}][total]" required><br>
    `;
    document.getElementById('articulos').appendChild(div);
}