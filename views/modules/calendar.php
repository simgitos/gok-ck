<div id="calendar-ajax-container">
    <div class="calendar-wrapper my-5 p-4 bg-white shadow rounded border border-light">
        <!-- Panel filtrów -->
        <form method="get" action="index.php" class="row g-3 mb-4 align-items-end pb-3 border-bottom border-light">
            <?php foreach ($_GET as $key => $value): ?>
                <?php if (!in_array($key, ['cal_kat', 'cal_tag', 'cal_month', 'cal_year'])): ?>
                    <input type="hidden" name="<?= x($key) ?>" value="<?= x($value) ?>">
                <?php endif; ?>
            <?php endforeach; ?>

            <div class="col-md-5 col-sm-6">
                <label class="form-label fw-bold text-secondary small mb-1"><i
                        class="bi bi-folder2-open me-1"></i>Kategoria</label>
                <select name="cal_kat" class="form-select form-select-sm calendar-filter-select">
                    <option value="">Wszystkie kategorie</option>
                    <?php foreach ($all_kategorie as $kat): ?>
                        <option value="<?= x($kat) ?>" <?= $selected_kat === $kat ? 'selected' : '' ?>>
                            <?= x(ucfirst($kat ? $kat : 'Wydarzenia')) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-5 col-sm-6">
                <label class="form-label fw-bold text-secondary small mb-1"><i class="bi bi-tag me-1"></i>Tag</label>
                <select name="cal_tag" class="form-select form-select-sm calendar-filter-select">
                    <option value="">Wszystkie tagi</option>
                    <?php foreach ($all_tags as $tag): ?>
                        <option value="<?= x($tag) ?>" <?= $selected_tag === $tag ? 'selected' : '' ?>><?= x($tag) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2 col-12 d-grid">
                <a href="index.php" class="btn btn-outline-danger btn-sm calendar-btn-nav" title="Resetuj filtry">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>

        <!-- Pasek nawigacji miesiąca -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="<?= $buildUrl(['cal_month' => $prev_month, 'cal_year' => $prev_year]) ?>"
                class="btn btn-outline-primary btn-sm px-3 shadow-none calendar-btn-nav">
                <i class="bi bi-chevron-left"></i> Poprzedni
            </a>
            <h3 class="m-0 fw-bold text-dark text-center flex-grow-1"
                style="font-size: 1.4rem; font-family: 'Montserrat', sans-serif;">
                <?= $month_name ?> <?= $year ?>
            </h3>
            <a href="<?= $buildUrl(['cal_month' => $next_month, 'cal_year' => $next_year]) ?>"
                class="btn btn-outline-primary btn-sm px-3 shadow-none calendar-btn-nav">
                Następny <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <!-- Siatka kalendarza -->
        <div class="table-responsive">
            <table class="table table-bordered calendar-table m-0">
                <thead>
                    <tr class="bg-light text-center text-secondary text-uppercase"
                        style="font-size: 0.78rem; font-weight: 700;">
                        <th style="width: 14.28%;">Pon</th>
                        <th style="width: 14.28%;">Wt</th>
                        <th style="width: 14.28%;">Śr</th>
                        <th style="width: 14.28%;">Czw</th>
                        <th style="width: 14.28%;">Pt</th>
                        <th style="width: 14.28%;">Sob</th>
                        <th style="width: 14.28%;">Nd</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($weeks as $week): ?>
                        <tr>
                            <?php foreach ($week as $day): ?>
                                <?php if ($day === null): ?>
                                    <td class="calendar-day-cell bg-light opacity-50"></td>
                                <?php else: ?>
                                    <?php
                                    $is_today = ($day === $today_d && $month === $today_m && $year === $today_y);
                                    $day_events = isset($events_by_day[$day]) ? $events_by_day[$day] : [];
                                    ?>
                                    <td class="calendar-day-cell <?= $is_today ? 'calendar-today' : '' ?>">
                                        <span class="calendar-day-num"><?= $day ?></span>
                                        <div class="events-container">
                                            <?php foreach ($day_events as $event): ?>
                                                <?php
                                                $short_title = mb_strimwidth($event['title_news'], 0, 16, '...');
                                                $event_url = seo($event['title_news']) . '-n-' . $event['id'] . '.html';
                                                ?>
                                                <a href="<?= $event_url ?>" class="event-link" title="<?= x($event['title_news']) ?>">
                                                    <?= x($short_title) ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .calendar-table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
        }

        .calendar-day-cell {
            height: 115px;
            vertical-align: top;
            padding: 8px !important;
            position: relative;
            background-color: #fff;
            transition: background-color 0.15s ease;
        }

        .calendar-day-cell:hover {
            background-color: #f8f9fa;
        }

        .calendar-day-num {
            font-weight: 700;
            font-size: 0.9rem;
            color: #495057;
            margin-bottom: 6px;
            display: inline-block;
            width: 24px;
            height: 24px;
            line-height: 24px;
            text-align: center;
            border-radius: 50%;
        }

        .calendar-today {
            background-color: #f1f7fe !important;
            border: 2px solid #0d6efd !important;
        }

        .calendar-today .calendar-day-num {
            background-color: #0d6efd;
            color: #fff;
        }

        .events-container {
            display: flex;
            flex-direction: column;
            gap: 3px;
            max-height: 75px;
            overflow-y: auto;
        }

        .event-link {
            font-size: 0.72rem !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            display: block;
            padding: 3px 6px;
            border-radius: 4px;
            background-color: #e2f0d9;
            color: #385723 !important;
            text-decoration: none;
            font-weight: 600;
            border-left: 3px solid #70ad47;
            transition: all 0.15s ease-in-out;
        }

        .event-link:hover {
            background-color: #c5e0b4;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            text-decoration: none;
        }

        #calendar-ajax-container {
            transition: opacity 0.2s ease-in-out;
        }

        @media (max-width: 767.98px) {
            .calendar-wrapper {
                padding: 15px !important;
            }

            .calendar-day-cell {
                height: 80px;
                padding: 4px !important;
            }

            .calendar-day-num {
                font-size: 0.75rem;
                width: 20px;
                height: 20px;
                line-height: 20px;
            }

            .events-container {
                max-height: 50px;
                gap: 2px;
            }

            .event-link {
                font-size: 0.65rem !important;
                padding: 1px 4px;
                border-left-width: 2px;
            }
        }
    </style>

</div>

<script>
    (function () {
        function initCalendarEvents() {
            if (window.calendarEventsBound) return;
            window.calendarEventsBound = true;

            // Delegacja zdarzeń na kliknięcie nawigacji
            document.addEventListener('click', function (e) {
                var btn = e.target.closest('.calendar-btn-nav');
                if (btn) {
                    e.preventDefault();
                    var url = btn.getAttribute('href');
                    loadCalendarAjax(url);
                }
            });

            // Delegacja zdarzeń na zmianę filtrów
            document.addEventListener('change', function (e) {
                var select = e.target.closest('.calendar-filter-select');
                if (select) {
                    e.preventDefault();
                    var form = select.closest('form');
                    var formData = new FormData(form);
                    var params = new URLSearchParams(formData);
                    var url = form.getAttribute('action') + '?' + params.toString();
                    loadCalendarAjax(url);
                }
            });
        }

        function loadCalendarAjax(url) {
            var container = document.getElementById('calendar-ajax-container');
            if (!container) return;

            container.style.opacity = '0.5';

            fetch(url)
                .then(function (response) {
                    if (!response.ok) throw new Error('Network error');
                    return response.text();
                })
                .then(function (html) {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(html, 'text/html');
                    var newContent = doc.getElementById('calendar-ajax-container');
                    if (newContent) {
                        container.innerHTML = newContent.innerHTML;
                        window.history.pushState({ path: url }, '', url);
                    } else {
                        window.location.href = url;
                    }
                    container.style.opacity = '1';
                })
                .catch(function (err) {
                    container.style.opacity = '1';
                    window.location.href = url;
                });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCalendarEvents);
        } else {
            initCalendarEvents();
        }
    })();
</script>