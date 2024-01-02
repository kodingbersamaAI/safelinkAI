  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/safelink-mini" class="nav-link"><h4>Safelink<strong>AI</strong></h4></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <?php
        if (isset($_SESSION['nameUser'])) {
            // Jika sesi aktif, tampilkan dropdown pengguna
        ?>
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-user"></i> <?php echo $_SESSION['nameUser']; ?>
            </a>
            <div class="dropdown-menu dropdown-menu dropdown-menu-right">
            <span class="dropdown-item dropdown-header">You're login as <?php echo $_SESSION['roleUser']; ?> member</span>
              <div class="dropdown-divider"></div>
              <a href="<?php echo $dashboardLink; ?>" class="dropdown-item">
                <i class="fas fa-home mr-2"></i> Dashboard
              </a>
              <div class="dropdown-divider"></div>
              <a href="../server/logout.php" class="dropdown-item">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </a>
            </div>
          </li>
        <?php
        } else {
            // Jika tidak ada sesi aktif, tampilkan tautan untuk login modal
        ?>
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-user"></i> Login
            </a>
            <div class="dropdown-menu dropdown-menu-right">
            <span class="dropdown-item dropdown-header">For Easy Access Feauture, Please Login to Member Area</span>
            <div class="dropdown-divider"></div>
              <div style="padding-left: 10px; padding-right: 10px;">
                <form action="../server/login.php" method="post">
                  <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                  <div class="form-group">
                    <input type="email" id="emailUser" name="emailUser" class="form-control" placeholder="Email" required>
                  </div>
                  <div class="form-group">
                    <input type="password" id="passwordUser" name="passwordUser" class="form-control" placeholder="Password" required>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm">Login</button>
                </form>
                <small>Not yet have an account?<a href="register.php"> Register</a></small>
              </div>
            </div>
          </li>
        <?php
        }
        ?>
    </ul>
  </nav>
  <!-- /.navbar -->