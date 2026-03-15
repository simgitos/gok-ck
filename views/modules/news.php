<div class="content">
    <h1><?= x($news['title_news']) ?></h1>
    <?= $text_news ?>
    <? if (!empty($news['galery_news'])) show_gal($news['galery_news']); ?>
</div>