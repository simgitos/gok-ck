
<div class=" grid ">
    <div class="grid-sizer"></div>

    <? foreach ($images as $image): ?>

        <div class="grid-item m-1">
            <a href="galeria/<?= x($dir) ?>/<?= x($image['obrazek']) ?>"
                title="<?= x($image['opis']) ?>"
                data-fancybox="gallery"
                data-caption="<?= x($image['opis']) ?>">
                <img src="galeria/<?= x($dir) ?>/mini/<?= x($image['obrazek']) ?>"
                    class="card-img-top"
                    alt="<?= x($image['opis']) ?>"
                    title="<?= x($image['opis']) ?>">
            </a>

        </div>
    <? endforeach; ?>

</div>


<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var grid = document.querySelector('.grid');

        // Inicjalizacja Masonry
        var msnry = new Masonry(grid, {
            itemSelector: '.grid-item',

            percentPosition: true
        });

        // Po załadowaniu obrazów, Masonry układa je poprawnie
        imagesLoaded(grid, function() {
            msnry.layout();
        });
    });
</script>