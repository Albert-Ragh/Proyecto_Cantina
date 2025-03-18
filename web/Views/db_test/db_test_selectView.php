<h1>db test -- SELECT </h1>

<?php

foreach ($allUsers as $user) {
?>
    id => <b><?= $user["id"]; ?></b>
    | Name => <b><?= $user["firstname"]; ?></b>
    | Last Name => <b><?= $user["lastname"]; ?></b>
    <hr>
    <hr>
<?php
}
?>