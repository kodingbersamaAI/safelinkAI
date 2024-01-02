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
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Buat query SQL untuk menghapus buku baru
    $query = "DELETE FROM link WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        // linka berhasil dihapus, arahkan ke halaman sukses atau daftar buku
        header("Location: ../index.php?success=delete"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal menghapus buku, tampilkan pesan kesalahan
        header("Location: ../index.php?error=delete");
        exit();
    }

}
?>
