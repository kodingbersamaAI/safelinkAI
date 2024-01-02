<?php 
include "../server/sesi.php"; 
include "../server/koneksi.php";

// Mendapatkan IP address pengguna
$user_ip = $_SERVER['REMOTE_ADDR'];

// Mendapatkan informasi ISP berdasarkan IP address
$isp_info = gethostbyaddr($user_ip);

// Set sesi nameUser dengan nilai $isp_info
$_SESSION['nameGuest'] = $isp_info;

// Set cookie dengan nama 'nameUser' dan masa berlaku 1 hari
setcookie('nameGuest', $isp_info, time() + (60 * 60 * 24)); // Cookie berlaku selama 1 hari

if (isset($_SESSION['roleUser'])) {
  switch ($_SESSION['roleUser']) {
    case 'admin':
        header('Location: ../admin');
        exit(); // Pastikan untuk keluar setelah melakukan pengalihan header
        break;
    case 'basic':
        header('Location: ../basic');
        exit();
        break;
    case 'premium':
        header('Location: ../premium');
        exit();
        break;
    // Tambahkan kasus lain jika diperlukan
    default:
        // Default action jika tidak ada peran yang cocok
        break;
  }
}
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
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-star"></i></span>
              <div class="info-box-content">
                <?php
                // Buat query SQL untuk menghitung jumlah siswa
                $query = "SELECT COUNT(*) AS totalMember FROM user WHERE roleUser = 'premium'";
                $result = $conn->query($query);

                // Periksa apakah query berhasil dieksekusi
                if ($result) {
                    // Ambil hasil query
                    $row = $result->fetch_assoc();
                    $totalMember = $row['totalMember'];
                } else {
                    // Handle jika query tidak berhasil dieksekusi
                    $totalMember = 0; // Atau sesuaikan dengan nilai default yang sesuai
                }

                // Tampilkan data di dalam HTML
                ?>
                <h4><span class="info-box-text"><?php echo $totalMember; ?></span></h4>
                <span class="info-box-number">Premium Member</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <?php
                // Buat query SQL untuk menghitung jumlah siswa
                $query = "SELECT COUNT(*) AS totalMember FROM user WHERE roleUser = 'basic'";
                $result = $conn->query($query);

                // Periksa apakah query berhasil dieksekusi
                if ($result) {
                    // Ambil hasil query
                    $row = $result->fetch_assoc();
                    $totalMember = $row['totalMember'];
                } else {
                    // Handle jika query tidak berhasil dieksekusi
                    $totalMember = 0; // Atau sesuaikan dengan nilai default yang sesuai
                }

                // Tampilkan data di dalam HTML
                ?>
                <h4><span class="info-box-text"><?php echo $totalMember; ?></span></h4>
                <span class="info-box-number">Registered Member</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-link"></i></span>
              <div class="info-box-content">
                <?php
                // Buat query SQL untuk menghitung jumlah siswa
                $query = "SELECT COUNT(*) AS totalLink FROM link";
                $result = $conn->query($query);

                // Periksa apakah query berhasil dieksekusi
                if ($result) {
                    // Ambil hasil query
                    $row = $result->fetch_assoc();
                    $totalLink = $row['totalLink'];
                } else {
                    // Handle jika query tidak berhasil dieksekusi
                    $totalLink = 0; // Atau sesuaikan dengan nilai default yang sesuai
                }

                // Tampilkan data di dalam HTML
                ?>
                <h4><span class="info-box-text"><?php echo $totalLink; ?></span></h4>
                <span class="info-box-number">Active Safelink</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <hr>
        <!-- Menu Seacrh -->
        <h2 class="text-center display-5">Safelink.AI</h2>
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <div id="captchaContainer" class="form-group row">
              <label for="captcha" id="captchaQuestion" class="form-text text-muted"></label> 
              <div class="col-sm-10 input-group">
                <input type="text" class="form-control" id="captcha" name="captcha" placeholder="Enter the result">
                <div class="input-group-append">
                  <button type="button" class="btn btn-secondary" onclick="generateCaptcha()"><li class="fas fa-random"></li></button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8 offset-md-2">
            <form action="proses/safelink.php" method="POST" onsubmit="return validateFormAndUrl()">
              <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
              <input type="hidden" name="userLink" value="<?php echo isset($_SESSION['nameUser']) ? $_SESSION['nameUser'] : $_SESSION['nameGuest']; ?>">
              <input type="hidden" name="safelink1">
              <input type="hidden" name="safelink2">
              <div class="input-group">
                <input type="text" class="form-control form-control-lg" id="realLink" name="realLink" placeholder="Enter a valid URL (with http/https)" required>        
                <div class="input-group-append">
                  <button type="submit" class="btn btn-lg btn-default">
                    <i class="fa fa-link"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
          <br><br><br>
          <div class="col-md-4 offset-md-4">
            <?php
            // Periksa apakah parameter query string 'link' diatur
            if (isset($_GET['link'])) {
              $safeLink1 = $_GET['link'];

            // Tampilkan nilai link dalam form dengan Bootstrap
            echo "<form id='copyForm' class='mb-3'>";
            echo "  <div class='input-group'>";
            echo "    <input type='text' id='linkValue' class='form-control' value='https://koding-bersama-ai.great-site.net/safelink-mini/index/redirect.php?link=$safeLink1' readonly>";
            echo "    <div class='input-group-append'>";
            echo "      <button type='button' class='btn btn-primary' onclick='copyLink()'>";
            echo "        <i class='fa fa-copy'></i>";
            echo "      </button>";
            echo "    </div>";
            echo "  </div>";
            echo "</form>";
            } else {
            // Jika parameter 'link' tidak diatur
              echo "";
            }
            ?>
          </div>
        </div><hr><!-- /.Menu Seacrh -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header text-center">
                <h3><strong>Why Choose SafeLink.AI Over Others?</strong></h3>
              </div>
              <div class="card-body">
                <p>Your Premier Choice for Link Management!</p>
                <ul>
                  <li>Personalized Advertising: Maximize your revenue by placing your own ads within SafeLink.AI. Empower members with the ability to showcase their advertisements and boost earnings.</li>
                  <li>Advanced Link Management: Experience a seamless link management system that is user-friendly and efficient. Control and customize your links effortlessly, ensuring a smooth and productive experience.</li>
                  <li>Enhanced Security: Your links, your security. SafeLink.AI prioritizes the safety of your links and provides robust security features to safeguard your online assets.</li>
                  <li>User-Friendly Interface: Navigate our platform effortlessly with an intuitive interface. SafeLink.AI is designed to enhance user experience, making link management simple and enjoyable.</li>
                </ul>
                <p>Join SafeLink.AI today and unlock a world of possibilities! Elevate your link management experience, boost your revenue, and take control of your online presence. The future of link management is here – SafeLink.AI, where innovation meets profitability!</p>
                <a href="pricing.php" class="btn btn-primary btn-sm">Pricing and Features</a>
              </div>
            </div>
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

<script>
  // Generate random math question and store the correct answer
  function generateCaptcha() {
    var num1 = Math.floor(Math.random() * 10) + 1;
    var num2 = Math.floor(Math.random() * 10) + 1;
    var answer = num1 + num2;

    document.getElementById('captchaQuestion').textContent = num1 + ' + ' + num2 + ' = ?';
    document.getElementById('captcha').value = '';
    document.getElementById('captcha').setAttribute('data-answer', answer);
  }

  // Generate initial captcha question when the page loads
  window.onload = generateCaptcha;
</script>

<script>
  // Validate the answer and URL when submitting the form
  function validateFormAndUrl() {
    var userAnswer = document.getElementById('captcha').value;
    var correctAnswer = document.getElementById('captcha').getAttribute('data-answer');

    // Validate the captcha answer
    if (userAnswer !== correctAnswer) {
      Swal.fire({
        icon: 'error',
        title: 'Incorrect answer',
        text: 'Please try again.'
      });
      return false;
    }

    // Validate the URL
    var urlInput = document.getElementById('realLink').value;
    var urlError = document.getElementById('urlError');

    // Regular expression for URL validation
    var urlPattern = /^(https?:\/\/)?([\w.]+)\.([a-z]{2,})(\/?\S*)?$/i;

    if (urlPattern.test(urlInput)) {
        // Valid URL
      urlError.textContent = '';
        // Perform further actions if needed
      console.log('Valid URL:', urlInput);
        return true; // Allow form submission
      } else {
        // Invalid URL
        Swal.fire({
          icon: 'error',
          title: 'Incorrect URL',
          text: 'Please try again.'
        });
        return false; // Prevent form submission
      }
    }
</script>

<script>
  function copyLink() {
    var linkValue = document.getElementById("linkValue");
    linkValue.select();
    document.execCommand("copy");
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'The link has been successfully copied.'
      });
  }
</script>

<!-- /Script -->
</body>
</html>