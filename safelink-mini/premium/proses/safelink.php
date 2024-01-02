<?php
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, tindakan apa yang perlu diambil? Redirect atau tindakan lainnya.
    // Misalnya:
    header("Location: ../index.php?error=access"); // Ganti dengan halaman yang sesuai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userLink = filter_input(INPUT_POST, 'userLink', FILTER_SANITIZE_STRING);
    $safeLink2 = uniqid() . '-' . uniqid() . '-' . uniqid();
    $rawRealLink = filter_input(INPUT_POST, 'realLink', FILTER_SANITIZE_STRING);

    // Memisahkan URL yang dipisahkan oleh tanda titik koma
    $realLinksArray = explode(';', $rawRealLink);

    // Validasi dan bersihkan setiap URL
    $cleanedRealLinks = array_map('trim', $realLinksArray);
    $cleanedRealLinks = array_filter($cleanedRealLinks, function($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    });

    // Simpan semua safeLink1 yang dihasilkan dalam array
    $allSafeLinks = [];

    // Buat query SQL untuk menambahkan setiap URL ke dalam database
    foreach ($cleanedRealLinks as $currentUrl) {
        $safeLink1 = uniqid(); // Generate unique safeLink1 for each URL

        // Buat query SQL untuk memeriksa keberadaan safeLink1 di database
        $queryCheck = "SELECT COUNT(*) AS linkCount FROM link WHERE safeLink1 = ?";
        $stmtCheck = $conn->prepare($queryCheck);
        $stmtCheck->bind_param("s", $safeLink1);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        $rowCheck = $resultCheck->fetch_assoc();

        // Periksa apakah safeLink1 sudah ada di database
        if ($rowCheck['linkCount'] > 0) {
            // Jika safeLink1 sudah ada, buat safeLink1 baru hingga tidak ada duplikat
            do {
                $safeLink1 = uniqid();
                $stmtCheck->bind_param("s", $safeLink1);
                $stmtCheck->execute();
                $resultCheck = $stmtCheck->get_result();
                $rowCheck = $resultCheck->fetch_assoc();
            } while ($rowCheck['linkCount'] > 0);
        }

        // Simpan safeLink1 dalam array
        $allSafeLinks[] = $safeLink1;

        // Buat query SQL untuk menambahkan URL ke dalam database
        $stmt = $conn->prepare("INSERT INTO link (userLink, safeLink1, safeLink2, realLink) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $userLink, $safeLink1, $safeLink2, $currentUrl);
        $stmt->execute();
        // Reset statement for the next iteration
        $stmt->close();
    }

    // Pengguna berhasil ditambahkan, arahkan ke halaman sukses atau daftar buku
    header("Location: ../index.php?success=safelink&links=" . implode(',', $allSafeLinks));
    exit();
} else {
    // Gagal menambahkan buku, tampilkan pesan kesalahan
    header("Location: ../index.php?error=safelink");
    exit();
}

?>
