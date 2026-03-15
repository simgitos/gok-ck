<?php ?>

<form action="konfiguracja.php?cmd=konfiguracja" method="post" enctype="multipart/form-data" class="col-md-8">
    <div class="mb-3">
        <label>E-mail</label>
        <input type="email" name="mail" value="<?= $config['mail'] ?>" class="form-control" />
    </div>
    <div class="mb-3">
        <label>Tytuł strony</label>
        <input type="text" name="site_title" value="<?= $config['site_title'] ?>" class="form-control" required />
    </div>
    <div class="mb-3">
        <label>Słowa kluczowe</label>
        <textarea name="keywords_strony" class="form-control"><?= $config['keywords_strony'] ?></textarea>
    </div>
    <div class="mb-3">
        <label>Opis strony</label>
        <textarea name="opis_strony" class="form-control"><?= $config['opis_strony'] ?></textarea>
    </div>

    <input type="submit" name="ok" value="Zapisz" class="btn btn-dark" />

</form>