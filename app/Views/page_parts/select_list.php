<select name="<?=$this->e($name)?>">
    <?php
    foreach ($list as $key => $val) {
        $selected = $this->e($select)==$key ? 'selected="selected"' : '';
        echo "<option value='$key' $selected>$val</option>";
    }
    ?>

</select>