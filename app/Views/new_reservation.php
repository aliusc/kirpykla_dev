<?= $this->fetch('page_parts/head', ['title' => $this->e($title)]) ?>

<h1>Kerpam, dažom ir šukuojam!</h1>

<h2>Nauja rezervacija</h2>

<div style="padding: 15px; 0">
    <a href="?page=kirpejai_list">Atgal</a>
</div>

<form method="GET" id="new_book" action="?page=new_kirpejo_rezervacija_save">
    <table border="0">
        <tr>
            <td>Data:</td>
            <td><input type="text" id="datepicker" name="data" value="<?= $this->e($data) ?>"></td>
        </tr>
        <tr>
            <td>Laikas:</td>
            <td><?= $this->fetch('page_parts/select_list', ['name' => 'time', 'select' => $this->e($time), 'list' => $laikai]) ?></td>
        </tr>
        <tr>
            <td>Kirpejas:</td>
            <td><?= $this->fetch('page_parts/select_list', ['name' => 'kirpejas', 'select' => $this->e($kirpejas), 'list' => $kirpejai]) ?></td>
        </tr>
        <tr>
            <td>Klientas:</td>
            <td><input type="text" name="klientas" value="<?=$this->e($klientas)?>"></td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <input type="hidden" name="page" value="new_kirpejo_rezervacija_save">
                <input type="hidden" name="next_page" id="next_page" value="<?=urlencode('kirpejai_list&data='.$this->e($data))?>">
                <input type="button" id="action_button" value="Registruoti"></td>
        </tr>
    </table>
</form>
<script>
    $(document).ready(function() {
        $.ajax({ async: false });
        $('#action_button').click(function() {
            //return false;
            url = '?'+$("#new_book").serialize()+'&page=check_registration_valid';

            $.getJSON(url,
                function(data) {
                    if(data.response==true) {
                        $('#new_book').submit();
                        // return true;
                    }
                    else {
                        $("<div>"+data.msg+"</div>").dialog({ modal: true});
                        // return false;
                    }
                });
        });

        $("#datepicker").change(function() {
            $("#next_page").val(encodeURI('kirpejai_list&data='+$(this).val()));
        });
    });
</script>

<?= $this->fetch('page_parts/foot') ?>
