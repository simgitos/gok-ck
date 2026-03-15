<div class="content">
    <h1><?= x($page['naglowek']) ?></h1>

    <? if (!empty($page['text1'])) echo $page['text1']; ?>
    <? if ($page['type'] == "linki") mapa(); ?>
    <? if (!empty($page['dirs'])) {
        show_gal(x($page['dirs']));
    } ?>
</div>