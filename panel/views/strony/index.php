<?php ?>
<hr>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><b>Strony w menu głównym</b></button>
        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><b>Strony poza menu głównym</b></button>
    </div>
</nav>
<div class="tab-content  py-3" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">


        <table class="table table-hover">
            <thead>
                <tr class="table-dark">
                    <th scope="col">#</th>
                    <th scope="col">Tytuł</th>
                    <th scope="col">Galeria</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
            <tbody id="sortable">
                <? foreach ($pagesInsideMenu as $strona):
                    if ($strona['submenu']) {
                        $submenus = explode('|', $strona['submenu']);
                        $r = $db->query("SELECT menu FROM $table WHERE id = '$submenus[0]'")->fetchArray();
                        if ($submenus[1]) {
                            $r1 = $db->query("SELECT menu FROM $table WHERE id = '$submenus[1]'")->fetchArray();
                            $r1['menu'] = $r1['menu'] . ' > ';
                        } else {
                            // $r1 = '';
                            $r1['menu'] = '';
                        }
                        $sub = '' . $r['menu'] . ' > ' . $r1['menu'] . '';
                    } else $sub = '';

                ?>
                    <tr id="<?= $strona['id'] ?>">
                        <td scope="col"><i class="bi bi-arrows-move handle"></i></td>
                        <td scope="col"><b><?= $sub ?></b><a href="<?= $_SESSION['url'] ?>/<?= $strona['name'] ?>.html" target="_blank"><b><?= $strona['menu'] ?></b></a></td>

                        <td scope="col"><i class="bi bi-images me-1"></i><a href="galeria.php?cmd=pliki&dir=<?= $strona['dirs'] ?>"><?= $strona['dirs'] ?></a></td>
                        <td scope="col">

                            <a href="?cmd=edytuj_strone&id=<?= $strona['id'] ?>" class="btn btn-sm btn-outline-info" title="Edytuj stronę"><i class="bi bi-pencil-square"></i></a>
                            <a href="?cmd=zmenu&id=<?= $strona['id'] ?>" class="btn btn-sm btn-outline-success" title="Usuń z menu"><i class="bi bi-menu-button"></i></a>
                            <a href="?cmd=confirm_del&id=<?= $strona['id'] ?>" class="btn btn-sm btn-outline-danger" title="Usuń stronę"><i class="bi bi-trash"></i></a>

                        </td>
                    </tr>

                <? endforeach; ?>
            </tbody>
        </table>
        <script>
            new Sortable(document.getElementById("sortable"), {
                handle: '.handle',
                animation: 150,
                ghostClass: "bg-light",
                onEnd: function(evt) {
                    let rows = document.querySelectorAll("#sortable tr");
                    let order = [];

                    rows.forEach((row, index) => {
                        let id = row.id;
                        order.push({
                            id: id,
                            position: index + 1
                        });
                    });

                    fetch("sortable.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify(order)
                        })
                        .then(response => response.text())
                        .then(data => console.log("Zapisano:", data));
                }
            });
        </script>



    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">

        <table class="table table-hover">
            <thead>
                <tr class="table-dark">
                    <th scope="col">Tytuł</th>
                    <th scope="col">Galeria</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
            <tbody>
                <? foreach ($pagesOutsideMenu as $page):
                    if ($page['submenu']) {
                        $submenus = explode('|', $page['submenu']);
                        $r = $db->query("SELECT menu FROM $table WHERE id = '$submenus[0]'")->fetchArray();
                        if ($submenus[1]) {
                            $r1 = $db->query("SELECT menu FROM $table WHERE id = '$submenus[1]'")->fetchArray();
                            $r1['menu'] = $r1['menu'] . ' > ';
                        } else {
                            // $r1 = '';
                            $r1['menu'] = '';
                        }
                        $sub = '' . $r['menu'] . ' > ' . $r1['menu'] . '';
                    } else $sub = '';

                ?>
                    <tr>
                        <td scope="col"><b><?= $sub ?></b><a href="<?= $_SESSION['url'] ?>/<?= $page['name'] ?>.html" target="_blank"><b><?= $page['menu'] ?></b></a></td>

                        <td scope="col"><i class="bi bi-images me-1"></i><a href="galeria.php?cmd=pliki&dir=<?= $page['dirs'] ?>"><?= $page['dirs'] ?></a></td>
                        <td scope="col">

                            <a href="?cmd=edytuj_strone&id=<?= $page['id'] ?>" class="btn btn-sm btn-outline-info" title="Edytuj stronę"><i class="bi bi-pencil-square"></i></a>
                            <a href="?cmd=domenu&id=<?= $page['id'] ?>" class="btn btn-sm btn-outline-success" title="Dodaj do menu"><i class="bi bi-menu-button"></i></a>
                            <a href="?cmd=confirm_del&id=<?= $page['id'] ?>" class="btn btn-sm btn-outline-danger" title="Usuń stronę"><i class="bi bi-trash"></i></a>

                        </td>
                    </tr>

                <? endforeach; ?>
            </tbody>
        </table>
    </div>
</div>