<!-- Style dla nowoczesnego wyglądu strony głównej -->
<style>
    .hover-scale-btn {
        transition: all 0.2s ease-in-out;
    }

    .hover-scale-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.25) !important;
    }

    .hover-card-relacja {
        transition: all 0.3s ease-in-out;
        background: #fff;
    }

    .hover-card-relacja:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
    }

    .hover-card-relacja:hover img {
        transform: scale(1.05);
    }

    .hover-bg-item {
        transition: all 0.2s ease;
    }

    .hover-bg-item:hover {
        background-color: #f8f9fa !important;
        transform: translateX(4px);
    }

    .hover-link-title {
        transition: color 0.15s ease-in-out;
    }

    .hover-link-title:hover {
        color: #0d6efd !important;
    }

    .text-truncate-two-lines {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .section-header-line {
        position: relative;
        padding-bottom: 12px;
    }

    .section-header-line::after {
        content: '';
        position: absolute;
        bottom: 0;
        start: 0;
        left: 0;
        height: 3px;
        width: 50px;
        border-radius: 2px;
    }

    .section-header-primary::after {
        background-color: #0d6efd;
    }

    .section-header-warning::after {
        background-color: #ffc107;
    }
</style>

<!-- 2. Szybkie wiadomości (flash news) -->
<?php if (!empty($flash_news)): ?>
    <div class="alert alert-warning border-0 shadow-sm rounded-4 p-3 mb-4 d-flex align-items-center gap-3 animate__animated animate__fadeIn"
        style="background: linear-gradient(135deg, #fffcf0 0%, #fff3cd 100%);">
        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
            style="width: 45px; height: 45px; flex-shrink: 0; box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3);">
            <i class="bi bi-lightning-charge-fill fs-5"></i>
        </div>
        <div class="flex-grow-1">
            <h6 class="m-0 fw-bold text-dark small text-uppercase" style="letter-spacing: 1px;">
                Szybkie Wiadomości (Flash)</h6>
            <div class="d-flex flex-column gap-1 mt-1">
                <?php foreach ($flash_news as $flash): ?>
                    <div class="small text-secondary-emphasis d-flex align-items-center gap-2">
                        <span class="badge bg-warning text-dark px-2 py-1"
                            style="font-size: 0.65rem;"><?= x($flash['od']) ?></span>
                        <a href="<?= seo($flash['title_news']) ?>-n-<?= x($flash['id']) ?>.html"
                            class="text-decoration-none text-dark fw-semibold hover-link-title"><?= x($flash['title_news']) ?></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- 3. Sekcja Call to Action: Dołącz do zajęć -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 animate__animated animate__fadeInUp"
    style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-left: 5px solid #0284c7 !important;">
    <div
        class="card-body p-4 p-md-5 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
        <div>
            <span class="badge bg-primary text-white text-uppercase px-3 py-1 mb-2"
                style="font-size: 0.7rem; font-weight: 700; letter-spacing: 1px;">Rozwijaj swoje
                pasje</span>
            <h2 class="fw-bold text-dark mb-2" style="font-family: 'Montserrat', sans-serif; font-size: 1.6rem;">Chcesz
                dołączyć do naszych zajęć?</h2>
            <p class="text-secondary-emphasis m-0" style="font-size: 0.95rem;">Oferujemy bogaty
                program zajęć plastycznych, muzycznych i ruchowych dla dzieci, młodzieży oraz
                dorosłych.</p>
        </div>
        <div class="flex-shrink-0">
            <a href="kontakt.html" class="btn btn-primary btn-lg rounded-pill px-4 py-3 shadow-lg hover-scale-btn"
                style="font-weight: 700; font-size: 1rem; transition: all 0.2s ease-in-out; border-width: 0;">
                <i class="bi bi-people-fill me-2"></i> Dołącz do zajęć
            </a>
        </div>
    </div>
</div>

<!-- 4. Najbliższe wydarzenia -->
<div class="mb-5 animate__animated animate__fadeInUp">
    <h3 class="fw-bold text-dark mb-4 section-header-line section-header-warning"
        style="font-family: 'Montserrat', sans-serif;">
        Najbliższe wydarzenia
    </h3>
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
        <div class="d-flex flex-column gap-3">
            <?php foreach ($upcoming_events as $upcoming):
                $up_url = seo($upcoming['title_news']) . '-n-' . $upcoming['id'] . '.html';
                $date_time = strtotime($upcoming['data_wydarzenia'] ? $upcoming['data_wydarzenia'] : $upcoming['date_added']);
                $day = date('j', $date_time);
                $month_num = date('n', $date_time);
                $short_months = [
                    1 => 'STY',
                    2 => 'LUT',
                    3 => 'MAR',
                    4 => 'KWI',
                    5 => 'MAJ',
                    6 => 'CZE',
                    7 => 'LIP',
                    8 => 'SIE',
                    9 => 'WRZ',
                    10 => 'PAŹ',
                    11 => 'LIS',
                    12 => 'GRU'
                ];
                $month_lbl = $short_months[$month_num];
                ?>
                <div class="d-flex align-items-center gap-3 p-2 rounded-3 hover-bg-item bg-white"
                    style="transition: all 0.2s ease;">
                    <!-- Date Badge -->
                    <div class="date-badge text-center d-flex flex-column justify-content-center"
                        style="width: 55px; height: 60px; background-color: #f8f9fa; border-radius: 12px; flex-shrink: 0; border: 1px solid #e9ecef;">
                        <span class="fw-bold text-dark fs-4 lh-1"
                            style="font-family: 'Montserrat', sans-serif;"><?= $day ?></span>
                        <span class="fw-bold text-primary small mt-1"
                            style="font-size: 0.65rem; letter-spacing: 0.5px;"><?= $month_lbl ?></span>
                    </div>
                    <!-- Szczegóły -->
                    <div class="flex-grow-1 min-w-0">
                        <span class="badge bg-light text-secondary border border-light-subtle px-2 py-1 mb-1"
                            style="font-size: 0.65rem; font-weight: 600;">
                            <?= x(ucfirst($upcoming['kategoria'] ? $upcoming['kategoria'] : 'Wydarzenia')) ?>
                        </span>
                        <h6 class="m-0 fw-bold text-dark text-truncate" style="font-size: 0.95rem;">
                            <a href="<?= $up_url ?>"
                                class="text-decoration-none text-dark hover-link-title"><?= x($upcoming['title_news']) ?></a>
                        </h6>
                        <small class="text-secondary d-block mt-1 text-truncate" style="font-size: 0.8rem;">
                            <i class="bi bi-tag me-1"></i><?= $upcoming['tagi'] ? x($upcoming['tagi']) : 'brak tagów' ?>
                        </small>
                    </div>
                    <!-- Przycisk przejścia -->
                    <div class="flex-shrink-0">
                        <a href="<?= $up_url ?>"
                            class="btn btn-outline-primary btn-sm rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;" title="Zobacz szczegóły">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- 5. Relacje z wydarzeń -->
<div class="mb-5 animate__animated animate__fadeInUp">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark m-0 section-header-line section-header-primary"
            style="font-family: 'Montserrat', sans-serif;">
            Relacje z wydarzeń
        </h3>
        <a href="blog-<?= date('Y') ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3"
            style="font-weight: 600; font-size: 0.8rem;">Zobacz wszystkie</a>
    </div>
    <div class="row g-4">
        <?php foreach ($event_relations as $relation):
            $rel_img = is_file('pliki/miniaturki/news-' . $relation['id'] . '.jpg') ? 'pliki/miniaturki/news-' . $relation['id'] . '.jpg' : 'pliki/nofoto.png';
            $rel_url = seo($relation['title_news']) . '-n-' . $relation['id'] . '.html';
            ?>
            <div class="col-md-4 col-sm-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-card-relacja">
                    <div class="position-relative overflow-hidden" style="height: 140px;">
                        <img src="<?= $rel_img ?>" class="w-100 h-100 object-fit-cover" alt="Relacja"
                            style="object-fit: cover; transition: transform 0.5s ease;">
                        <span class="position-absolute badge bg-dark bg-opacity-75 text-white"
                            style="font-size: 0.7rem; top: 10px; right: 10px;">
                            <i class="bi bi-camera-fill me-1"></i> Galeria
                        </span>
                    </div>
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <span class="text-muted small d-block mb-1" style="font-size: 0.75rem;"><i
                                    class="bi bi-calendar3 me-1"></i><?= x($relation['od']) ?></span>
                            <h6 class="card-title fw-bold text-dark text-truncate-two-lines mb-2"
                                style="font-size: 0.88rem; line-height: 1.4; font-family: 'Montserrat', sans-serif;"
                                title="<?= x($relation['title_news']) ?>">
                                <a href="<?= $rel_url ?>"
                                    class="text-decoration-none text-dark hover-link-title"><?= x($relation['title_news']) ?></a>
                            </h6>
                        </div>
                        <a href="<?= $rel_url ?>" class="btn btn-outline-secondary btn-sm w-100 rounded-pill mt-2"
                            style="font-size: 0.78rem; font-weight: 600;">Obejrzyj relację</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- 7. Kalendarz wydarzeń -->
<div class="mt-5 animate__animated animate__fadeInUp">
    <h3 class="fw-bold text-dark mb-4 section-header-line section-header-primary"
        style="font-family: 'Montserrat', sans-serif;">
        Kalendarz wydarzeń
    </h3>
    <?php calendar(); ?>
</div>