<form action="strony.php?cmd=aktualizuj_strone" method="post" enctype="multipart/form-data" class="col-md-8">

    <input type="hidden" name="id" value="<?= $strona['id'] ?>" />
    <input type="hidden" name="img2" value="<?= $img2 ?>" />

    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed accordion-success" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Treść
                </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <!-- 1 -->

                    <div class="mb-3">
                        <label>Tekst menu</label>
                        <input type="text" name="menu" required value="<?= x($strona['menu']) ?>" class="form-control" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label>Treść</label>
                        <textarea id="redactor_content" name="text1" style="width: 100%; height: 500px"><?= $strona['text1'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Folder galerii</label>
                        <select name="dirs" class="form-select">
                            <?= $pageGalery ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success form-control ">Wyślij</button>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    Funkcjonalność
                </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <div class="form-check form-switch mb-3">
                        <!-- 2 -->
                        <input <?= $switch ?> name="pos" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                        <label class="form-check-label">Strona ma być w menu</label>
                    </div>

                    <div class="mb-3">
                        <label>Typ strony</label>
                        <select name="type" class="form-select">
                            <?= $typeOptions ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Podmenu</label>
                        <select name="submenu" class="form-select">
                            <?= $menuCategory ?>
                        </select>
                    </div>
                    <input type="submit" value="wyślij" class="btn btn-dark form-control " />
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    Metadane
                </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">

                    <!-- 3 -->
                    <div class="mb-3">
                        <label>Nagłówek</label>
                        <input type="text" name="naglowek" value="<?= $strona['naglowek'] ?>" class="form-control" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label>Plik podstrony</label>
                        <input type="text" name="name" required value="<?= $strona['name'] ?>" readonly class="form-control" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label>Tytuł strony</label>
                        <input type="text" name="title" required value="<?= $strona['title'] ?>" class="form-control" placeholder="">
                    </div>
                    <input type="submit" value="wyślij" class="btn btn-dark form-control " />


                </div>
            </div>

        </div>
    </div>










</form>