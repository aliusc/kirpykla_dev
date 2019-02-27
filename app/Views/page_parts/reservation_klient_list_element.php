<?php
foreach ($kirpejai as $id => $k) {
    echo "<td";
    if(array_key_exists($id, $bookings) && $bookings[$id]) {
        echo " class='cell_booked'>rezervuota";
    }
    else {
        echo " class='cell_available' id='$laikas-$id'>";
    }
    echo "</td>";
}
?>
