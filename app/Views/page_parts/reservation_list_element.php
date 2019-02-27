<tr><?php
echo '<td>'.$this->e($k['rezervacijos_data']).' '.$this->e(substr($k['rezervacijos_laikas'],0,-3)).'</td>
<td>'.$this->e($k['kirpejo_vardas']).'</td>
<td>'.$this->e($k['kliento_vardas']).'</td>
<td>'.$stat[$k['rezervacijos_kliento_id']].' ';
if($stat[$k['rezervacijos_kliento_id']]>0 && $stat[$k['rezervacijos_kliento_id']]%5==0) {
    echo '<span class="nuolaida">nuolaida!</span>';
}
echo '</td>
<td><img src="img/recycle.gif" onClick="CancelReservation('.$this->e($k['rezervacijos_id']).')"></td>';
?>
</tr>
