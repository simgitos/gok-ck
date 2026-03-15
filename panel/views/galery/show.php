<?php ?>
<div class="row mb-3">
    <div class="col">
        <div id="mulitplefileuploader">Dodaj zdjęcia</div>
        <div id="status"></div>
        <div id="eventsmessage"></div>
    </div>
    <div class="col">
        <p>Folder: <?= $_GET['dir'] ?> <a href="galeria.php?cmd=aktualizuj_dir&akt_dir=<?= $_GET['dir'] ?>" class="btn btn-sm btn-dark">Aktualizuj</a></p>
    </div>
</div>


<table class="table table-hover">
    <thead>
        <tr class="table-dark">
            <th scope="col">#</th>
            <th scope="col">Tytuł</th>
            <th scope="col">Opis</th>
            <th scope="col">Akcje</th>
        </tr>
    </thead>
    <tbody id="sortable">
        <? foreach ($images as $image): ?>


            <tr id="<?= $image['id'] ?>" data-dir="<?= $_GET['dir'] ?>">
                <td scope="col"><i class="bi bi-arrows-move handle"></i></td>
                <td scope="col"><a href="../galeria/<?= $_GET['dir'] ?>/<?= $image['obrazek'] ?>"><img src="../galeria/<?= $_GET['dir'] ?>/mini/<?= $image['obrazek'] ?>" width="100" alt="Kliknij aby zobaczyć powiększenie"></a></td>

                <td scope="col">

                    <form class="opis" id="<?= $image['id'] ?>">
                        <div class="input-group mb-3">
                            <textarea class="form-control" name="opis" rows="1"><?= $image['opis'] ?></textarea>
                            <input type="submit" value="Zapisz" class="btn btn-dark">
                        </div>
                    </form>
                    <? if ($_GET['dir'] === '_slider') : ?>
                        <form class="link" id="<?= $image['id'] ?>">
                            <div class="input-group mb-3">
                                <input type="url" name="link" class="form-control" value="<?= $image['link'] ?>" placeholder="Pełny adres strony ">
                                <input type="submit" value="Zapisz" class="btn btn-dark">
                            </div>
                        </form>
                    <? endif ?>
                    <div id="wyniki<?= $image['id'] ?>" class="wynik"></div>
                </td>
                <td scope="col">

                    <a href="#" class="btn btn-sm btn-outline-danger usun" id="<?= $image['id'] ?>" data-dir="<?= $image['dir'] ?>" title="Usuń zdjęcie"><i class="bi bi-trash"></i></a>


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
                let dir = row.dataset.dir; // Pobranie wartości z data-aa
                order.push({
                    id: id,
                    position: index + 1,
                    dir: dir
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



<script type='text/javascript'>
    $(window).load(function() {

        $('form.opis').submit(function(event) {
            event.preventDefault();
            var id = $(this).attr('id');
            var opis = $('form.opis#' + id + ' textarea[name=opis]').val();
            $.ajax({
                url: 'ajax.php',
                data: {
                    funkcja: 'opis',
                    id: id,
                    opis: opis
                },
                type: 'post',
                success: function(output) {
                    $('#wyniki' + id).html(output);
                }
            });
            return false;
        });

        $('form.link').submit(function(event) {
            event.preventDefault();
            var id = $(this).attr('id');
            var link = $('form.link#' + id + ' input[name=link]').val();
            $.ajax({
                url: 'ajax.php',
                data: {
                    funkcja: 'link',
                    id: id,
                    link: link
                },
                type: 'post',
                success: function(output) {
                    $('#wyniki' + id).html(output);
                }
            });
            return false;
        });



        $('.usun').click(function() {
            var id = $(this).attr('id');
            var dir = $(this).data('dir');
            $.ajax({
                url: 'ajax.php',
                data: {
                    funkcja: 'usun_zdj',
                    id: id,
                    dir: dir
                },
                type: 'post',
                success: function(output) {
                    $('tr#' + id).html('Zdjęcie usunięto');
                }
            });
            return false;
        });



    });
</script>


<script>
    $(document).ready(function() {
        var settings = {
            url: "upload.php",
            deletelStr: "Usuń",
            dragDropStr: "<span><b>lub przeciągnij je tutaj </b></span>",
            dragDrop: true,
            fileName: "myfile",
            allowedTypes: "jpg",
            afterUploadAll: function() {
                $("#eventsmessage").html($("#eventsmessage").html() + "<br/>Zdjęcia załadowano poprawnie <a class=\'btn btn-dark\' href=\"galeria.php?cmd=aktualizuj_dir&akt_dir=<?= $_GET['dir'] ?>\">Aktualizuj folder</a>");

            },

            returnType: "json",
            onSuccess: function(files, data, xhr) {
                // alert((data));
            },
            showDelete: true,
            showStatusAfterSuccess: false,
            deleteCallback: function(data, pd) {
                for (var i = 0; i < data.length; i++) {
                    $.post("delete.php", {
                            op: "delete",
                            name: data[i]
                        },
                        function(resp, textStatus, jqXHR) {
                            //Show Message
                            $("#status").append("<div>Plik usunięty</div>");
                        });
                }
                pd.statusbar.hide(); //You choice to hide/not.

            }
        }
        var uploadObj = $("#mulitplefileuploader").uploadFile(settings);


    });
</script>