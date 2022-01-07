<?php

require("ilmafunktsion.php");
$ilmad=ilmaAndmed();
//andmete sortimine
if(isSet($_REQUEST["sort"])){
    $ilmad=ilmaAndmed($_REQUEST["sort"]);
} else {
    $ilmad=ilmaAndmed();
}

?>
<!DOCTYPE html>
<head>
    <title>Ilmaandmed</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<h1>Tabelite Kaubad+kaubagrupide sisu</h1>
<table>
    <tr>
        <th><a href="ilmaotsing.php?sort=temperatuur">Temperatuur</a></th>
        <th><a href="ilmaotsing.php?sort=kuupaev_kellaaeg">Kuupaev_kellaaeg</a></th>
        <th><a href="ilmaotsing.php?sort=maakonnanimi">Maakonnanimi</a></th>
        <th><a href="ilmaotsing.php?sort=maakonnakeskus">Maakonnakeskus</a></th>
    </tr>

    <!--tagastab massivist andmed-->
    <?php foreach($ilmad as $ilma): ?>
        <tr>
            <td><?=$ilma->temperatuur ?></td>
            <td><?=$ilma->kuupaev_kellaaeg ?></td>
            <td><?=$ilma->maakonnanimi ?></td>
            <td><?=$ilma->maakonnakeskus ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
