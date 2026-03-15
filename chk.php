<?php
$folder = __DIR__;  // <-- zmień na ścieżkę do Twojego folderu
$plik_suma = 'suma_kontrolna.json';

// Wczytanie poprzednich sum kontrolnych
$stare_sumy = [];
if (file_exists($plik_suma)) {
    $stare_sumy = json_decode(file_get_contents($plik_suma), true);
}

// Tablica na aktualne sumy
$aktualne_sumy = [];

// Przechodzimy przez wszystkie pliki w folderze
foreach (scandir($folder) as $plik) {
    if ($plik === '.' || $plik === '..') continue;

    $ścieżka = $folder . DIRECTORY_SEPARATOR . $plik;
    if (is_file($ścieżka)) {
        $suma = hash_file('sha256', $ścieżka);
        $aktualne_sumy[$plik] = $suma;

        // Sprawdzamy czy plik został zmieniony
        if (isset($stare_sumy[$plik])) {
            if ($stare_sumy[$plik] !== $suma) {
                echo "Plik $plik został zmieniony!\n";
            }
        } else {
            echo "Nowy plik wykryty: $plik\n";
        }
    }
}

// Sprawdzamy, czy jakieś pliki zostały usunięte
foreach ($stare_sumy as $plik => $suma) {
    if (!isset($aktualne_sumy[$plik])) {
        echo "Plik $plik został usunięty!\n";
    }
}

// Zapis aktualnych sum do pliku JSON
file_put_contents($plik_suma, json_encode($aktualne_sumy, JSON_PRETTY_PRINT));
echo "Suma kontrolna zaktualizowana i zapisana do $plik_suma\n";
?>
