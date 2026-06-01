<!-- 2. Szybkie wiadomości (flash news) -->
<?php if (!empty($flash_news)): ?>
    <div class="">
        <div class="alert alert-warning d-flex justify-content-center border-0 shadow-sm rounded-4 p-3 px-5 mb-0 d-flex gap-3 animate__animated animate__fadeIn"
            style="background: linear-gradient(135deg, #fffcf0 0%, #fff3cd 100%);">
            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                style="width: 45px; height: 45px; flex-shrink: 0; box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3);">
                <i class="bi bi-lightning-charge-fill fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="m-0 fw-bold text-dark small text-uppercase" style="letter-spacing: 1px;">
                    Komunikaty</h6>
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
    </div>
<?php endif; ?>