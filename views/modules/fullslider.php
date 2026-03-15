
<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">

    <div class="carousel-inner">';

        <?
        $active = 'active';
        foreach ($slides as $slide): ?>
            <div class="carousel-item <?= $active ?>"><img src="galeria/_slider/<?= x($slide['obrazek']) ?>">

                <div class="container">
                    <div class="carousel-caption">
                        <h1 class="display-4"><?= strip_tags(x($slide['opis'])) ?></h1>
                        <? if (!empty($slide['link'])) : ?>
                            <a href="<?= x($slide['link']) ?>" class="btn btn-dark">Przejdź</a>
                        <? endif ?>
                        <p></p>
                        <p></p>
                    </div>
                </div>
            </div>
        <?
            $active = '';
        endforeach
        ?>

    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Poprzedni</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Następny</span>
    </button>
</div>