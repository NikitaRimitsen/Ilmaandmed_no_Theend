<?php
$yhendus=new mysqli("localhost", "nikitarim", "123456", "nikitarim");

function ilmaAndmed(){
    global $yhendus;
    $kask=$yhendus->prepare("SELECT ilmatemperatuuri.id, temperatuur, kuupaev_kellaaeg, maakonnanimi, maakonnakeskus
 FROM ilmatemperatuuri, maakondade
 WHERE ilmatemperatuuri.maakonna_id=maakondade.id;
");
    //echo $yhendus->error;
    $kask->bind_result($id, $temperatuur, $kuupaev_kellaaeg, $maakonnanimi, $maakonnakeskus);
    $kask->execute();
    $hoidla=array();
    while($kask->fetch()){
        $ilma=new stdClass();
        $ilma->id=$id;
        $ilma->temperatuur= $temperatuur;
        $ilma->kuupaev_kellaaeg=htmlspecialchars($kuupaev_kellaaeg);
        $ilma->maakonnanimi=htmlspecialchars($maakonnanimi);
        $ilma->maakonnakeskus=htmlspecialchars($maakonnakeskus);
        array_push($hoidla, $ilma);
    }
    return $hoidla;
}



function looRippMenyy($sqllause, $valikunimi, $valitudid=""){
    global $yhendus;
    $kask=$yhendus->prepare($sqllause);
    $kask->bind_result($id, $sisu);
    $kask->execute();
    $tulemus="<select name='$valikunimi'>";
    while($kask->fetch()){
        $lisand="";
        if($id==$valitudid){$lisand=" selected='selected'";}
        $tulemus.="<option value='$id' $lisand >$sisu</option>";
    }
    $tulemus.="</select>";
    return $tulemus;
}

function maakonnanimilisamine($maakonnanimi, $maakonnakeskus){
    global $yhendus;
    $kask=$yhendus->prepare("INSERT INTO maakondade (maakonnanimi, maakonnakeskus)
                      VALUES (?, ?)");
    $kask->bind_param("ss", $maakonnanimi, $maakonnakeskus);
    $kask->execute();
}

function ilmalisamine($temperatuur, $maakonnanimi){
    global $yhendus;
    $kask=$yhendus->prepare("INSERT INTO
       ilmatemperatuuri (temperatuur, maakonna_id, kuupaev_kellaaeg)
       VALUES (?, ?, NOW())");
    $kask->bind_param("ss", $temperatuur, $maakonnanimi);
    $kask->execute();
}

function kustutusid($ilma_id){
    global $yhendus;
    $kask=$yhendus->prepare("DELETE FROM ilmatemperatuuri WHERE id=?");
    $kask->bind_param("i", $ilma_id);
    $kask->execute();
}

function muutmine($ilma_id, $temperatuur, $maakonnanimi){
    global $yhendus;
    $kask=$yhendus->prepare("UPDATE ilmatemperatuuri SET temperatuur=?, maakonna_id=?
                      WHERE id=?");
    $kask->bind_param("sii", $temperatuur, $maakonnanimi, $ilma_id);
    $kask->execute();
}
