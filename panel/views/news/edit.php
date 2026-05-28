<?php ?>

<form action="newsy.php?cmd=update" method="post" enctype="multipart/form-data" class="col-md-8">

    <input type="hidden" name="id" value="<?= $news['id'] ?>" />

    <div class="mb-3">
        <label>Tytuł</label>
        <input type="text" name="title_news" value="<?= x($news['title_news']) ?>" class="form-control" placeholder="">
    </div>

    <div class="mb-3">
        <label>Treść</label>
        <textarea id="redactor_content" name="text_news" class="form-control"
            placeholder=""><?= $news['text_news'] ?></textarea>
    </div>
    <hr>
    <div class="mb-3">
        <div class="row">
            <div class="col"><label>Folder galerii</label>
                <select name="galery_news" class="form-select">
                    <?= $newsGalery ?>
                </select>
            </div>
            <div class="col"><label>Kategoria</label>
                <select name="kategoria" class="form-select">
                    <option value="">Wydarzenia</option>
                    <option value="aktualnosci" <?= $news['kategoria'] == 'aktualnosci' ? 'selected' : '' ?>>Aktualności
                    </option>
                    <option value="warsztaty" <?= $news['kategoria'] == 'warsztaty' ? 'selected' : '' ?>>Warsztaty
                    </option>
                    <option value="flash" <?= $news['kategoria'] == 'flash' ? 'selected' : '' ?>>Flash</option>
                </select>

            </div>
            <div class="col"> <label>Data wydarzenia</label> <input type="date" name="data_wydarzenia"
                    value="<?= $news['data_wydarzenia'] ?>" class="form-control" placeholder=""></div>
        </div>
    </div>


    <div class="mb-3">
        <div class="row">

            <div class="col"><label>Tagi</label>
                <?php
                // Pobranie wszystkich unikalnych tagów z bazy do podpowiedzi
                $all_tags_rows = $db->query("SELECT tagi FROM $news_table WHERE tagi != '' AND tagi IS NOT NULL")->fetchAll();
                $existing_tags = [];
                foreach ($all_tags_rows as $row) {
                    $exploded = explode(',', $row['tagi']);
                    foreach ($exploded as $t) {
                        $trimmed = trim($t);
                        if ($trimmed !== '' && !in_array($trimmed, $existing_tags)) {
                            $existing_tags[] = $trimmed;
                        }
                    }
                }
                sort($existing_tags);
                ?>
                <textarea id="tagi_textarea" name="tagi" class="form-control"
                    style="display:none;"><?= $news['tagi'] ?></textarea>

                <div class="tags-editor-container border rounded p-2 bg-white">
                    <div id="tags_badges_container" class="d-flex flex-wrap gap-1 mb-2"></div>

                    <div class="input-group input-group-sm mb-1 position-relative">
                        <input type="text" id="tag_input" class="form-control"
                            placeholder="Wpisz tag i naciśnij Enter lub przecinek..." autocomplete="off">
                        <button class="btn btn-outline-secondary" type="button" id="btn_add_tag">Dodaj</button>
                        <ul id="tags_suggestions" class="dropdown-menu w-100 position-absolute"
                            style="display: none; max-height: 200px; overflow-y: auto; z-index: 1000; top: 100%;"></ul>
                    </div>
                    <small class="text-muted" style="font-size: 0.75rem;">Kliknij tag, aby go usunąć. Wpisz min. 2
                        znaki, aby zobaczyć podpowiedzi.</small>
                </div>

                <style>
                    .tag-badge {
                        cursor: pointer;
                        background-color: #e9ecef;
                        color: #495057;
                        border: 1px solid #ced4da;
                        border-radius: 4px;
                        padding: 2px 8px;
                        display: inline-flex;
                        align-items: center;
                        gap: 5px;
                        font-size: 0.825rem;
                        transition: all 0.15s ease-in-out;
                        user-select: none;
                    }

                    .tag-badge:hover {
                        background-color: #dc3545;
                        color: #fff;
                        border-color: #dc3545;
                    }

                    .tag-badge .remove-tag {
                        font-weight: bold;
                        font-size: 0.85rem;
                        line-height: 1;
                    }

                    #tags_suggestions {
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
                    }

                    #tags_suggestions li a {
                        cursor: pointer;
                    }
                </style>

                <script>
                    $(document).ready(function () {
                        const $textarea = $('#tagi_textarea');
                        const $badgesContainer = $('#tags_badges_container');
                        const $input = $('#tag_input');
                        const $btnAdd = $('#btn_add_tag');
                        const $suggestions = $('#tags_suggestions');

                        const availableTags = <?= json_encode($existing_tags) ?>;
                        let currentTags = [];

                        function initTags() {
                            const val = $textarea.val().trim();
                            if (val) {
                                currentTags = val.split(',').map(t => t.trim()).filter(t => t !== '');
                            } else {
                                currentTags = [];
                            }
                            renderTags();
                        }

                        function renderTags() {
                            $badgesContainer.empty();
                            if (currentTags.length === 0) {
                                $badgesContainer.html('<span class="text-muted py-1" style="font-size: 0.8rem;">Brak tagów. Wpisz powyżej, aby dodać.</span>');
                                return;
                            }

                            currentTags.forEach(function (tag) {
                                const $badge = $('<span class="tag-badge"></span>')
                                    .text(tag)
                                    .append('<span class="remove-tag">&times;</span>');

                                $badge.on('click', function () {
                                    removeTag(tag);
                                });

                                $badgesContainer.append($badge);
                            });
                        }

                        function updateTextarea() {
                            $textarea.val(currentTags.join(', '));
                        }

                        function addTag(tag) {
                            tag = tag.trim().replace(/,+/g, '').replace(/\s+/g, ' ');
                            if (tag === '') return;

                            if (!currentTags.includes(tag)) {
                                currentTags.push(tag);
                                updateTextarea();
                                renderTags();
                            }
                            $input.val('');
                            $suggestions.hide();
                        }

                        function removeTag(tag) {
                            currentTags = currentTags.filter(t => t !== tag);
                            updateTextarea();
                            renderTags();
                        }

                        $input.on('keydown', function (e) {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                addTag($(this).val());
                            } else if (e.key === ',') {
                                e.preventDefault();
                                addTag($(this).val());
                            }
                        });

                        $btnAdd.on('click', function () {
                            addTag($input.val());
                        });

                        $input.on('input', function () {
                            const query = $(this).val().toLowerCase().trim();
                            $suggestions.empty().hide();

                            if (query.length < 2) return;

                            const matches = availableTags.filter(tag =>
                                tag.toLowerCase().includes(query) && !currentTags.includes(tag)
                            );

                            if (matches.length > 0) {
                                matches.forEach(function (tag) {
                                    const $li = $('<li></li>');
                                    const $a = $('<a class="dropdown-item"></a>').text(tag);
                                    $a.on('click', function () {
                                        addTag(tag);
                                        $input.focus();
                                    });
                                    $li.append($a);
                                    $suggestions.append($li);
                                });
                                $suggestions.show();
                            }
                        });

                        $(document).on('click', function (e) {
                            if (!$(e.target).closest('.position-relative').length) {
                                $suggestions.hide();
                            }
                        });

                        initTags();
                    });
                </script>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <div class="row">



        </div>
    </div>


    <div class="mb-3">
        <div class="row">
            <div class="col"> <label>Data rozpoczęcia publikacji</label> <input type="date" name="od"
                    value="<?= $news['od'] ?>" class="form-control" placeholder=""></div>
            <div class="col"><label>Data zakończenia publikacji</label><input type="date" name="do"
                    value="<?= $news['do'] ?>" class="form-control" placeholder=""></div>
        </div>
    </div>




    <input type="submit" value="Zapisz" class="btn btn-dark" />

</form>