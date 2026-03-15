<table class="table table-hover">
    <tr  class="table-dark">
        <td><b>Nazwa folderu</b></td>
        <td><b>Data aktualizacji</b></td>
        <td><b>Wykorzystanie</b></td>
        <td><b>Akcje</b></td>
    </tr>

    <? foreach ($folders as $folder): ?>
        <tr>
            <td><a href="galeria.php?cmd=pliki&dir=<?= $folder['nazwa'] ?>"><?= $folder['nazwa'] ?></a></td>
            <td><?= date('Y-m-d', $folder['czas']) ?></td>
            <td><?= $folder['str'] ?></td>
            <td><a href="galeria.php?cmd=aktualizuj_dir&akt_dir=<?= $folder['nazwa'] ?>" class="btn  btn-sm btn-outline-success" title="Aktualizuj folder"><i class="bi bi-arrow-clockwise"></i></a> <a href="galeria.php?cmd=rm_dir&rm_dir=<?= $folder['nazwa'] ?>" class="btn btn-sm btn-outline-danger"  title="Usuń folder"><i class="bi bi-trash"></i></td>
        </tr>
    <? endforeach;     ?>


</table>