<div class="mb-4">
    <div id="myCarousel" class="carousel slide shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel"
        style="max-height: 80vh;">
        <div class="carousel-inner">
            <?php
            $active = 'active';
            foreach ($slides as $slide): ?>
                <div class="carousel-item <?= $active ?>" style="height: 90vh; position: relative;">
                    <img src="galeria/_slider/<?= x($slide['obrazek']) ?>" class="d-block w-100 h-100" alt="Slide"
                        style="height: 90vh !important; object-fit: cover;">
                    <!-- Ciemny gradientowy overlay dla optymalnego kontrastu -->
                    <div class="position-absolute top-0 start-0 w-100 h-100"
                        style="background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.2) 60%, rgba(0,0,0,0.15) 100%); z-index: 1;">
                    </div>

                    <div class="container position-relative h-100" style="z-index: 2;">
                        <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 pb-5"
                            style="bottom: 0;">
                            <h1 class="display-5 fw-bold text-white px-3 text-center mb-4 animate__animated animate__fadeInUp"
                                style="font-family: 'Montserrat', sans-serif; text-shadow: 0 4px 12px rgba(0,0,0,0.6); max-width: 900px; line-height: 1.2;">
                                <?= strip_tags(x($slide['opis'])) ?>
                            </h1>
                            <?php if (!empty($slide['link'])): ?>
                                <a href="<?= x($slide['link']) ?>"
                                    class="btn btn-primary btn-lg rounded-pill px-4 py-2-5 shadow-lg animate__animated animate__zoomIn hover-scale"
                                    style="font-weight: 700; letter-spacing: 0.5px; border-width: 0;">
                                    Zobacz szczegóły <i class="bi bi-arrow-right-short ms-1"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
                $active = '';
            endforeach;
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev"
            style="z-index: 3;">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Poprzedni</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next"
            style="z-index: 3;">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Następny</span>
        </button>
    </div>
</div>

<style>
    .hover-scale {
        transition: all 0.2s ease-in-out;
    }

    .hover-scale:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3) !important;
    }
</style>