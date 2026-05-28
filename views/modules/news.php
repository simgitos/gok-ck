<div class="content">
    <h1><?= x($news['title_news']) ?></h1>
    <?= $text_news ?>
    <? if (!empty($news['galery_news']))
        show_gal($news['galery_news']); ?>
    <? if (!empty($news['tagi'])) { ?>
        <div class="d-flex gap-2 flex-wrap">
            <?php $tags = explode(',', $news['tagi']);
            foreach ($tags as $tag) { ?>
                <span class="badge bg-secondary"><?= x($tag) ?></span>
                <? } ?>
        </div>
    <? } ?>
</div>