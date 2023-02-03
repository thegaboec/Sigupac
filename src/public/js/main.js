import {CEDULA_REG_EXPRE} from '/src/public/js/modules/ConstExpres.js';
/**
 * Esta proceso perimite mostrar las contrasenias 
 */
(function(){
    const eye = document.querySelectorAll('#eye');
    if(!eye && eye.length === 0) return;
    eye.forEach( e => {
        e.addEventListener('click',convert);
    })

    function convert(e){
        e.preventDefault();
        let input = e.target.previousElementSibling;
        if(input.hasAttribute('text')){
            input.removeAttribute('text');
            input.type = 'password';
            e.target.parentNode.classList.add('raya');
        }else{
            input.setAttribute('text','');
            input.type = 'text';
            e.target.parentNode.classList.remove('raya');
        }
        
    }
})();

//-----------------------------------------------------------

/**
 * Este proceso permite mostrar una previualizacion de una imagen que va ser cambiada
 * por el logotipo principal
 */

(function(){
    const preview = document.getElementById('preview');
    if(!preview) return;
    const imput = document.getElementById('img-logo');

    imput.onchange = (e) => {
        const file = e.target.files[0];
        const fileReader = new FileReader();
        fileReader.readAsDataURL(file);

        fileReader.addEventListener('load' ,(e) => {
                const url = fileReader.result;

                let html = `
                    <h3> El logo actual se remplazara por la siguiente imagen selecionada </h3>
                    <img src="${url}">
                `;
                preview.innerHTML = html;
        })
    }
})();
//------------------------------------------------------------------
/**
 * Este proceso permite verificar que una cedula es ingresada correctamente
 */
(function(){
    const input = document.getElementById('cedula-verify');
    if(!input) return;
    const content = document.getElementById('error-cedula');
    const form = content.parentNode.parentNode;

    form.addEventListener('submit',send);
    input.addEventListener('input',write);
    if(document.getElementById('pasar')){
        form.removeEventListener('submit',send);
    }
    function write(e){
        const veri = CEDULA_REG_EXPRE.test(input.value);
        if(!veri){
            form.addEventListener('submit',send);
            content.style.display = 'inline';
            content.innerHTML ='';
            content.textContent = 'Error Ingrese una cédula válida';
        }else{
            content.style.display = 'none';
            form.removeEventListener('submit',send);
        }
    }

    function send(e){
        e.preventDefault();
    }

})();

//-------------------------------------------------------------------------

/**
 * ----------------------------------------Este proceso para ver la foto que se actualizara-----------------
 */

(function (){
    const preview2 = document.getElementById('preview2');
    if(!preview2) return;
    const imput = document.getElementById('img-logo');
    
    imput.onchange = (e) => {
        const file = e.target.files[0];
        const reader = new FileReader();
        reader.readAsDataURL(file);

        reader.addEventListener('load', e => {
            const url = reader.result;
            preview2.src = url;
        })

    }

    
})();

/**
 * Esta accion recargar la pagina
 */
(function(){
    const button = document.getElementById('reload-page');
    if(!button) return;
    button.addEventListener('click', e => {
        e.preventDefault();

        location.reload();
    })
})();


(function(){
    const select = document.getElementById('select-comercio');
    if(!select) return;

   select.onchange = (e) =>{
    e.preventDefault();
    select.setAttribute('name','contabilidad');
   }

})();