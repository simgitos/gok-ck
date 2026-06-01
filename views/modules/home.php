<div class="container mt-4">
    <?php
    // Przygotowanie wydarzeń dla kalendarza
    $calendar_events = [];
    if (!empty($upcoming_events)) {
        foreach ($upcoming_events as $ev) {
            $date_raw = $ev['data_wydarzenia'] ? $ev['data_wydarzenia'] : $ev['date_added'];
            $ev_date = date('Y-m-d', strtotime($date_raw));
            $calendar_events[$ev_date][] = [
                'id' => $ev['id'],
                'title' => x($ev['title_news']),
                'url' => seo($ev['title_news']) . '-n-' . $ev['id'] . '.html',
                'time' => date('H:i', strtotime($date_raw)),
                'category' => x(ucfirst($ev['kategoria'] ? $ev['kategoria'] : 'Wydarzenie')),
                'tags' => $ev['tagi'] ? x($ev['tagi']) : ''
            ];
        }
    }
    ?>

    <!-- STYLE DLA NOWEGO KALENDARZA -->
    <style>
        .calendar-container {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
            padding: 28px;
            margin-bottom: 45px;
            border: 1px solid #f1f3f5;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .calendar-title-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .calendar-title-wrapper i {
            font-size: 1.5rem;
            color: #0d6efd;
        }
        
        .calendar-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            color: #212529;
            margin: 0;
            font-size: 1.4rem;
            text-transform: capitalize;
        }
        
        .calendar-nav-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #dee2e6;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #495057;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .calendar-nav-btn:hover {
            background: #f8f9fa;
            color: #0d6efd;
            border-color: #0d6efd;
        }
        
        .calendar-days-wrapper {
            display: flex;
            justify-content: space-between;
            gap: 4px;
            overflow-x: visible;
            padding-bottom: 0;
        }
        
        .calendar-day-capsule {
            flex: 1 1 0;
            min-width: 0;
            height: 75px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            cursor: default;
            transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
            user-select: none;
            opacity: 0.55;
        }
        
        .calendar-day-capsule.has-events {
            background-color: #e0f2fe;
            border-color: #bae6fd;
            color: #0369a1;
            cursor: pointer;
            opacity: 1;
        }

        .calendar-day-capsule.has-events:hover {
            background-color: #bae6fd;
            border-color: #0ea5e9;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(14, 165, 233, 0.15);
        }
        
        .calendar-day-capsule.today {
            border: 2px solid #0d6efd;
            background-color: #f8f9fa;
            opacity: 1;
        }
        
        .calendar-day-capsule.today .day-num {
            color: #0d6efd;
            font-weight: 900;
        }

        .calendar-day-capsule.active {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;
            color: #ffffff !important;
            border-color: #0d6efd !important;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3) !important;
            opacity: 1 !important;
        }
        
        .calendar-day-capsule.active .day-num,
        .calendar-day-capsule.active .day-name {
            color: #ffffff !important;
        }
        
        .calendar-day-capsule .day-name {
            font-size: 0.6rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6c757d;
            margin-bottom: 3px;
            letter-spacing: 0.3px;
        }

        .calendar-day-capsule.has-events .day-name {
            color: #0284c7;
        }
        
        .calendar-day-capsule .day-num {
            font-size: 1.1rem;
            font-weight: 800;
            color: #212529;
            line-height: 1.1;
        }

        .calendar-day-capsule.has-events .day-num {
            color: #0369a1;
        }
        
        .calendar-events-display {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 24px;
            margin-top: 25px;
            min-height: 120px;
            border: 1px solid #f1f3f5;
            transition: all 0.3s ease;
        }

        .calendar-events-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            color: #212529;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .cal-event-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 5px solid #0d6efd;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .cal-event-card:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        }

        .cal-event-card:last-child {
            margin-bottom: 0;
        }

        .cal-event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        .cal-event-date-badge {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.8rem;
            background: #f1f5f9;
            padding: 4px 10px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border: 1px solid #e2e8f0;
        }

        .cal-event-title-link {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: #212529;
            text-decoration: none;
            transition: color 0.2s ease;
            line-height: 1.3;
        }

        .cal-event-title-link:hover {
            color: #0d6efd;
        }
        
        /* MEDIA QUERY DLA MOBILE - SIATKA ZAMIAST PASKA DNI */
        @media (max-width: 768px) {
            .calendar-container {
                padding: 16px;
            }

            .calendar-days-wrapper {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 6px;
                overflow-x: visible;
                padding-bottom: 0;
            }
            
            .calendar-day-capsule {
                width: 100%;
                height: 60px;
                border-radius: 10px;
                padding: 2px 0;
            }
            
            .calendar-day-capsule .day-num {
                font-size: 1rem;
            }

            .calendar-day-capsule .day-name {
                font-size: 0.6rem;
                margin-bottom: 2px;
            }
        }
    </style>

    <!-- NOWA SEKCJA KALENDARZA -->
    <div class="calendar-container animate__animated animate__fadeIn">
        <h3 class="fw-bold text-dark mb-4 section-header-line section-header-warning"
                    style="font-family: 'Montserrat', sans-serif;">
                    Kalendarz wydarzeń
                </h3>
        <div class="calendar-header">
            <div class="calendar-title-wrapper">
                <i class="bi bi-calendar3-event-fill"></i>
                <h3 class="calendar-title" id="calMonthTitle">Kalendarz wydarzeń</h3>
            </div>
            <div class="d-flex gap-2">
                <button class="calendar-nav-btn" onclick="prevMonth()" title="Poprzedni miesiąc">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="calendar-nav-btn" onclick="nextMonth()" title="Następny miesiąc">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Pozioma wstęga / mobilny grid -->
        <div class="calendar-days-wrapper" id="calDaysContainer">
            <!-- Generowane dynamicznie przez JS -->
        </div>

        <!-- Panel wyświetlania wydarzeń -->
        <div class="calendar-events-display" id="calEventsDisplay">
            <!-- Zawartość generowana dynamicznie -->
        </div>
    </div>

    <script>
        // Dane o nadchodzących wydarzeniach przekazane z PHP do JS
        const calendarEvents = <?= json_encode($calendar_events) ?>;
        
        // Polskie nazwy miesięcy i skróty dni tygodnia
        const monthNames = [
            'Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 
            'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'
        ];
        const dayShortNames = ['Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'Sb'];

        // Inicjalizacja daty (domyślnie bieżący rok i miesiąc)
        let calYear = new Date().getFullYear();
        let calMonth = new Date().getMonth();

        // Funkcja pobierająca najbliższe nadchodzące wydarzenia (np. 3 wydarzenia)
        function getUpcomingEvents(limit = 3) {
            const allEvents = [];
            for (const dateKey in calendarEvents) {
                calendarEvents[dateKey].forEach(ev => {
                    allEvents.push({
                        ...ev,
                        date: dateKey
                    });
                });
            }
            // Sortujemy po dacie (od najwcześniejszej do najpóźniejszej)
            allEvents.sort((a, b) => a.date.localeCompare(b.date));
            
            // Filtrujemy tylko dzisiejsze i przyszłe wydarzenia
            const todayStr = new Date().toISOString().split('T')[0];
            const futureEvents = allEvents.filter(ev => ev.date >= todayStr);
            
            // Zwracamy przyszłe wydarzenia, a jeśli ich brak – jakiekolwiek
            return futureEvents.length > 0 ? futureEvents.slice(0, limit) : allEvents.slice(0, limit);
        }

        // Funkcja generująca kalendarz
        function generateCalendar(year, month) {
            const container = document.getElementById('calDaysContainer');
            container.innerHTML = '';

            // Ustawienie tytułu miesiąca i roku
            document.getElementById('calMonthTitle').innerText = `${monthNames[month]} ${year}`;

            // Wyznaczenie liczby dni w miesiącu
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            
            const todayStr = new Date().toISOString().split('T')[0];
            let firstDayWithEvent = null;

            for (let day = 1; day <= daysInMonth; day++) {
                const dateObj = new Date(year, month, day);
                const dayOfWeek = dateObj.getDay();
                
                const monthStr = String(month + 1).padStart(2, '0');
                const dayStr = String(day).padStart(2, '0');
                const dateKey = `${year}-${monthStr}-${dayStr}`;

                const hasEvents = calendarEvents[dateKey] && calendarEvents[dateKey].length > 0;

                if (hasEvents && !firstDayWithEvent) {
                    firstDayWithEvent = dateKey;
                }

                // Tworzenie elementu dnia
                const dayCapsule = document.createElement('div');
                dayCapsule.className = 'calendar-day-capsule';
                if (hasEvents) {
                    dayCapsule.classList.add('has-events');
                } else {
                    dayCapsule.style.pointerEvents = 'none';
                }

                if (dateKey === todayStr) {
                    dayCapsule.classList.add('today');
                }

                dayCapsule.setAttribute('data-date', dateKey);
                dayCapsule.onclick = function() {
                    selectCalendarDay(dateKey, dayCapsule);
                };

                // Dzień tygodnia (nazwa)
                const nameSpan = document.createElement('span');
                nameSpan.className = 'day-name';
                nameSpan.innerText = dayShortNames[dayOfWeek];
                dayCapsule.appendChild(nameSpan);

                // Dzień miesiąca (numer)
                const numSpan = document.createElement('span');
                numSpan.className = 'day-num';
                numSpan.innerText = day;
                dayCapsule.appendChild(numSpan);

                container.appendChild(dayCapsule);
            }

            // Domyślne zaznaczenie dnia:
            // Jeśli dzisiaj są wydarzenia, zaznaczamy dzisiaj.
            // W przeciwnym wypadku wyświetlamy najbliższe wydarzenia (dzisiejszy dzień i tak jest oznaczony klasą today).
            const todayCapsule = container.querySelector(`[data-date="${todayStr}"]`);
            if (todayCapsule && calendarEvents[todayStr] && calendarEvents[todayStr].length > 0) {
                selectCalendarDay(todayStr, todayCapsule);
            } else {
                displayEventsForDate(null);
            }
        }

        // Funkcja obsługująca kliknięcie dnia
        function selectCalendarDay(dateKey, element) {
            const capsules = document.querySelectorAll('.calendar-day-capsule');
            capsules.forEach(cap => cap.classList.remove('active'));

            element.classList.add('active');

            displayEventsForDate(dateKey);
        }

        // Wyświetlanie wydarzeń z wybranego dnia
        function displayEventsForDate(dateKey) {
            const displayContainer = document.getElementById('calEventsDisplay');
            displayContainer.innerHTML = '';

            if (!dateKey || !calendarEvents[dateKey] || calendarEvents[dateKey].length === 0) {
                // POKAŻ NAJBLIŻSZE WYDARZENIA ZAMIAST INFORMACJI O BRAKU
                const upcoming = getUpcomingEvents(3);
                
                const titleHeader = document.createElement('h5');
                titleHeader.className = 'calendar-events-title';
                titleHeader.innerHTML = `<i class="bi bi-calendar-heart text-primary"></i> Najbliższe wydarzenia`;
                displayContainer.appendChild(titleHeader);

                if (upcoming.length === 0) {
                    displayContainer.innerHTML += `
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary-emphasis opacity-50"></i>
                            <p class="m-0 fw-semibold">Brak zaplanowanych wydarzeń w najbliższym czasie.</p>
                        </div>
                    `;
                    return;
                }

                upcoming.forEach(ev => {
                    const card = document.createElement('div');
                    card.className = 'cal-event-card';

                    const metaDiv = document.createElement('div');
                    metaDiv.className = 'cal-event-meta';

                    // Data zamiast godziny
                    const parts = ev.date.split('-');
                    const eventReadableDate = `${parseInt(parts[2])} ${monthNames[parseInt(parts[1])-1]}`;

                    const dateSpan = document.createElement('span');
                    dateSpan.className = 'cal-event-date-badge';
                    dateSpan.innerHTML = `<i class="bi bi-calendar3 text-primary"></i> ${eventReadableDate}`;
                    metaDiv.appendChild(dateSpan);

                    const catBadge = document.createElement('span');
                    catBadge.className = 'badge bg-light text-secondary border border-light-subtle px-2 py-1';
                    catBadge.style.fontSize = '0.7rem';
                    catBadge.style.fontWeight = '600';
                    catBadge.innerText = ev.category;
                    metaDiv.appendChild(catBadge);

                    card.appendChild(metaDiv);

                    // Tytuł
                    const titleLink = document.createElement('a');
                    titleLink.className = 'cal-event-title-link';
                    titleLink.href = ev.url;
                    titleLink.innerText = ev.title;
                    card.appendChild(titleLink);

                    // Tagi
                    if (ev.tags) {
                        const tagsSmall = document.createElement('small');
                        tagsSmall.className = 'text-secondary';
                        tagsSmall.style.fontSize = '0.8rem';
                        tagsSmall.innerHTML = `<i class="bi bi-tag me-1"></i>${ev.tags}`;
                        card.appendChild(tagsSmall);
                    }

                    displayContainer.appendChild(card);
                });
                return;
            }

            // SĄ WYDARZENIA W DANYM DNIU
            const events = calendarEvents[dateKey];
            
            const parts = dateKey.split('-');
            const readableDate = `${parseInt(parts[2])} ${monthNames[parseInt(parts[1])-1]}`;
            
            const titleHeader = document.createElement('h5');
            titleHeader.className = 'calendar-events-title';
            titleHeader.innerHTML = `<i class="bi bi-calendar-check text-primary"></i> Wydarzenia: ${readableDate}`;
            displayContainer.appendChild(titleHeader);

            events.forEach(ev => {
                const card = document.createElement('div');
                card.className = 'cal-event-card';

                const metaDiv = document.createElement('div');
                metaDiv.className = 'cal-event-meta';

                const catBadge = document.createElement('span');
                catBadge.className = 'badge bg-light text-secondary border border-light-subtle px-2 py-1';
                catBadge.style.fontSize = '0.7rem';
                catBadge.style.fontWeight = '600';
                catBadge.innerText = ev.category;
                metaDiv.appendChild(catBadge);

                card.appendChild(metaDiv);

                // Tytuł
                const titleLink = document.createElement('a');
                titleLink.className = 'cal-event-title-link';
                titleLink.href = ev.url;
                titleLink.innerText = ev.title;
                card.appendChild(titleLink);

                // Tagi
                if (ev.tags) {
                    const tagsSmall = document.createElement('small');
                    tagsSmall.className = 'text-secondary';
                    tagsSmall.style.fontSize = '0.8rem';
                    tagsSmall.innerHTML = `<i class="bi bi-tag me-1"></i>${ev.tags}`;
                    card.appendChild(tagsSmall);
                }

                displayContainer.appendChild(card);
            });
        }

        // Nawigacja - poprzedni miesiąc
        function prevMonth() {
            calMonth--;
            if (calMonth < 0) {
                calMonth = 11;
                calYear--;
            }
            generateCalendar(calYear, calMonth);
        }

        // Nawigacja - następny miesiąc
        function nextMonth() {
            calMonth++;
            if (calMonth > 11) {
                calMonth = 0;
                calYear++;
            }
            generateCalendar(calYear, calMonth);
        }

        // Uruchomienie kalendarza po załadowaniu DOM
        document.addEventListener('DOMContentLoaded', function() {
            generateCalendar(calYear, calMonth);
        });
    </script>

   
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
                        <div class="position-relative overflow-hidden" style="height: 300px;">
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
<!-- NOWA SEKCJA ZAJĘĆ - KAFELKI -->
    <div class="mb-5 animate__animated animate__fadeInUp">
        <div class="text-center mb-5">
            <span class="badge bg-primary text-white text-uppercase px-3 py-1 mb-2"
                style="font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px;">Rozwijaj swoje pasje</span>
            <h2 class="fw-bold text-dark mb-2 display-6" style="font-family: 'Montserrat', sans-serif;">
                Zajęcia w Domu Kultury
            </h2>
            <p class="text-secondary mx-auto" style="max-width: 600px; font-size: 0.95rem;">
                Oferujemy bogaty program zajęć i warsztatów dostosowanych do każdego wieku. Wybierz swoją ścieżkę i dołącz do naszej artystycznej społeczności!
            </p>
            <div class="d-flex justify-content-center mt-3">
                <div style="width: 50px; height: 3px; background-color: #0d6efd; border-radius: 2px;"></div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <!-- 1. Muzyczne -->
            <div class="col-lg-3 col-sm-6">
                <div class="card zajecia-card shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1511192336575-5a79af67a629?auto=format&fit=crop&w=600&q=80" class="w-100 h-100 object-fit-cover" alt="Zajęcia muzyczne">
                        <div class="zajecia-overlay"></div>
                        <span class="badge badge-zajecia bg-primary text-white">Muzyka</span>
                        <div class="zajecia-icon-btn btn-zajecia-muzyczne">
                            <i class="bi bi-music-note-beamed fs-5"></i>
                        </div>
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-2">Zajęcia Muzyczne</h5>
                            <p class="text-muted small mb-4">Nauka gry na instrumentach (gitara, pianino), śpiew solowy, chór oraz zespoły wokalno-instrumentalne.</p>
                        </div>
                        <a href="zajecia-muzyczne.html" class="btn btn-outline-primary btn-sm rounded-pill w-100 hover-scale-btn" style="font-weight: 600;">
                            Zobacz ofertę <i class="bi bi-arrow-right-short ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- 2. Plastyczne -->
            <div class="col-lg-3 col-sm-6">
                <div class="card zajecia-card shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=600&q=80" class="w-100 h-100 object-fit-cover" alt="Zajęcia plastyczne">
                        <div class="zajecia-overlay"></div>
                        <span class="badge badge-zajecia bg-success text-white">Plastyka</span>
                        <div class="zajecia-icon-btn btn-zajecia-plastyczne">
                            <i class="bi bi-palette-fill fs-5"></i>
                        </div>
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-2">Zajęcia Plastyczne</h5>
                            <p class="text-muted small mb-4">Rysunek, malarstwo sztalugowe, ceramika, rzeźba, rękodzieło artystyczne oraz warsztaty kreatywne dla dzieci.</p>
                        </div>
                        <a href="zajecia-plastyczne.html" class="btn btn-outline-success btn-sm rounded-pill w-100 hover-scale-btn" style="font-weight: 600;">
                            Zobacz ofertę <i class="bi bi-arrow-right-short ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- 3. Taneczne -->
            <div class="col-lg-3 col-sm-6">
                <div class="card zajecia-card shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1579024976750-295640494b1e?auto=format&fit=crop&w=600&q=80" class="w-100 h-100 object-fit-cover" alt="Zajęcia taneczne">
                        <div class="zajecia-overlay"></div>
                        <span class="badge badge-zajecia bg-danger text-white">Taniec</span>
                        <div class="zajecia-icon-btn btn-zajecia-taneczne">
                            <i class="bi bi-person-walking fs-5"></i>
                        </div>
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-2">Zajęcia Taneczne</h5>
                            <p class="text-muted small mb-4">Taniec nowoczesny, balet dla najmłodszych, taniec ludowy, zumba oraz zajęcia ruchowo-rytmiczne.</p>
                        </div>
                        <a href="zajecia-taneczne.html" class="btn btn-outline-danger btn-sm rounded-pill w-100 hover-scale-btn" style="font-weight: 600;">
                            Zobacz ofertę <i class="bi bi-arrow-right-short ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- 4. Pozostałe -->
            <div class="col-lg-3 col-sm-6">
                <div class="card zajecia-card shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80" class="w-100 h-100 object-fit-cover" alt="Inne warsztaty">
                        <div class="zajecia-overlay"></div>
                        <span class="badge badge-zajecia bg-warning text-dark">Pozostałe</span>
                        <div class="zajecia-icon-btn btn-zajecia-pozostale">
                            <i class="bi bi-grid-fill fs-5"></i>
                        </div>
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-2">Inne Zajęcia</h5>
                            <p class="text-muted small mb-4">Klub szachowy, warsztaty teatralne, nauka języków obcych, zajęcia komputerowe oraz klub seniora.</p>
                        </div>
                        <a href="zajecia-inne.html" class="btn btn-outline-warning btn-sm rounded-pill w-100 hover-scale-btn" style="font-weight: 600;">
                            Zobacz ofertę <i class="bi bi-arrow-right-short ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- DOŁĄCZ DO ZAJĘĆ - UATRAKCYJNIONY BOX CTA -->
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative p-4 p-md-5 mb-5"
            style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-left: 6px solid #0d6efd !important;">
            <!-- Elementy ozdobne w tle (poświaty) -->
            <div class="position-absolute rounded-circle" style="width: 250px; height: 250px; background: radial-gradient(circle, rgba(13, 110, 253, 0.2) 0%, transparent 70%); top: -80px; right: -40px; pointer-events: none;"></div>
            <div class="position-absolute rounded-circle" style="width: 150px; height: 150px; background: radial-gradient(circle, rgba(25, 135, 84, 0.15) 0%, transparent 70%); bottom: -40px; left: -40px; pointer-events: none;"></div>
            
            <div class="position-relative z-1 d-flex flex-column flex-xl-row align-items-xl-center justify-content-between gap-4">
                <div>
                    <span class="badge bg-primary text-white text-uppercase px-3 py-1 mb-3"
                        style="font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px; box-shadow: 0 4px 10px rgba(13, 110, 253, 0.35);">Zapisy trwają!</span>
                    <h3 class="fw-bold text-white mb-2" style="font-family: 'Montserrat', sans-serif; font-size: 1.8rem;">Rozpocznij swoją artystyczną przygodę</h3>
                    <p class="m-0 text-white-50" style="font-size: 0.95rem; max-width: 800px;">
                        Nasze zajęcia to idealny sposób na rozwijanie talentów, relaks po szkole lub pracy oraz spotkanie kreatywnych ludzi. Gwarantujemy profesjonalną kadrę instruktorską oraz świetnie wyposażone pracownie.
                    </p>
                </div>
                <div class="flex-shrink-0 d-flex flex-column flex-sm-row gap-3">
                    <a href="kontakt.html" class="btn btn-primary btn-lg rounded-pill px-4 py-3 shadow hover-scale-btn d-flex align-items-center justify-content-center gap-2"
                        style="font-weight: 700; font-size: 0.95rem; border-width: 0; background-color: #0d6efd;">
                        <i class="bi bi-people-fill fs-5"></i> Zapisz się online
                    </a>
                    <a href="kontakt.html" class="btn btn-outline-light btn-lg rounded-pill px-4 py-3 hover-scale-btn d-flex align-items-center justify-content-center gap-2"
                        style="font-weight: 600; font-size: 0.95rem;">
                        <i class="bi bi-telephone-fill fs-5"></i> Skontaktuj się
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- 7. Kalendarz wydarzeń -->
            <div class="mt-5 animate__animated animate__fadeInUp">
                <h3 class="fw-bold text-dark mb-4 section-header-line section-header-primary"
                    style="font-family: 'Montserrat', sans-serif;">
                    Kalendarz wydarzeń
                </h3>
                <?php calendar(); ?>

                <? strony('index'); ?>
            </div>
        </div>
        <div class="content col-md-4 bg-light p-3 border pt-5 ">
            <!-- 8. Ogłoszenia (Nowości) -->
           <? sidebar(); ?>
           <!-- Informacje o placówce / mini widget -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-5 bg-white text-dark animate__animated animate__fadeInUp" style="border-top: 4px solid #ffc107 !important;">
                <h4 class="fw-bold mb-3" style="font-family: 'Montserrat', sans-serif; font-size: 1.25rem;">Gminny Ośrodek Kultury</h4>
                <p class="text-secondary small mb-4">Miejsce spotkań z kulturą, sztuką i drugim człowiekiem. Jesteśmy otwarci dla każdego!</p>
                
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-clock text-warning fs-5"></i>
                        </div>
                        <div>
                            <span class="d-block fw-bold small">Godziny otwarcia</span>
                            <span class="text-muted small">Pon. - Pt.: 8:00 - 16:00</span>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-geo-alt text-warning fs-5"></i>
                        </div>
                        <div>
                            <span class="d-block fw-bold small">Nasza lokalizacja</span>
                            <span class="text-muted small">Lipnik</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-telephone text-warning fs-5"></i>
                        </div>
                        <div>
                            <span class="d-block fw-bold small">Zadzwoń do nas</span>
                            <span class="text-muted small">+48 </span>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4 text-muted">
                
                <div class="text-center">
                    <span class="d-block text-secondary small mb-2">Masz pytania dotyczące zajęć?</span>
                    <a href="kontakt.html" class="btn btn-outline-warning btn-sm rounded-pill px-4 fw-semibold w-100 text-decoration-none d-block">Napisz wiadomość</a>
                </div>
            </div>
        </div>
    </div>
</div>