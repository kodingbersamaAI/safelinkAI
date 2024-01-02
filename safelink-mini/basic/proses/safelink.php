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
    $safeLink1 = uniqid();
    $safeLink2 = uniqid() . '-' . uniqid() . '-' . uniqid();
    $realLink = filter_input(INPUT_POST, 'realLink', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Buat query SQL untuk menghitung jumlah link yang dibuat oleh userLink pada hari ini
    date_default_timezone_set('Asia/Jakarta'); // Sesuaikan dengan zona waktu yang benar
    $today = date("Y-m-d");
    $queryCountLink = "SELECT COUNT(*) AS totalLink FROM link WHERE userLink = ? AND DATE(dateLink) = ?";
    
    // Persiapkan statement
    $stmtCountLink = $conn->prepare($queryCountLink);

    if ($stmtCountLink) {
        // Bind parameter dan eksekusi statement
        $stmtCountLink->bind_param("ss", $userLink, $today);
        $stmtCountLink->execute();

        // Ambil hasil query
        $resultCountLink = $stmtCountLink->get_result();

        // Periksa apakah query berhasil dieksekusi
        if ($resultCountLink) {
            // Ambil hasil query
            $rowCountLink = $resultCountLink->fetch_assoc();
            $totalLink = $rowCountLink['totalLink'];

            // Periksa apakah total link melebihi 50
            if ($totalLink > 49) {
                // Redirect ke halaman tertentu jika lebih dari 50 link
                header("Location: ../index.php?error=quota");
                exit;
            }
        } else {
            // Handle jika query tidak berhasil dieksekusi
            // Lakukan sesuai kebutuhan
        }

        // Tutup statement
        $stmtCountLink->close();
    } else {
        // Handle jika prepared statement tidak berhasil dibuat
        // Lakukan sesuai kebutuhan
    }

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

    // Buat query SQL untuk menambahkan buku baru
    $query = "INSERT INTO link (userLink, safeLink1, safeLink2, realLink) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $userLink, $safeLink1, $safeLink2, $realLink);

    if ($stmt->execute()) {
        // Pengguna berhasil ditambahkan, arahkan ke halaman sukses atau daftar buku
        header("Location: ../index.php?success=safelink&link=$safeLink1"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal menambahkan buku, tampilkan pesan kesalahan
        header("Location: ../index.php?error=safelink");
        exit();
    }

}
?>
