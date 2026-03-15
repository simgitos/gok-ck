<h2>Twoje usługi:</h2>
<table class="table table-hovered">
    <tr>
        <td><b>Nazwa Usługi</b></td>
        <td><b>Termin płatności</b></td>
        <td><b>Kwota do zapłaty</b></td>
    </tr>

    <?
    foreach ($uslugi as $usluga): ?>
        <tr>
            <td><?= $usluga['usluga'] ?></td>
            <td><?= $usluga['termin'] ?></td>
            <td><?= $usluga['kwota'] ?></td>
        </tr>
    <? endforeach; ?>
</table>