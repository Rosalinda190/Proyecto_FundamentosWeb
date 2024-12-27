document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function (e) {
        const inputs = form.querySelectorAll('input[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (input.value.trim() === '') {
                isValid = false;
                alert(`El campo ${input.name} es obligatorio.`);
            }

            if (input.name === 'email' && !input.value.match(/^\S+@\S+\.\S+$/)) {
                isValid = false;
                alert('Por favor, introduce un correo válido.');
            }
        });

        if (!isValid) e.preventDefault(); 
    });
});

function filtrarRecetas(tipo, valor) {
    const recetas = document.querySelectorAll('.receta');

    recetas.forEach(receta => {
        const filtroNivel = receta.getAttribute('filtro-nivel');
        const filtroCategoria = receta.getAttribute('filtro-categoria');

        if (tipo === 'todos') {
            receta.style.display = 'block';
        } else if (tipo === 'nivel' && filtroNivel === valor) {
            receta.style.display = 'block';
        } else if (tipo === 'categoria' && filtroCategoria === valor) {
            receta.style.display = 'block';
        } else {
            receta.style.display = 'none';
        }
    });
}

document.querySelectorAll('.Filtros button').forEach(button => {
    button.addEventListener('click', function () {
        const tipo = this.dataset.tipo;
        const valor = this.dataset.valor; 
        filtrarRecetas(tipo, valor);
    });
});

document.querySelectorAll('.Eliminar').forEach(button => {
    button.addEventListener('click', function (e) {
        const isConfirmed = confirm("¿Estás seguro de que deseas eliminar esta receta?");
        if (!isConfirmed) {
            e.preventDefault(); 
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.Eliminar').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        
        const tipo = this.dataset.type;
        let mensaje = tipo === 'blog' ? "¿Estás seguro de eliminar este blog?" : "¿Estás seguro de eliminar esta receta?";
        
        if(confirm(mensaje)) {
          window.location.href = this.href;
        }
      });
    });
  });

const estrellas = document.querySelectorAll('.star-rating input');
if (estrellas) {
    estrellas.forEach(estrella => {
        estrella.addEventListener('change', function () {
            const rating = this.value;
            console.log(`Rating seleccionado: ${rating}`);
        });
    });
}




