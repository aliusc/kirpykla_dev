<tr><?php
echo '<td>'.$this->e(substr($k['rezervacijos_laikas'],0,-3)).'</td>
<td>'.$this->e($k['kirpejo_vardas']).'</td>
<td>'.$this->e($k['kliento_vardas']).'</td>
<td>'.$this->e($k['kliento_stat']).' ';
if($k['kliento_stat']>0 && $k['kliento_stat']%5==0) {
    echo '<span class="nuolaida">!</span>';
}
echo '</td>
<td><img src="img/recycle.gif" onClick="CancelReservation('.$this->e($k['rezervacijos_id']).')"></td>';
?>
</tr>
