// This is just a template article to redirect to the actual page, remove the header("Location: ../index/index.php?error=access") to access it. Then name the file according to the article and separate it with "-" for each word.

<?php 
include "../server/sesi.php"; 
include "../server/koneksi.php";
header("Location: ../index/index.php?error=access")
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Safelink.AI</title>

  <?php include "../universal/head.php" ?>

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <?php include "navbar.php" ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2 text-center">
            Iklan 1 disini
          </div>
          <div class="col-md-8">
            <div class="card">
              <div class="card-body text-center">
              <?php
              // Periksa apakah parameter query string 'link' diatur
              if (isset($_GET['link'])) {
                  $safeLink1 = $_GET['link'];

                  // Ambil data dari tabel link berdasarkan safeLink1
                  $query = "SELECT safeLink2 FROM link WHERE safeLink1 = ?";
                  $stmt = $conn->prepare($query);
                  $stmt->bind_param("s", $safeLink1);
                  $stmt->execute();
                  $stmt->bind_result($safeLink2);

                  // Periksa apakah data ditemukan
                  if ($stmt->fetch()) {
                      echo "<h5>Please Wait ...</h5><br>";

                      // Tampilkan progress bar Bootstrap
                      echo "<div class='progress'>";
                      echo "  <div id='progressBar' class='progress-bar bg-success progress-bar-striped' role='progressbar' style='width: 0%;' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>0%</div>";
                      echo "</div><br>";

                      // Tampilkan tombol "Redirect Me" yang awalnya dinonaktifkan
                      // Mendapatkan daftar file di folder tertentu
                      $articleFolder = '../go'; // Gantilah dengan path yang sesuai
                      $articleFiles = glob($articleFolder . '/*.php');
                      $excludeFile = $articleFolder . '/index.php';

                      // Mengeksklusikan index.php dari daftar file
                      if (file_exists($excludeFile)) {
                          $articleFiles = array_diff($articleFiles, [$excludeFile]);
                      }

                      // Mengambil secara acak salah satu artikel
                      $randomArticle = $articleFiles[array_rand($articleFiles)];

                      // Mengambil secara acak salah satu artikel
                      $randomArticle = $articleFiles[array_rand($articleFiles)];

                      echo "<a id='redirectButton' href='$randomArticle?link=$safeLink2' class='btn btn-primary disabled'>Redirect Me</a>";

                      // Script JavaScript untuk mengatur progress bar dan mengaktifkan tombol
                      echo "<script>";
                      echo "  var progressBar = document.getElementById('progressBar');";
                      echo "  var redirectButton = document.getElementById('redirectButton');";

                      // Fungsi untuk menambah nilai progress bar dari 0 ke 100 dalam 10 detik
                      echo "  function updateProgressBar() {";
                      echo "    var value = 0;";
                      echo "    var interval = setInterval(function() {";
                      echo "      value++;";
                      echo "      progressBar.style.width = value + '%';";
                      echo "      progressBar.innerHTML = value + '%';";
                      echo "      if (value >= 100) {";
                      echo "        clearInterval(interval);";
                      echo "        redirectButton.classList.remove('disabled');";
                      echo "      }";
                      echo "    }, 100);"; // Interval 100ms untuk setiap iterasi
                      echo "  }";

                      // Panggil fungsi ketika halaman selesai dimuat
                      echo "  window.onload = function() {";
                      echo "    updateProgressBar();";
                      echo "  }";
                      echo "</script>";

                  } else {
                      echo "Link not found.";
                  }

                  // Tutup statement
                  $stmt->close();
              } else {
                  echo "Link parameter is not set.";
              }
              ?>
              </div>
            </div>
          </div>
          <div class="col-md-2 text-center">
            Iklan 2 disini
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <!-- Footer -->

  <?php include "../universal/footer.php" ?>

  <!-- /Footer -->

</div>
<!-- ./wrapper -->

<!-- Script -->

<?php include "../universal/script.php" ?>

<!-- /Script -->
</body>
</html>