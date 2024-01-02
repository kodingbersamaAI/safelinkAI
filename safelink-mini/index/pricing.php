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
          <div class="col-12 text-center">
            <h3><strong>Price and Features Comparison</strong></h3>
          </div>
          <br><br>
          <div class="col-md-4">
            <div class="card text-center">
              <div class="card-header">
                <h4><strong>Guest (Free)</strong></h4>
              </div>
              <!-- Guest (Free) -->
              <div class="card-body">
                Basic access to the platform<br>
                No link management<br>
                Limit 5 safelink/day<br>
                Non-private ads
              </div>
              <div class="card-footer">
                <a href="index.php" class="btn btn-primary btn-sm">Try It Now!</a>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card text-center">
              <div class="card-header">
                <h4><strong>Basic (Free)</strong></h4>
              </div>
              <!-- Guest (Free) -->
              <div class="card-body">
                Advanced link management<br>
                Create safelink without chaptcha<br>
                Limit 50 safelink/day<br>
                Personalized advertising for 1 slot<br>
              </div>
              <div class="card-footer">
                <a href="register.php" class="btn btn-primary btn-sm">Register Now!</a>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card text-center">
              <div class="card-header">
                <h4><strong>Premium (Paid $5/month)</strong></h4>
              </div>
              <!-- Guest (Free) -->
              <div class="card-body">
                All Basic features<br>
                Create many safelink at once click<br>
                Unlimited safelink/day<br>
                Personalized advertising for 2 slot<br>
              </div>
              <div class="card-footer">
                <a href="register.php" class="btn btn-primary btn-sm">Register Now!</a>
              </div>
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

<!-- /Script -->
</body>
</html>