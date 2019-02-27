<?=$this->fetch('page_parts/head', ['title' => $this->e($title)]) ?>

<h1>Kerpam, dažom ir šukuojam!</h1>

<h2>Rervacijų sąrašas</h2>

<div style="padding: 15px; 0">
    <a href="?page=new_kirpejo_rezervacija">Nauja rezervacija</a>
</div>

<div><form method="get">
    <table border="0">
        <tr>
            <td>Data:</td>
            <td><input type="text" id="datepicker" name="data" value="<?= $this->e($data) ?>"> | <a href="#" id="date_today">Šiandien</a> | <a href="#" id="date_tomorrow">Rytoj</a></td>
        </tr>
        <tr>
            <td>Klientas:</td>
            <td><input type="text" id="klientas" name="klientas" value="<?= $this->e($klientas) ?>"></td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <input type="hidden" name="page" value="kirpejai_list">
                <input type="submit" value="Rodyti"></td>
        </tr>

    </table>
</form>
</div>

<div style="width: 700px;">
<table cellpadding="1" cellspacing="1" border="1" width="700" class="lentele">
    <thead>
        <tr>
            <th>Laikas <a href="?<?=$this->e($url)?>&sort=time">Sort</a></th>
            <th>Kirpejas <a href="?<?=$this->e($url)?>&sort=kirpejas">Sort</a></th>
            <th>Klientas <a href="?<?=$this->e($url)?>&sort=klientas">Sort</a></th>
            <th>Kelintas apsilankymas <a href="?<?=$this->e($url)?>&sort=stat">Sort</a></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($kirpejai as $k) {
            echo $this->fetch('page_parts/reservation_list_element', ['k' => $k]);
        }
        ?>
    </tbody>
</table>
    <div style="float: left; width: 50px;"><?php
        if(!empty($prev_page)) {
            echo '<a href="?'.$this->e($url).'&page_num='.$prev_page.'">Atgal</a>';
        }
        ?></div>
    <div style="float: right"><?php
        if(!empty($next_page)) {
            echo '<a href="?'.$this->e($url).'&page_num='.$next_page.'">Toliau</a>';
        }
        ?></div>
</div>
<script>
    $(document).ready(function () {
        $("#date_today").click(function () {
            $("#datepicker").val("<?=date("Y-m-d")?>")
        });
        $("#date_tomorrow").click(function () {
            $("#datepicker").val("<?=date("Y-m-d", strtotime("tomorrow"))?>")
        });
    });

    function CancelReservation (id) {
        if(confirm("Atšaukti šią rezervaciją?")) {
            document.location.href = '?page=cancel_kirpejo_rezervacija&id='+id;
        }
    }
</script>

<?=$this->fetch('page_parts/foot')?>
