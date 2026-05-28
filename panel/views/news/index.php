<?php ?>
<table class="table table-hover">
    <thead>
        <tr class="table-dark">
            <th scope="col">#</th>
            <th scope="col">Miniaturka</th>
            <th scope="col">Tytuł</th>
            <th scope="col">Data dodania/<br>Data wydarzenia</th>
            <th scope="col">Akcje</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($newsy as $news):

            if (is_file('../pliki/miniaturki/news-' . $news['id'] . '.jpg')) {
                $news['mini'] = '<img src="../pliki/miniaturki/news-' . $news['id'] . '.jpg" width="80px"><br>
                <a href=newsy.php?cmd=usun_miniaturke&id_strony=' . $news['id'] . '>usuń</a>';
            } else {
                $news['mini'] = '<a href=newsy.php?cmd=dodaj_miniaturke&id_strony=' . $news['id'] . '><i class="bi bi-plus-circle"></i> dodaj</a>';
            }

            $news['url'] = $_SESSION['url'] . '/' . seo($news['title_news']) . '-n-' . $news['id'] . '.html';
            ?>
            <tr>
                <th scope="row"><?= $news['id'] ?></th>
                <td><?= $news['mini'] ?></td>
                <td><a href="<?= $news['url'] ?>" target="_blank"><b><?= $news['title_news'] ?>
                        </b></a><br>
                    <small>
                        <i class="bi bi-images me-1"></i><a
                            href="galeria.php?cmd=pliki&dir=<?= $news['galery_news'] ?>"><?= $news['galery_news'] ?></a>
                    </small><br>
                    <small><i class="bi bi-folder me-1"></i><?= $news['kategoria'] ?></small><br>
                    <small><i class="bi bi-tag me-1"></i><?= $news['tagi'] ?></small>
                </td>
                <td><?= $news['od'] ?><br>
                    <small><?= $news['data_wydarzenia'] ?></small>
                </td>
                <td>
                    <a href="newsy.php?cmd=edit_news&id=<?= $news['id'] ?>" class="btn btn-sm btn-outline-info"><i
                            class="bi bi-pencil-square"></i></a>
                    <a href="newsy.php?cmd=confirm_del_news&id=<?= $news['id'] ?>" class="btn btn-sm btn-outline-danger"><i
                            class="bi bi-trash"></i></a>
                </td>
            </tr>
        <? endforeach ?>
    </tbody>
</table>