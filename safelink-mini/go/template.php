<?php 
include "../server/sesi.php"; 
include "../server/koneksi.php";

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
            Ads 1 here
          </div>
          <div class="col-md-8">
            <div class="card">
              <div class="card-body text-center">
                <h4>What is AI?</h4>
              <?php
              // Periksa apakah parameter query string 'link' diatur
              if (isset($_GET['link'])) {
                  $safeLink2 = $_GET['link'];

                  // Ambil data dari tabel link berdasarkan safeLink1
                  $query = "SELECT realLink FROM link WHERE safeLink2 = ?";
                  $stmt = $conn->prepare($query);
                  $stmt->bind_param("s", $safeLink2);
                  $stmt->execute();
                  $stmt->bind_result($realLink);

                  // Periksa apakah data ditemukan
                  if ($stmt->fetch()) {
                      echo "<h5>Please Wait ...</h5><br>";

                      // Tampilkan progress bar Bootstrap
                      echo "<div class='progress'>";
                      echo "  <div id='progressBar' class='progress-bar bg-success progress-bar-striped' role='progressbar' style='width: 0%;' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>0%</div>";
                      echo "</div><br>";

                      echo "
                      <p>
                      Artificial Intelligence (AI) is a branch of computer science that focuses on creating systems capable of performing tasks that would typically require human intelligence. These tasks include learning, reasoning, problem-solving, understanding natural language, and perception.
                      </p>
                      <p>
                      AI systems use algorithms and data to simulate human cognitive functions. Machine learning, a subset of AI, enables systems to learn and improve from experience without explicit programming. AI applications are diverse, ranging from voice assistants and image recognition to autonomous vehicles and medical diagnostics.
                      </p>
                      <p>
                      As AI continues to advance, its impact on various industries and daily life becomes more profound. Understanding the principles of AI is crucial in navigating the evolving technological landscape.
                      </p><br>";

                      // Tampilkan tombol "Redirect Me" yang awalnya dinonaktifkan
                      echo "<a id='redirectButton' href='$realLink' class='btn btn-primary disabled'>Go to my link</a><br><br>";

                      echo "<p>
                      add article
                      </p>";

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
                  echo "<b>Link parameter is not set.</b>";
              }
              ?>
              </div>
            </div>
          </div>
          <div class="col-md-2 text-center">
            Ads 2 here
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