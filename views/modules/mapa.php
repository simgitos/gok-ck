<ul class="nav flex-column list-unstyled text-dark">
    <li class="nav-item"><a href="/"  class="nav-link py-0 text-dark">Strona główna</a></li>
    <? foreach ($menu as $parent) : ?>
        <li class="nav-item"><a href="<?= $parent['name'] ?>.html" class="nav-link text-dark"><?= $parent['menu'] ?></a>

            <? if (!empty($parent['children'])) : ?>
                <ul class="nav flex-column ms-3">
                    <? foreach ($parent['children'] as $child) : ?>
                        <li class="nav-item"><a href="<?= $child['name'] ?>.html" class="nav-link text-dark"><?= $child['menu'] ?></a></li>
                    <? endforeach ?>
                </ul>
            <? endif ?>

        </li>
    <? endforeach ?>
    
    <? foreach ($newsy as $news) : ?>
        <li class="nav-item"><a href="<?= seo(x($news['title_news'])) ?>-n-<?= x($news['id']) ?>.html" class="nav-link text-dark"><?= x($news['title_news']) ?></a></li>
    <? endforeach ?>
</ul>