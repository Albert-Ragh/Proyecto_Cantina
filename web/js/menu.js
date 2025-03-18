let productos = "";
let productos2Menus = "";
let ticket = [];
const initialsStocks = [];
let currentStocks = [];
let aux = [];

//Funcio inicial, fa fetch al JSON de productes, i tambe comprova
//la hora actual, segons la hora fa la crida al menu de mati
//o al menu de dinar i fa la crida a la funcio per imprimir el menu seleccionat

function initApp() {
    fetch("index.php?controller=productos&action=fetchProductos")
        .then(res => res.json())
        .then(function (data) {
            console.log(data);
            productos2Menus = data;
            fecha = new Date();
            horaActual = fecha.getHours();
            if (horaActual == 11) {
                minutoActual = fecha.getMinutes();
                if (minutoActual < 30) {
                    productos = menuDesayuno(data);
                }
                else {
                    productos = menuComida(data);
                }

            }
            else if (horaActual < 11) {
                productos = menuDesayuno(data);
            }
            else if (horaActual > 11) {
                productos = menuComida(data);
            }

            for (let i = 0; i < productos.length; i++){
                initialsStocks[i] = productos[i].stock;
                
            }
            
            currentStocks = initialsStocks.slice();
            
            imprimirBocata()

        });

}

//Funcio la qual se li pasa el objecte retornat per el fetch
//Recorre el objecte on es troben tots el productes i comprova 
//en el atribut horario si es un producte de mati, dinar o d'ambdos
//com es la funcio del dinar busquem el que es d'ambos y de mati
//Creem un nou objecte amb nomes els productes que volem

function menuComida(data) {

    let menu = [];
    const desayuno = 0;
    const comida = 1;
    const todos = 2;

    for (let i = 0; i < data.productos.length; i++) {

        if (data.productos[i].horario == comida || data.productos[i].horario == todos) {

            menu.push(data.productos[i]);

        }

    }

    return menu;
}

//Aquesta es la funcio del menu del mati, i te el mateix
//funcionament que la funcio anterior nomes que amb els productes del mati

function menuDesayuno(data) {

    let menu = [];
    const desayuno = 0;
    const comida = 1;
    const todos = 2;

    for (let i = 0; i < data.productos.length; i++) {

        if (data.productos[i].horario == desayuno || data.productos[i].horario == todos) {

            menu.push(data.productos[i]);

        }

    }

    return menu;

}

//Funcio la qual recorre l'objecte producte el qual conte
//tots el productes segons la hora del dia, tambe comprova el stock
//del producte i realitza canvis segons la quantitat de stock restant.
//Tota la informacio es guarda sota una variable anomenada htmlString la
//qual al final de la funcio injectarem al html. 

function imprimirBocata() {

    let division = 1 % 3;


    for (let i = 0; i < productos.length; i++) {

        let htmlStr = "";

        if(productos[i].activat == 1){
            if(productos[i].stock <= 0) {
                htmlStr += `<div class="card opacity border-red">`;
                htmlButton = `<button class="button is-small is-fullwidth is-rounded is-danger" disabled>Esgotat</button></div>`;
                
    
            }
            else if(productos[i].stock >= 1 && productos[i].stock <= 20) {
                htmlStr += `<div class="card zoom border-orange">`;
                htmlButton = `<button class="button is-small is-fullwidth is-success is-outlined is-rounded" id="sumar` + i + `">Queden poques unitats</button></div>`;
                
    
            }
            else {
                htmlStr += `<div class="card zoom">`;
                htmlButton = `<button class="button is-small is-fullwidth is-success is-outlined is-rounded" id="sumar` + i + `">Afegir</button></div>`;
            }
            htmlStr += `<div class="card-image">`;
            htmlStr += `<figure class="image is-4by3">`;
            htmlStr += '<img src= "img/' + productos[i].url_Imagen + '">';
            htmlStr += `</figure>`;
            htmlStr += `</div>`;
            htmlStr += `<div class="card-content">`;
            htmlStr += `<div class="content">`;
            htmlStr += `<br><b>` + productos[i].nom + `</b>`;
            htmlStr += ` ` + productos[i].precio.toFixed(2) + ` €`;
            htmlStr += `<br><textarea class="textAreaDescripcioItem" disabled rows="5">` + productos[i].descripcion + `</textarea><br><br>`;
            htmlStr += htmlButton;
            htmlStr += `</div>`;
            htmlStr += `</div></div></div>`;
    
            document.getElementById("grid").innerHTML += htmlStr;
        }

    }

    //Event   

    document.getElementById("menu").addEventListener("click", function (e) {

        comprobarSuma(e)

    })

    setLocalStorageACero(true);
    setLocalStorageACero(false);

}

//Funcion la qual actualiza el ticket cada vegada que s'afegeix un producte
//

function actualizarTicket() {

    let htmlStr = "";
    let nombre = "<b>Nom</b><br>";
    let cantidad = "<center><b>Quantitat</b><br>";
    let boton = "<br>";

    let total = 0;

    for (let i = 0; i < ticket.length; i++) {

        nombre += productos[ticket[i].numero].nom + "<br>";
        cantidad += ticket[i].cantidad + "<br>";
        boton += ` <img src="img/basura.png" id="restar` + ticket[i].numero + `"><br>`;

        total = total + productos[ticket[i].numero].precio * ticket[i].cantidad
    }

    htmlStr += "<br><br>"

    cantidad += "</center>";
    preu = "<b> Preu total: " +  total.toFixed(2) + " €</b>";
    borrar = `<img src="img/basura.png"></img>`;

    if(ticket.length == 0) {
        document.getElementById("borrar").innerHTML = "";
        document.getElementById("preu").innerHTML = "";
        document.getElementById("columnaNom").innerHTML = "";
        document.getElementById("columnaCantidad").innerHTML = "";
        document.getElementById("columnaBoton").innerHTML = "";
    }
    else{
        document.getElementById("borrar").innerHTML = borrar;
        document.getElementById("preu").innerHTML = preu;
        document.getElementById("columnaNom").innerHTML = nombre;
        document.getElementById("columnaCantidad").innerHTML = cantidad;
        document.getElementById("columnaBoton").innerHTML = boton;
    }

}

//Listener que borra todo lo que hay en el ticket en el boton de borrar   
//todo el ticket
document.getElementById("borrar").addEventListener("click", function (){


    ticket = [];
    
    setLocalStorageACero(false);
    
    console.log("borrar initial Stocks " + initialsStocks);
    actualizarTicket();

    currentStocks = initialsStocks.slice();
    console.log("borrar current Stocks " + currentStocks);
    console.log("borrar initial Stocks " + initialsStocks);


})

//Funcio que afegeix els productes al ticket, i realitza la suma d'aquests
//si s'escolleix mes d'un. Tambe borra els stocks els quals es guarden

function comprobarSuma(e) {

    console.log(e.target.id);
    

    let nombreBoton = e.target.id;
    let input = 0;

    console.log(productos[0].stock);

   
    if (nombreBoton.includes("sumar")) {

        let numInput = nombreBoton.slice(5);
        console.log("current stock " + currentStocks[numInput]);

        if(!currentStocks[numInput] <= 0){
            let json = localStorage.getItem("producto" + numInput);
            let producto = JSON.parse(json);
            producto.quantitat++;
            localStorage.setItem("producto" + numInput, JSON.stringify(producto));
    
    
            let existe = false;
    
            for (let i = 0; i < ticket.length; i++) {
    
                if (ticket[i].numero == numInput) {
    
                    ticket[i].cantidad++;
                    existe = true;
    
                }
    
            }
    
            if (!existe) {
    
                let productoLista = new Object();
                productoLista.numero = numInput;
                productoLista.cantidad = 1;
                ticket.push(productoLista);
    
            }
            currentStocks[numInput]--;
            console.log("aaaa" + initialsStocks);
            console.log("bbbb" + currentStocks);
            actualizarTicket();
        }
        else {
            console.log("sin stock" + currentStocks[numInput]);
        }

        }
    }

    


//Funcio que borra els productes al ticket, i realitza la resta d'aquests
//si treu algun. Tambe afeigeix els stocks els quals es guarden

function comprobarResta(e) {

    console.log("ticket " + e.target.id);

    let nombreBoton = e.target.id;
    let input = 0;

    if (nombreBoton.includes("restar")) {

        let numInput = nombreBoton.slice(6);

        let json = localStorage.getItem("producto" + numInput);
        let producto = JSON.parse(json);

        if (producto.quantitat != 0) {
            producto.quantitat--;
        }

        localStorage.setItem("producto" + numInput, JSON.stringify(producto));

        let existe = false;
        let iBorrar;

        if (producto.quantitat == 0) {
            for (let i = 0; i < ticket.length; i++) {
                if (ticket[i].numero == numInput) {
                    existe = true;
                    iBorrar = i;
                }
            }
            if (existe) {
                ticket.splice(iBorrar, 1);
            }
        }
        else {
            for (let i = 0; i < ticket.length; i++) {

                if (ticket[i].numero == numInput) {

                    ticket[i].cantidad--;
                    existe = true;

                }
            }
            if (!existe) {

                let productoLista = new Object();
                productoLista.numero = numInput;
                productoLista.cantidad--;
                ticket.push(productoLista);

            }

        }
        currentStocks[numInput]++;
        console.log("a" + initialsStocks);
        console.log("bbbb" + currentStocks);

    }

    actualizarTicket();

}

//Listener el qual fa la crida a la funcion comprobar resta quans es vol eliminar algun
//producte del ticket
document.getElementById("ticket").addEventListener("click", function (e) {

    comprobarResta(e);

})

//Listeneer el s'activa al pulsar el boto conitunar. Crea un object eel qual es pasa per
//localstorage a ticket per saber la quantitat de productes comprats
document.getElementById("Continuar").addEventListener("click", function () {


    if (ticket.length > 0) {

        let productoLocalStorage = [];

        for (let i = 0; i < ticket.length; i++) {
            
            producto = new Object();
            producto.numero = productos[ticket[i].numero].id;
            producto.cantidad = ticket[i].cantidad;
            
            productoLocalStorage.push(producto);
        }

        let date = new Date();
        let dia = date.getDate();
        let mes = date.getMonth() + 1;
        let any = date.getFullYear();

        let fechaActual = any + "-" + dia + "-" + mes;
    
        let ticketLocalStorage = new Object();
        ticketLocalStorage.productos = productoLocalStorage;
        ticketLocalStorage.data_com = fechaActual;
    
        console.log("productos console: " + productoLocalStorage);
    
        localStorage.setItem("productos", JSON.stringify(ticketLocalStorage));
    
        setLocalStorageACero(true);

        location.href = "index.php?controller=ticket";
    }
    else {

        window.alert("No has seleccionado producto para comprar");

    }

})

function pedidoHecho() {

}

//Funcio que seteja el localstorage a cero perque no hi hagi cap error
function setLocalStorageACero(borrar) {
    
    if(borrar){
        for (let i = 0; i < productos2Menus.productos.length; i++) {

            let producto = new Object();
            producto.id = productos2Menus.productos[i].id;
            producto.quantitat = 0;
    
            console.log(JSON.stringify(producto));
            localStorage.removeItem("producto" + i);
        }
        
    }
    else{
        for (let i = 0; i < productos.length; i++) {

            let producto = new Object();
            producto.id = productos[i].id;
            producto.quantitat = 0;
    
            console.log(JSON.stringify(producto));
            localStorage.setItem("producto" + i, JSON.stringify(producto));
        }
        
    }
    
   
}

    // $(window).scroll(function(){
    //     $("#div2").css({"margin-top": ($(window).scrollTop()) + "px", "margin-left":($(window).scrollLeft()) + "px"});
    //     console.log("scroll");
    //   });


//Inicialitza la app

initApp();
