//Funcion para inicializar la pantalla admin
function initApp() {

    fetchComandas();

    fetchProductos();

}
// Fetch a la BD para obtener las comandas del dia actual
// Se ejecuta al inicializar la app "initApp()"
function fetchComandas() {
    fetch("index.php?controller=comandas&action=fetchComandas")
        .then(res => res.json())
        .then(function (json) {
            
            console.log(json);
            comandas = json.comandas;
            imprimirComandas(comandas);
    });
}

// Fetch a la BD para obtener todos los productos
// Se ejecuta al inicializar la app "initApp()"
function fetchProductos(){
    fetch("index.php?controller=productos&action=fetchProductos")
        .then(res => res.json())
        .then(function (json) {
            
            console.log(json);
            productos = json.productos;
            imprimirProductos(productos);
    });
}

// Funcion para mostrar las comandas con los detalles, comprueba el dia de las comandas y solo muestra las del dia actual
/* Addeventlistener al cambiar de estado los checkbox "comanda feta" a marcado o desmarcado, 
* comprueba si esta marcado o desmarcado y le pasa un objecto con el ID de la comanda y un numero boolean dependiendo el estado del checkbox,
* se convierte el objeto en un string JSON y se pasa por parametro a la funcion checked()
*/
// Se ejecuta al obtener el JSON del "fetchComandas()"
function imprimirComandas(comandas) {

    let htmlstr = `<div class="grid-item">`;

    htmlstr += `<div class="grid-containerAdminItems">`;

    htmlstr += `<div class="grid-item">`;
    htmlstr += "<b>ID Comanda</b><br><br>";
    htmlstr += `</div>`;

    htmlstr += `<div class="grid-item">`;
    htmlstr += "<b>Email Usuari</b><br><br>";
    htmlstr += `</div>`;

    htmlstr += `<div class="grid-item">`;
    htmlstr += "<b>Veure detalls</b><br><br>";
    htmlstr += `</div>`;

    htmlstr += `<div class="grid-item">`;
    htmlstr += "<b>Comanda Feta</b><br><br>";
    htmlstr += `</div>`;

    htmlstr += `</div>`;
    htmlstr += `</div>`;

    
    htmlstr += `</div>`;
    
    let date = new Date();
    let dia = date.getDate();
    let mes = date.getMonth() + 1;
    let any = date.getFullYear();

    let fechaActual = any + "-" + mes + "-" + dia;

    

    for (let i = 0; i < comandas.length; i++) {
                
        console.log(comandas[i].dataComanda + " - " +  fechaActual);
        if(comandas[i].dataComanda == fechaActual){

            htmlstr += `<div class="grid-containerAdminItems">`;

            htmlstr += `<div class="grid-item">`;
            htmlstr += comandas[i].id_Comanda + "<br>";
            htmlstr += `</div>`;

            htmlstr += `<div class="grid-item">`;
            htmlstr += comandas[i].emailUser + "<br>";
            htmlstr += `</div>`;

            htmlstr += `<div class="grid-item">`;
            htmlstr += `<details>`;
            htmlstr += "<summary>Detalls</summary>";
            htmlstr += `<p><b>Nom: </b>` + comandas[i].nomUser + `</p>`;
            htmlstr += `<p><b>Telefon: </b>` + comandas[i].telefonUser + `</p>`;
            htmlstr += `<p><b>Data: </b>` + comandas[i].dataComanda + `</p>`;
            htmlstr += `<p><b>Productes: </b></p>`;
            for (let j = 0; j < comandas[i].lineasComanda.length; j++) {
                htmlstr += `<p> - ` + comandas[i].lineasComanda[j].nomProducto + ` x` + comandas[i].lineasComanda[j].cantitat + `</p>`; 
            }
            htmlstr += `<p><b>Preu Total: </b>` + comandas[i].preuTotal + ` €</p>`;
            htmlstr += `<p><b>Comentaris: </b>` + comandas[i].comentari + `</p>`;
            htmlstr += `</details><br>`;
            htmlstr += `</div>`;

            htmlstr += `<div class="grid-item">`;
            if(comandas[i].comandaFeta == 0){
                htmlstr += `<input type="checkbox" id="fet` + i + `" value="` + comandas[i].id_Comanda + `">`;
            }
            else {
                htmlstr += `<input type="checkbox" id="fet` + i + `" checked value="` + comandas[i].id_Comanda + `">`;
            }
            htmlstr += "<br>";
            htmlstr += `</div>`;

            htmlstr += `</div>`;
            htmlstr += `</div>`;

        }
    }

    document.getElementById("grid").innerHTML = htmlstr;

    document.getElementById("grid").addEventListener("change", function(e) {

        console.log(e.target.checked);

        if(e.target.checked){
            console.log(e.target.value);
            console.log("checked");

            let obj = new Object();
            obj.id = e.target.value;
            obj.num = 1;
            let data = JSON.stringify(obj);
            checked(data);
        }
        else {
            console.log("no checked");

            let obj = new Object();
            obj.id = e.target.value;
            obj.num = 0;
            let data = JSON.stringify(obj);
            checked(data);
        }

    })

}

// Funcion que recibe un objeto convertido en una string JSON por parametro
// Fetch para actualizar la BD, se envian datos por POST al PHP
// Se ejecuta al pulsar la checkbox de una comanda "addeventlistener("change")"

function checked(data) {
    fetch("index.php?controller=comandas&action=updateFet", {
        method: 'POST',
        body: data
     });
}

// Funcion para mostrar una lista de los productos, crea un formulario para poder actualizar los datos de los productos
/* Addeventlistener("click") al pulsar "Actualitzar dades",
* coge todos los datos de los campos y los convierte en un objecto el cual se convierte en una string JSON,
* para pasarselo por parametro a la funcion updateDades()
*/
/* Addeventlistener("change") al cambiar de estado los checkbox "producte habilitat" a habilitado o deshabilitado,
* comprueba si esta marcado o desmarcado y le pasa un objecto con el ID de la comanda y un numero boolean dependiendo el estado del checkbox,
* se convierte el objeto en un string JSON y se pasa por parametro a la funcion active()
*/
// Se ejecuta al obtener el JSON del "fetchProductos()"
function imprimirProductos(productos) {

    let itemsSelectProductos = `<label>Selecciona el producte a modificar: </label><select name="selectProd" id="selectProd">`;

    let htmlstr = `<div class="grid-item">`;

    htmlstr += `<div class="grid-containerAdminProductes">`;

    htmlstr += `<div class="grid-item">`;
    htmlstr += "<b>Nom</b><br><br>";
    htmlstr += `</div>`;

    htmlstr += `<div class="grid-item">`;
    htmlstr += "<b>Descripcio</b><br><br>";
    htmlstr += `</div>`;

    htmlstr += `<div class="grid-item">`;
    htmlstr += "<b>Preu</b><br><br>";
    htmlstr += `</div>`;

    htmlstr += `<div class="grid-item">`;
    htmlstr += "<b>Stock</b><br><br>";
    htmlstr += `</div>`;

    htmlstr += `<div class="grid-item">`;
    htmlstr += "<b>Activo</b><br><br>";
    htmlstr += `</div>`;

    htmlstr += `</div>`;
    htmlstr += `</div>`;
    
    htmlstr += `</div>`;

    for (let i = 0; i < productos.length; i++) {
        
        itemsSelectProductos += `<option value="value` + i + `">` + productos[i].nom + `</option>`;

        htmlstr += `<div class="grid-item">`;

        htmlstr += `<div class="grid-containerAdminProductes">`;

        htmlstr += `<div class="grid-item">`;
        htmlstr += productos[i].nom + "<br>";
        htmlstr += `</div>`;

        htmlstr += `<div class="grid-item">`;
        htmlstr += productos[i].descripcion + "<br>";
        htmlstr += `</div>`;

        htmlstr += `<div class="grid-item">`;
        htmlstr += productos[i].precio + " €<br>";
        htmlstr += `</div>`;

        htmlstr += `<div class="grid-item">`;
        htmlstr += productos[i].stock + " <br>";
        htmlstr += `</div>`;

        htmlstr += `<div class="grid-item" id="activo">`;
            if(productos[i].activat == 0){
                htmlstr += `<input type="checkbox" id="activo` + i + `" value="` + productos[i].id + `">`;
            }
            else {
                htmlstr += `<input type="checkbox" id="activo` + i + `" checked value="` + productos[i].id + `">`;
            }

        htmlstr += `</div>`;
        htmlstr += `</div><br>`;

    }

    itemsSelectProductos += "</select><br><br>";

    itemsSelectProductos += `<label>Selecciona el camp: </label><select name="selectCamp" id="selectCamp">`;
    itemsSelectProductos += `<option value="value1">Descripcio</option>`;
    itemsSelectProductos += `<option value="value2">Preu</option>`;
    itemsSelectProductos += `<option value="value3">Stock</option>`;
    itemsSelectProductos += "</select><br><br>";


    itemsSelectProductos += `<label>Introdueix la nova dada: <input type="text" id="nouValor"/></label><br><br>`;

    itemsSelectProductos += `<button id="botonActualitzarDades" class="button is-info">Actualitzar</button>`; 

    document.getElementById("selectProductos").innerHTML = itemsSelectProductos;
    document.getElementById("gridProductos").innerHTML = htmlstr;

    document.getElementById("botonActualitzarDades").addEventListener("click", function () {

        let eCamp = document.getElementById("selectCamp");
        let textCampSelect = eCamp.options[eCamp.selectedIndex].text;

        if(textCampSelect == "Descripcio") {
            textCampSelect = "descripcion";
        }
        else if(textCampSelect == "Preu") {
            textCampSelect = "precio";
        }
        else if(textCampSelect == "Stock") {
            textCampSelect = "stock";
        }
        console.log(textCampSelect);

        let eProd = document.getElementById("selectProd");
        let textProdSelect = eProd.options[eProd.selectedIndex].text;

        let eValor = document.getElementById("nouValor");
        let textValor = eValor.value;
        console.log(textValor + textProdSelect + textCampSelect);

        if(parseInt(textValor) < 0){
            textValor = 0;
        }

        let obj = new Object();
        obj.textCampSelect = textCampSelect;
        obj.textProdSelect = textProdSelect;
        obj.textValor = textValor;
        let data = JSON.stringify(obj);

       updateDades(data);

    })

    document.getElementById("gridProductos").addEventListener("change", function(e) {

        console.log(e.target.checked);

        if(e.target.checked){
            console.log(e.target.value);
            console.log("checked");

            let obj = new Object();
            obj.id = e.target.value;
            obj.num = 1;
            let data = JSON.stringify(obj);
            active(data);
        }
        else {
            console.log("no checked");

            let obj = new Object();
            obj.id = e.target.value;
            obj.num = 0;
            let data = JSON.stringify(obj);
            active(data);
        }

    })

}

// Funcion que recibe un objeto convertido en una string JSON por parametro
// Fetch para actualizar la BD, se envian datos por POST al PHP
// Se ejecuta al pulsar la checkbox de un producto "addeventlistener("change")"
function active(data) {
    fetch("index.php?controller=comandas&action=updateActivo", {
        method: 'POST',
        body: data
     });
}

// Funcion que recibe un objeto convertido en una string JSON por parametro
// Fetch para actualizar la BD, se envian datos por POST al PHP
// Se ejecuta al pulsar el boton actualitzar "addeventlistener("click")"
// Al acabar el fetch vuelve a llamar a la funcion fetchProductos() para actualizar los datos de la lista de productos
function updateDades(data){

    fetch("index.php?controller=comandas&action=updateDades", {
        method: 'POST',
        body: data
     })
     .then()
     .then(function () {
        fetchProductos();
    });
}

// Llamada a la funcion initApp para inicializar la pantalla admin
initApp();