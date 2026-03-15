<ul class="navbar-nav">

    <? foreach ($menu as $parent) :
        $hasChildren = !empty($parent['children']);

        // Jeśli to BLOG, generujemy dodatkowe submenu z latami
        if ($parent['type'] == 'blog') : ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="<?= $parent['name'] ?>.html" data-bs-toggle="dropdown"><?= $parent['menu'] ?></a>
                <ul class="dropdown-menu">

                    <? foreach ($blog_years as $year) : ?>
                        <li><a class="dropdown-item" href="blog-<?= $year ?>"><?= ucfirst($parent['menu']) ?> <?= $year ?></a></li>
                    <? endforeach ?>

                </ul>
            </li>
        <?
        // Jeśli ma submenu, generujemy zagnieżdżone <ul>
        elseif ($hasChildren) : ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="<?= $parent['name'] ?>.html" data-bs-toggle="dropdown"><?= $parent['menu'] ?></a>
                <ul class="dropdown-menu">

                    <? foreach ($parent['children'] as $child) : ?>
                        <li><a class="dropdown-item" href="<?= $child['name'] ?>.html"><?= $child['menu'] ?></a></li>
                    <? endforeach ?>

                </ul>
            </li>
        <? else : ?>
            <li class="nav-item"><a class="nav-link" href="<?= $parent['name'] ?>.html"><?= $parent['menu'] ?></a></li>
    <?
        endif;
    endforeach;
    ?>

</ul>