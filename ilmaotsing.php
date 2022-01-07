<?php
require("ilmafunktsion.php");
$sorttulp="nimetus";
$otsisona="";
if(isSet($_REQUEST["sort"])){
    $sorttulp=$_REQUEST["sort"];
}
if(isSet($_REQUEST["otsisona"])){
    $otsisona=$_REQUEST["otsisona"];
}
$ilmad=ilmaAndmed($sorttulp, $otsisona);
?>
<!DOCTYPE html>
<head>
    <title>Ilmaandmed</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<h2>Otsing kaubanimetus või grupinimi järgi</h2>
<form action="ilmaotsing.php">
    Otsi: <input type="text" name="otsisona" />
    <table>
        <tr>
            <th><a href="ilmaotsing.php?sort=temperatuur">Temperatuur</a></th>
            <th><a href="ilmaotsing.php?sort=kuupaev_kellaaeg">Kuupaev_kellaaeg</a></th>
            <th><a href="ilmaotsing.php?sort=maakonnanimi">Maakonnanimi</a></th>
            <th><a href="ilmaotsing.php?sort=maakonnakeskus">Maakonnakeskus</a></th>
        </tr>
        <?php foreach($ilmad as $ilma): ?>
            <tr>
                <td><?=$ilma->temperatuur ?></td>
                <td><?=$ilma->kuupaev_kellaaeg ?></td>
                <td><?=$ilma->maakonnanimi ?></td>
                <td><?=$ilma->maakonnakeskus ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</form>
</body>
</html>



