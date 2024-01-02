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
    $idUser = uniqid();
    $nameUser = filter_input(INPUT_POST, 'nameUser', FILTER_SANITIZE_STRING);
    $emailUser = filter_input(INPUT_POST, 'emailUser', FILTER_SANITIZE_EMAIL);
    $passwordUser = password_hash(filter_input(INPUT_POST, 'passwordUser', FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);
    $codeUser = rand(100000, 999999);
    $terms = filter_input(INPUT_POST, 'terms', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan
    // Cek apakah email sudah terdaftar
    $checkEmailQuery = "SELECT * FROM user WHERE emailUser = ?";
    $checkEmailStmt = $conn->prepare($checkEmailQuery);
    $checkEmailStmt->bind_param("s", $emailUser);
    $checkEmailStmt->execute();
    $checkEmailResult = $checkEmailStmt->get_result();

    if ($checkEmailResult->num_rows > 0) {
        // Email sudah terdaftar, tindakan apa yang perlu diambil? Redirect atau tampilkan pesan kesalahan.
        // Misalnya:
        header("Location: ../register.php?error=email");
        exit();
    }

    // Cek kesamaan password
    $passwordMatch = password_verify(filter_input(INPUT_POST, 'retypePassword', FILTER_SANITIZE_STRING), $passwordUser);

    if (!$passwordMatch) {
        // Password tidak cocok, tindakan apa yang perlu diambil? Redirect atau tampilkan pesan kesalahan.
        // Misalnya:
        header("Location: ../register.php?error=password");
        exit();
    }

    // Cek persetujuan
    if ($terms !== "agree") {
        // Persetujuan tidak dicentang, tindakan apa yang perlu diambil? Redirect atau tampilkan pesan kesalahan.
        // Misalnya:
        header("Location: ../register.php?error=terms");
        exit();
    }

    // Buat query SQL untuk menambahkan user baru
    $query = "INSERT INTO user (idUser, nameUser, emailUser, passwordUser, roleUser, codeUser) VALUES (?,  ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $roleUser = filter_input(INPUT_POST, 'roleUser', FILTER_SANITIZE_STRING);
    $stmt->bind_param("ssssss", $idUser, $nameUser, $emailUser, $passwordUser, $roleUser, $codeUser);

    if ($stmt->execute()) {
        // Pengguna berhasil didaftarkan, arahkan ke halaman sukses atau login
        header("Location: ../register.php?success=register");
        exit();
    } else {
        // Gagal menambahkan pengguna, arahkan ke halaman kesalahan
        header("Location: ../register.php?error=register");
        exit();
    }
}
?>
