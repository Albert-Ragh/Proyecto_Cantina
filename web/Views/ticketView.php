<body>
    <br>
    <div class="columns">
        <div class="column is-1"></div>

        <div class=" column is-1 subtitle-div full-height">
            <h1 class="is-size-3">Ticket</h1>        
        </div>

        <div class="column is-1"></div>

        <div class="column is-8">
        </div>

        <div class="column is-1"></div>
    </div>
    <div class="columns">
        <div class="column is-1">

        </div>
        <div class="column is-3">
            <nav class="breadcrumb" aria-label="breadcrumbs">
                <ul>
                    <li><a href="index.php">Inici</a></li>
                    <li><a href="index.php?controller=menu">Menu</a></li>
                    <li class="is-active"><a href="#" aria-current="page">Ticket</a></li>
                </ul>
            </nav>
        </div>
        <div class="column is-3">

        </div>
    </div>
    <br>
    <div class="columns">

        <div class="column is-2 has-text-centered">
            <button id="Enrere" class="button is-link">Enrere</button>
        </div>
        <div id="menu" class="column is-8">

            <div class="columns">

                <div class="column">
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">
                                <b>Ticket</b>
                            </p>
                        </header>
                        <div class="card-content" id="ticket2">
                            <div class="columns">
                                <div class="column is-4" id="columnaNom2">

                                </div>
                                <div class="column is-3" id="columnaCantidad2">

                                </div>
                                <div class="column is-4" id="columnaPrecio2">

                                </div>
                            </div>
                            <div id="preu2">

                            </div>
                        </div>
                    </div>
                </div>
                <div id="columna2" class="column is-half">
                    <form action="index.php?controller=validacio" method="POST">
                        <div class="card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    <b>Dades usuari</b>
                                </p>
                            </header>
                            <div class="card-content" id="ticket2">
                                <input type="hidden" name="comanda" value="" id="campoHiddenComanda"></input>

                                <label for="fname">Nombre: </label>
                                <input type="text" id="fname" class="FormType" name="fname" required ><br><br>

                                <label for="tlf">Telefono: </label>
                                <input type="text" id="lname" class="FormType" name="telefono" pattern="[0-9]{9}" required ><br><br>

                                <label for="corrElec">Correo electronico: </label>
                                <input type="email" id="lname" class="FormType" name="correu" placeholder="example@inspedralbes.cat" 
                                pattern="[^ @]*@inspedralbes.cat*" required ><br><br>

                                <label for="comentariComanda">Comentari comanda: </label>
                                <input type="text" id="comandaCom" name="comentariComanda" placeholder="El pa sense tomaquet!"><br><br>
                            </div>
                        </div>
                        <div class="column is-2 has-text-centered">
                            <input type="submit" value="Continuar" class="button is-link"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/ticket.js"></script>
</body>