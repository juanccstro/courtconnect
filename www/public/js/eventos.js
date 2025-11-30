//  Filtros y ordenación tabla participantes (Evento Show)

document.addEventListener("DOMContentLoaded", () => {

    const table = document.getElementById("tablaParticipantes");
    if (!table) return; // Si no existe esta vista, no ejecuta nada

    const rows = Array.from(table.querySelectorAll("tbody tr"));

    const filterNombre = document.getElementById("filterNombre");
    const filterPosicion = document.getElementById("filterPosicion");
    const filterEdad = document.getElementById("filterEdad");

    // Filtros
    function applyFilters() {
        const nombreVal = filterNombre.value.toLowerCase();
        const posVal = filterPosicion.value;
        const edadVal = filterEdad.value;

        rows.forEach(row => {
            const nombre = row.children[0].textContent.toLowerCase();
            const pos = row.children[1].textContent;
            const edad = parseInt(row.children[2].textContent);

            let visible = true;

            if (nombreVal && !nombre.includes(nombreVal)) visible = false;
            if (posVal && pos !== posVal) visible = false;
            if (edadVal && edad < edadVal) visible = false;

            row.style.display = visible ? "" : "none";
        });
    }

    if (filterNombre) filterNombre.addEventListener("input", applyFilters);
    if (filterPosicion) filterPosicion.addEventListener("change", applyFilters);
    if (filterEdad) filterEdad.addEventListener("input", applyFilters);


    // Ordenación
    let sortDirection = 1;

    document.querySelectorAll(".sortable").forEach(header => {
        header.addEventListener("click", () => {
            const col = header.dataset.col;
            const index = { nombre: 0, posicion: 1, edad: 2 }[col];

            rows.sort((a, b) => {
                const valA = a.children[index].textContent;
                const valB = b.children[index].textContent;

                if (!isNaN(valA) && !isNaN(valB)) {
                    return (parseInt(valA) - parseInt(valB)) * sortDirection;
                }

                return valA.localeCompare(valB) * sortDirection;
            });

            sortDirection *= -1;

            const tbody = table.querySelector("tbody");
            tbody.innerHTML = "";
            rows.forEach(r => tbody.appendChild(r));
        });
    });

});
