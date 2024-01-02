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
          <div class="col-md-6 offset-md-3">
            <h1>Terms of Service</h1>
            <p>Last updated: 25 December 2023</p>

            <p>Please read these Terms of Service ("Terms", "Terms of Service") carefully before using the SafeLink web application (the "Service") operated by <a href="https://koding-bersama-ai.great-site.net/" target="_blank">Koding bersama AI</a> ("us", "we", or "our").</p>

            <p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users, and others who access or use the Service.</p>

            <p><strong>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service.</strong></p>

            <h2>Accounts</h2>

            <p>When you create an account with us, you must provide us information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.</p>

            <p>You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password, whether your password is with our Service or a third-party service.</p>

            <p>You agree not to disclose your password to any third party. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p>

            <h2>Links To Other Web Sites</h2>

            <p>Our Service may contain links to third-party web sites or services that are not owned or controlled by <a href="https://koding-bersama-ai.great-site.net/" target="_blank">Koding bersama AI</a>.</p>

            <p><a href="https://koding-bersama-ai.great-site.net/" target="_blank">Koding bersama AI</a> has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third-party web sites or services. You further acknowledge and agree that <a href="https://koding-bersama-ai.great-site.net/" target="_blank">Koding bersama AI</a> shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with the use of or reliance on any such content, goods, or services available on or through any such web sites or services.</p>

            <p>We strongly advise you to read the terms and conditions and privacy policies of any third-party web sites or services that you visit.</p>

            <h2>Termination</h2>

            <p>We may terminate or suspend access to our Service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>

            <p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity, and limitations of liability.</p>

            <h2>Governing Law</h2>

            <p>These Terms shall be governed and construed in accordance with the laws of [Your Country], without regard to its conflict of law provisions.</p>

            <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service and supersede and replace any prior agreements we might have had between us regarding the Service.</p>

            <h2>Changes</h2>

            <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material, we will try to provide at least 30 days' notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>

            <p>By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.</p>

            <h2>Contact Us</h2>

            <p>If you have any questions about these Terms, please contact us.</p>

            <p>
              <a href="https://koding-bersama-ai.great-site.net/" target="_blank">Koding bersama AI</a><br>
              <a href="mailto:tekuro.official@gmail.com" target="_blank">Email Us</a><br>
            </p>
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