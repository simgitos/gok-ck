<div class="marketing my-3  wow animate__animated animate__fadeInUp animate__delay-0.7s">
    <hr>
    <h2 class="my-3 border-3 "><a href="blog-<?= date('Y'); ?>">Aktualności >></a></h2>
    <div class="row">


        <? foreach ($posts as $post):

            if (is_file('pliki/miniaturki/news-' . $post['id'] . '.jpg'))        $img = '<img src="pliki/miniaturki/news-' . $post['id'] . '.jpg" alt="' . x($row['title_news']) . '" class="img-fluid">';
            else $img = '<img src="pliki/nofoto.png" alt="' . x($row['title_news']) . '"  class="img-fluid">';
        ?>

            <div class="col-sm-6 my-3 mb-sm-0 ">

                <div class="card shadow">
                    <div class="crop-img">
                        <a href="<?= seo($post['title_news']) ?>-n-<?= x($post['id']) ?>.html" class="stretched-link">
                            <?= $img ?>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $post['title_news'] ?></h5>
                        <p class="small"><i class="bi bi-calendar2"></i> <?= x($post['od']) ?></p>

                    </div>
                </div>
            </div>

        <? endforeach ?>
    </div>
</div>