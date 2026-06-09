document.addEventListener('DOMContentLoaded', () => {
    const filtroMarca = document.getElementById('filtro-marca');
    const filtroCategoria = document.getElementById('filtro-categoria');
    const filtroPrecio = document.getElementById('filtro-precio');
    const btnLimpiar = document.getElementById('btn-limpiar');
    const contenedorSinResultados = document.getElementById('sin-resultados');
    const tarjetasProductos = document.querySelectorAll('.card-auto');

    function filtrarProductos() {
        const marcaSeleccionada = filtroMarca.value;
        const catSeleccionada = filtroCategoria.value;
        const precioSeleccionado = filtroPrecio.value;
        
        let visibles = 0;

        tarjetasProductos.forEach(tarjeta => {
            const prodMarca = tarjeta.getAttribute('data-marca');
            const prodCat = tarjeta.getAttribute('data-categoria');
            const prodPrecio = tarjeta.getAttribute('data-precio');

            const coincideMarca = (marcaSeleccionada === 'todos' || prodMarca === marcaSeleccionada);
            const coincideCategoria = (catSeleccionada === 'todos' || prodCat === catSeleccionada);
            const coincidePrecio = (precioSeleccionado === 'todos' || prodPrecio === precioSeleccionado);

            if (coincideMarca && coincideCategoria && coincidePrecio) {
                tarjeta.style.display = 'flex';
                visibles++;
            } else {
                tarjeta.style.display = 'none';
            }
        });

        contenedorSinResultados.style.display = (visibles === 0) ? 'block' : 'none';
    }

    if(filtroMarca) filtroMarca.addEventListener('change', filtrarProductos);
    if(filtroCategoria) filtroCategoria.addEventListener('change', filtrarProductos);
    if(filtroPrecio) filtroPrecio.addEventListener('change', filtrarProductos);

    if(btnLimpiar) {
        btnLimpiar.addEventListener('click', () => {
            filtroMarca.value = 'todos';
            filtroCategoria.value = 'todos';
            filtroPrecio.value = 'todos';
            filtrarProductos();
        });
    }
});

// MODAL DINÁMICO DE PRODUCTOS
function verDetallesProducto(element) {
    const card = element.closest('.card-auto');
    
    const nombre = card.getAttribute('data-nombre');
    const precio = card.getAttribute('data-precio-full');
    const foto1 = card.getAttribute('data-foto1');
    const foto2 = card.getAttribute('data-foto2');
    const desc = card.getAttribute('data-desc');
    const specs = JSON.parse(card.getAttribute('data-specs'));

    document.getElementById('m-titulo').innerText = nombre;
    document.getElementById('m-descripcion').innerText = desc;
    document.getElementById('m-precio').innerText = precio;
    document.getElementById('m-img1').src = foto1;
    document.getElementById('m-img2').src = foto2;

    // Limpiar y poblar especificaciones
    const contenedorSpecs = document.getElementById('m-specs-contenedor');
    contenedorSpecs.innerHTML = "";
    
    specs.forEach(spec => {
        const parts = spec.split(':');
        const item = document.createElement('div');
        item.className = 'tech-item';
        item.innerHTML = `<strong>${parts[0]}:</strong> <span>${parts[1] || ''}</span>`;
        contenedorSpecs.appendChild(item);
    });

    document.getElementById('custom-modal').style.display = 'flex';
}

function cerrarFichaModal() {
    document.getElementById('custom-modal').style.display = 'none';
}

// OPERATORIA BURBUJA DE INTELIGENCIA ARTIFICIAL
function toggleAIChat() {
    const chatWindow = document.getElementById('ai-chat');
    chatWindow.style.display = (chatWindow.style.display === 'flex') ? 'none' : 'flex';
}

function enviarMensajeIA() {
    const input = document.getElementById('ai-input');
    const bodyContent = document.getElementById('ai-body-content');
    
    if(input.value.trim() === "") return;

    // Mensaje de usuario
    const userPara = document.createElement('p');
    userPara.className = 'ai-msg-user';
    userPara.innerText = input.value;
    bodyContent.appendChild(userPara);
    
    const consulta = input.value.toLowerCase();
    input.value = "";
    bodyContent.scrollTop = bodyContent.scrollHeight;
    
    // Respuesta Predictiva de la IA de Farmacia
    setTimeout(() => {
        const botPara = document.createElement('p');
        botPara.className = 'ai-msg-bot';
        
        if(consulta.includes('precio') || consulta.includes('ars') || consulta.includes('cuanto cuesta')) {
            botPara.innerText = "Los valores exhibidos se encuentran actualizados en pesos argentinos (ARS) e incluyen la tasa impositiva. Si realizás una orden corporativa de más de 5 unidades, puedo tramitarte un 10% de descuento metalizado base.";
        } else if(consulta.includes('receta') || consulta.includes('medico') || consulta.includes('dermo')) {
            botPara.innerText = "Nuestra línea dermocosmética y los dispositivos de diagnóstico Omron son de venta libre y cuentan con aprobación de ANMAT. Para compuestos que requieran prescripción, disponemos de una sección de carga de recetas digitales.";
        } else {
            botPara.innerText = "He analizado tu consulta en nuestro vademécum inteligente. Todas las opciones mostradas en el showroom cuentan con almacenamiento en atmósfera controlada de laboratorio. ¿Querés que verifique stock de alguna marca en particular?";
        }
        
        bodyContent.appendChild(botPara);
        bodyContent.scrollTop = bodyContent.scrollHeight;
    }, 1000);
}