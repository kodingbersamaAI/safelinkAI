<?php 
include "../server/sesi.php"; 
include "../server/koneksi.php";

if (isset($_SESSION['roleUser'])) {
    $dashboardLink = ''; // Inisialisasi variabel untuk link dashboard
    
    switch ($_SESSION['roleUser']) {
      case 'admin':
      $dashboardLink = '../admin';
        break;
      case 'basic':
      $dashboardLink = '../basic';
        break;
      case 'premium':
      $dashboardLink = '../premium';
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
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <div class="card-body">
              <p class="login-box-msg">Register a new membership</p>
              <form action="proses/register.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                <input type="hidden" name="idUser">
                <input type="hidden" name="roleUser" value="basic">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="nameUser" placeholder="Full name" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="email" class="form-control" name="emailUser" placeholder="Email" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" name="passwordUser" placeholder="Password" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" name="retypePassword" placeholder="Retype password" id="retypePassword" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>

                <!-- JavaScript untuk memeriksa kesamaan password -->
                <script>
                  document.addEventListener("DOMContentLoaded", function () {
                    var passwordInput = document.getElementById("passwordUser");
                    var retypePasswordInput = document.getElementById("retypePassword");
                    var errorText = document.getElementById("passwordMatchError");

                    function checkPasswordMatch() {
                      var password = passwordInput.value;
                      var retypePassword = retypePasswordInput.value;

                      if (password !== retypePassword) {
                        errorText.style.display = "block";
                      } else {
                        errorText.style.display = "none";
                      }
                    }

                    // Panggil fungsi setiap kali input berubah
                    retypePasswordInput.addEventListener("input", checkPasswordMatch);
                  });
                </script>
                <div class="row">
                  <div class="col-8">
                    <div class="icheck-primary">
                      <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                      <label for="agreeTerms">
                       I agree to the <a href="tos.php">terms</a>
                      </label>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                  </div>
                  <!-- /.col -->
                </div>
              </form>
            </div>
          </div>
        <!-- /.form-box -->
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

  // Validate the answer when submitting the form
  function validateForm() {
    var userAnswer = document.getElementById('captcha').value;
    var correctAnswer = document.getElementById('captcha').getAttribute('data-answer');

    if (userAnswer === correctAnswer) {
      // Proceed with form submission if the answer is correct
      return true;
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Incorrect answer',
        text: 'Please try again.'
      });
      return false;
    }
  }

  // Generate initial captcha question when the page loads
  window.onload = generateCaptcha;
</script>

<script>
    function validateUrl() {
        var urlInput = document.getElementById('realLink').value;
        var urlError = document.getElementById('urlError');

        // Regular expression for URL validation
        var urlPattern = /^(https?:\/\/)?([\w.]+)\.([a-z]{2,})(\/?\S*)?$/i;

        if (urlPattern.test(urlInput)) {
            // Valid URL
            urlError.textContent = '';
            // Perform further actions if needed
            console.log('Valid URL:', urlInput);
        } else {
            // Invalid URL
            urlError.textContent = 'Please enter a valid URL (with http/https)';
        }
    }
</script>

<script>
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })
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