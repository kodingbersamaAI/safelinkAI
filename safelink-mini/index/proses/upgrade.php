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
    // Ambil nilai email dan code dari formulir
    $emailUser = filter_input(INPUT_POST, 'emailUser', FILTER_SANITIZE_EMAIL);
    $codeUser = filter_input(INPUT_POST, 'codeUser', FILTER_SANITIZE_STRING);
    $dateUpgradeUser = filter_input(INPUT_POST, 'dateUpgradeUser', FILTER_SANITIZE_STRING);
    $terms = filter_input(INPUT_POST, 'terms', FILTER_SANITIZE_STRING);

    // Validasi email dan codeUser jika diperlukan

    // Lakukan query untuk memeriksa kecocokan email dan codeUser di tabel user
    $queryCheck = "SELECT * FROM user WHERE emailUser = ? AND codeUser = ?";
    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bind_param("ss", $emailUser, $codeUser);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    // Cek persetujuan
    if ($terms !== "agree") {
        // Persetujuan tidak dicentang, tindakan apa yang perlu diambil? Redirect atau tampilkan pesan kesalahan.
        // Misalnya:
        header("Location: ../upgrade.php?error=terms");
        exit();
    }

    // Periksa apakah email dan codeUser cocok
    if ($resultCheck->num_rows > 0) {
        // Jika cocok, lakukan query untuk melakukan upgrade roleUser menjadi 'premium'
        $queryUpdate = "UPDATE user SET roleUser = 'premium', dateUpgradeUser = ? WHERE emailUser = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("ss", $dateUpgradeUser, $emailUser);
        $stmtUpdate->execute();

        // Lakukan tindakan lanjutan jika diperlukan, misalnya, arahkan pengguna ke halaman sukses
        header("Location: ../upgrade.php?success=upgrade"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Jika email dan codeUser tidak cocok, arahkan pengguna ke halaman error
        header("Location: ../upgrade.php?error=upgrade"); // Ganti dengan halaman yang sesuai
        exit();
    }
} else {
    // Jika request bukan menggunakan metode POST, arahkan pengguna ke halaman lain atau lakukan tindakan lainnya.
    header("Location: ../upgrade.php?error=access"); // Ganti dengan halaman yang sesuai
    exit();
}
?>
