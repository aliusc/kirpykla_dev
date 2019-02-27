<?=$this->fetch('page_parts/head', ['title' => $this->e($title)]) ?>

<h1>Kerpam, dažom ir šukuojam!</h1>

<h2>Galimų laikų sąrašas</h2>

<?php
if(!empty($booking)) {
    echo "<div class='aktyvi_rezervacija_block'><b>Dėmesio</b>, jūs jau turite rezervaciją. Jūsų laukiame {$booking['rezervacijos_data']} 
".substr($booking['rezervacijos_laikas'],0,-3)." pas mūsų meistrą {$booking['kirpejo_vardas']}.<img src='img/recycle.gif' onClick='CancelReservation(".$this->e($booking['rezervacijos_id']).")'></div>";
}
?>

<div><form method="get">
    <table border="0">
        <tr>
            <td>Data:</td>
            <td><input type="text" id="datepicker" name="data" value="<?= $this->e($data) ?>"></td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <input type="hidden" name="page" value="kliento_puslapis">
                <input type="submit" value="Rodyti"></td>
        </tr>

    </table>
</form>
</div>

<div style="padding: 25px 0;">
<table cellpadding="1" cellspacing="1" border="1" width="700" class="lentele">
    <thead>
        <tr>
            <th>Laikas</th>
            <?php
            foreach ($kirpejai as $id => $name) {
                echo "<th>$name</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($laikai as $laikas) {
            echo "<tr><td class='td_laikai'>$laikas</td>";
            echo $this->fetch('page_parts/reservation_klient_list_element', [ 'kirpejai' => $kirpejai, 'bookings' => $matrica[$laikas], 'laikas' => $laikas]);
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</div>
<script>
    $(document).ready(function () {
        $.ajax({ async: false });

        $(".cell_available").click(function () {
            $idas = $(this).attr("id");
            $kirpejo_id = $idas.substr(6);
            $laikas = $idas.substr(0,5);

            var name = prompt("Jūsų vardas:", "Jūsų vardas");
            if (name != null && name != "Jūsų vardas") {

                url = '?data=<?=$this->e($data)?>&time='+$laikas+'&kirpejas='+$kirpejo_id+'&klientas='+name+'&page=check_registration_valid';
                $.getJSON(url,
                function(data) {
                    if(data.response==true) {
                        url = '?<?=$url?>&page=save_client_registration&klientas='+name+'&kirpejas='+$kirpejo_id+'&time='+$laikas+'&next_page=<?=urlencode('kliento_puslapis&data='.$this->e($data))?>';
                        $(location).attr('href', url);
                    }
                    else {
                            $("<div>"+data.msg+"</div>").dialog({ modal: true});
                            // return false;
                        }
                    });
            }
        });
    });

    function CancelReservation (id) {
        if(confirm("Atšaukti šią rezervaciją?")) {
            document.location.href = '?<?=$url?>&page=cancel_kirpejo_rezervacija&next_page=<?=urlencode('kliento_puslapis&data='.$this->e($data))?>&id='+id;
        }
    }
</script>

<?=$this->fetch('page_parts/foot')?>
