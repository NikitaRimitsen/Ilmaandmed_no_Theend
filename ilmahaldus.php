<?php
require("ilmafunktsion.php");

if(isSet($_REQUEST["maakonnanimilisamine"])){
if(!empty(trim($_REQUEST["uuemakonnanimi"])) && !empty(trim($_REQUEST["uuemakonnakeskus"]))){
    maakonnanimilisamine($_REQUEST["uuemakonnanimi"], $_REQUEST["uuemakonnakeskus"]);
    header("Location: ilmahaldus.php");
    exit();
}
}

if(isSet($_REQUEST["ilmandalisamine"])){
if(!empty(trim($_REQUEST["temperatuur"])) ) {
    ilmalisamine($_REQUEST["temperatuur"], $_REQUEST["maakonnanimi"]);
    header("Location: ilmahaldus.php");
    exit();
    }
}
if(isSet($_REQUEST["kustutusid"])){
    kustutusid($_REQUEST["kustutusid"]);
}
if(isSet($_REQUEST["muutmine"])){
    muutmine($_REQUEST["muudetudid"], $_REQUEST["temperatuur"],
        $_REQUEST["maakonnanimi"]);
}
$ilmad=ilmaAndmed();
?>
<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="styleilma.css">
    <title>Ilmaandmed</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<form action="ilmahaldus.php">
    <h2>Ilmaandmed lisamine</h2>
    <dl>
        <dt>Temperatuur:</dt>
        <dd><input type="number" name="temperatuur" /></dd>
        <dt>Maakonnanimi:</dt>
        <dd><?php
            echo looRippMenyy("SELECT id, maakonnanimi FROM maakondade",
                "maakonnanimi");
            ?>
        </dd>
    </dl>


    <input type="submit" name="ilmandalisamine" value="Lisa ilma" />


    <dl>
        <h2>Maakonnanimi lisamine</h2>
        <dt>Maakonnanimi:</dt>
        <dd><input type="text" name="uuemakonnanimi" /></dd>
        <dt>Maakonnakeskus:</dt>
        <dd><input type="text" name="uuemakonnakeskus" /></dd>

    </dl>
    <input type="submit" name="maakonnanimilisamine" value="Ilma lisamine"



</form>
<form action="ilmahaldus.php">
    <h2>Kaupade loetelu</h2>
    <table>
        <tr>
            <th>Haldus</th>
            <th>Temperatuur</th>
            <th>Kuupaev_kellaaeg</th>
            <th>Maakonnanimi</th>
            <th>Maakonnakeskus</th>
        </tr>
        <?php foreach($ilmad as $ilma): ?>
            <tr>
                <?php if(isSet($_REQUEST["muutmisid"]) &&
                    intval($_REQUEST["muutmisid"])==$ilma->id): ?>
                    <td>
                        <input type="submit" name="muutmine" value="Muuda" />
                        <input type="submit" name="katkestus" value="Katkesta" />
                        <input type="hidden" name="muudetudid" value="<?=$ilma->id ?>" />
                    </td>
                    <td><input type="text" name="temperatuur" value="<?=$ilma->temperatuur ?>" /></td>
                    <td><?=$ilma->kuupaev_kellaaeg ?></td>
                    <!--<td><input type="date" name="$kuupaev_kellaaeg" value="<?=$ilma->kuupaev_kellaaeg ?>" /></td>-->
                    <td><?php
                        echo looRippMenyy("SELECT id, maakonnanimi FROM maakondade",
                            "maakonnanimi", $ilma->maakonnanimi);
                        ?></td>
                    <td><?=$ilma->maakonnakeskus ?></td>

                <?php else: ?>

                    <td><a id="musor" href="ilmahaldus.php?kustutusid=<?=$ilma->id ?>"
                           onclick="return confirm('Kas ikka soovid kustutada?')">❌</a>
                        <a id="musor" href="ilmahaldus.php?muutmisid=<?=$ilma->id ?>">🖊️</a>
                    </td>
                    <td><?=$ilma->temperatuur ?></td>
                    <td><?=$ilma->kuupaev_kellaaeg ?></td>
                    <td><?=$ilma->maakonnanimi ?></td>
                    <td><?=$ilma->maakonnakeskus ?></td>
                <?php endif ?>
            </tr>
        <?php endforeach; ?>
    </table>
</form>
</body>
</html>
