let json = "";

//Fetch al JSON de productes i obtencio dels items 
//escollits per l'usuari a menu mitjançant localstorage

function initApp() {
    json = JSON.parse(localStorage.getItem('productos'));

    fetch("index.php?controller=productos&action=fetchProductos")
        .then(res => res.json())
        .then(function (data) {
            dataMenu = data;
            console.log(dataMenu);

            imprimirTicketYForm(dataMenu);
        })

}

// Crida a la funcio imprimir ticket la qual recorre el 
//objecte retornat de localstorage i despres el fetch i compara el id d'ambdos.

function imprimirTicketYForm(dataMenu) {

    let nombre = "<b>Nom</b><br>";
    let cantidad = "<center><b>Quantitat</b><br>";
    let precio = "<center><b>Preu</b><br>";
    let total = 0;
    let pedido = [];

    for (let i = 0; i < json.productos.length; i++) {
        for (let j = 0; j < dataMenu.productos.length; j++) {
            if (json.productos[i].numero == dataMenu.productos[j].id) {

                nombre += dataMenu.productos[j].nom + "<br>";
                cantidad += json.productos[i].cantidad + "<br>";
                let precioMedioTotal = dataMenu.productos[j].precio * json.productos[i].cantidad;
                precio += precioMedioTotal.toFixed(2) + " € <br>";

                total = total + (dataMenu.productos[j].precio * json.productos[i].cantidad);

                let myFood = new Object();
                
                myFood.id = json.productos[i].numero;
                myFood.cantidad = json.productos[i].cantidad;

                console.log("food: " + JSON.stringify(myFood));
                pedido.push(myFood);
            }
        }
    }

//Si el id es igual s'incorpora a variables que seran html, 
//tambe a l'hora creem un objecte el qual conte la quantitat 
//i el id del producte el qual s'envia per el Form a validacio.php

    console.log("pedido " + JSON.stringify(pedido));
    preu = "<b> Preu total: " + total.toFixed(2) + " €</b><br><br>";
    preu += "<b>" + json.data_com + "</b><br>";
    preu += `Gràcies per la seva compra`;
    document.getElementById("preu2").innerHTML = preu;
    document.getElementById("columnaNom2").innerHTML = nombre;
    document.getElementById("columnaCantidad2").innerHTML = cantidad;
    document.getElementById("columnaPrecio2").innerHTML = precio;

    ComandaJSON = JSON.stringify(pedido)
    console.log("comanda: " + ComandaJSON)

    document.getElementById("campoHiddenComanda").setAttribute("value", ComandaJSON);

    localStorage.clear();
}

//Boto per anar enrere a menú

document.getElementById("Enrere").addEventListener("click", function() {

    location.href="index.php?controller=menu";

})

initApp();