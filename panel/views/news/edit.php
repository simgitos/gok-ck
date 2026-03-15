<?php ?>

<form action="newsy.php?cmd=update" method="post" enctype="multipart/form-data" class="col-md-8">

    <input type="hidden" name="id" value="<?= $news['id'] ?>" />

    <div class="mb-3">
        <label>Tytuł</label>
        <input type="text" name="title_news" value="<?= x($news['title_news']) ?>" class="form-control" placeholder="">
    </div>

    <div class="mb-3">
        <label>Treść</label>
        <textarea id="redactor_content" name="text_news" class="form-control" placeholder=""><?= $news['text_news'] ?></textarea>
    </div>

    <div class="mb-3">
        <label>Folder galerii</label>
        <select name="galery_news" class="form-select">
            <?= $newsGalery ?>
        </select>
    </div>

    <div class="mb-3">
        <div class="row">
            <div class="col"> <label>Data publikacji</label> <input type="date" name="od" value="<?= $news['od'] ?>" class="form-control" placeholder=""></div>
            <div class="col"><label>Data zakończenia</label><input type="date" name="do" value="<?= $news['do'] ?>" class="form-control" placeholder=""></div>
        </div>
    </div>




    <input type="submit" value="Zapisz" class="btn btn-dark"/>
 
</form>