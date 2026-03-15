<div class="content">
    <h1>Wydarzenia <?= x($rok) ?></h1>
    <? foreach ($posts as $post):
        if (is_file('pliki/miniaturki/news-' . x($post['id']) . '.jpg')) $img =  '<img src="pliki/miniaturki/news-' . x($post['id']) . '.jpg" alt="' . x($post['title_news']) . '" class="img-fluid">';
        else $img = '<img src="pliki/nofoto.png" alt="' . x($post['title_news']) . '" class="img-fluid">';

        if (strlen($post['text_news']) > 150) $post['text_news'] = substr($post['text_news'], 0, strpos($post['text_news'], ".", 150)) . ' [...]';
    ?>

        <div class="card mb-4">
            <div class="row ">
                <div class="col-md-4 ">
                    <a href="<?= seo($post['title_news']) ?>-n-<?= x($post['id']) ?>.html" class="stretched-link">
                        <?= $img ?></a>
                </div>
                <div class="col-md-8">
                    <h3 class=""><?= $post['title_news'] ?></h3>
                    <p class="small"><i class="bi bi-calendar2"></i> <?= x($post['od']) ?></p>
                    <p class=""><?= strip_tags($post['text_news']) ?></p>

                </div>


            </div>
        </div>




    <? endforeach; ?>
    <a href="blog-<?= x($rok) - 1 ?>" class="btn btn-success">Następna strona</a>
</div>