<?php
?>
<body>
<br>
    <div class="columns">
        <div class="column is-1"></div>

        <div class=" column is-1 subtitle-div full-height">
            <h1 class="is-size-3">Validació</h1>        
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
                    <li><a href="index.php?controller=ticket">Ticket</a></li>
                    <li class="is-active"><a href="#" aria-current="page">Validació</a></li>
                </ul>
            </nav>
        </div>
        <div class="column is-3">

        </div>
    </div>

    <div class="columns">
        <div class="column is-1"></div>

        <div class=" column is-8">
        <div class="card">
        <div class="card-content">
            <div class="content">
            <?php

            if(!$correcto){
                ?>
                <h3>Gracies per la compra</h3>
                <?php
            }
            else{
                ?>
                <h3>No s'ha pogut fer la comanda</h3>
                <?php
            }
                ?>
            </div>
        </div>
    </div>     
        </div>
        <div class="column is-3"></div>
        </div>
        </div>
    </div> 

    <div style="height:150px">
    </div>
</body>

<?php
