<?php 
require('sesi.php'); 
require('koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, tindakan apa yang perlu diambil? Redirect atau tindakan lainnya.
    // Misalnya:
    header("Location: ../index.php?error=access"); // Ganti dengan halaman yang sesuai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailUser = filter_input(INPUT_POST, 'emailUser', FILTER_SANITIZE_STRING);
    $passwordUser = filter_input(INPUT_POST, 'passwordUser', FILTER_SANITIZE_STRING);

    $query = "SELECT * FROM user WHERE emailUser = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $emailUser);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($passwordUser, $row['passwordUser'])) {
                $_SESSION['idUser'] = $row['idUser'];
                $_SESSION['emailUser'] = $row['emailUser'];
                $_SESSION['nameUser'] = $row['nameUser'];
                $_SESSION['roleUser'] = $row['roleUser'];
                if ($row['roleUser'] === 'admin') {
                    header("Location: ../admin/");
                } else if ($row['roleUser'] === 'basic') {
                    header("Location: ../basic/");
                } else if ($row['roleUser'] === 'premium') {
                    header("Location: ../premium/");
                } else {
                    header("Location: ../../index.php");
                }
                exit;
            } else {
                // Password tidak cocok
                header("Location: ../index.php?error=password");
                exit();
            }
        } else {
            // Pengguna tidak ditemukan
            header("Location: ../index.php?error=user");
            exit();
        }
    } else {
        // Kesalahan pada prepared statement
        header("Location: ../index.php?error=database");
        exit();
    }
}

// Redirect jika tidak menggunakan metode POST
header("Location: ../index.php?error=access");
?>
