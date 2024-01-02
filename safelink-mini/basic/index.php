<?php 
include "../server/sesi.php"; 
include "../server/koneksi.php";
include "akses.php"

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
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-link"></i></span>
              <div class="info-box-content">
              	<?php
    						// Set zona waktu ke "Asia/Jakarta"
              	date_default_timezone_set('Asia/Jakarta');

    						// Buat query SQL untuk menghitung jumlah link
              	$today = date("Y-m-d");
              	$query = "SELECT COUNT(*) AS totalLink FROM link WHERE userLink = ? AND DATE(dateLink) = ?";
              	$stmt = $conn->prepare($query);

              	if ($stmt) {
              		$stmt->bind_param("ss", $_SESSION['nameUser'], $today);
              		$stmt->execute();
              		$result = $stmt->get_result();

              		if ($result) {
              			$row = $result->fetch_assoc();
              			$totalLink = $row['totalLink'];
              		} else {
            				$totalLink = 0; // Atau sesuaikan dengan nilai default yang sesuai
          					}

				        } else {
        						// Handle jika prepared statement tidak berhasil dibuat
        						$totalLink = 0; // Atau sesuaikan dengan nilai default yang sesuai
      						}
					      ?>
					      <h4><span class="info-box-text"><?php echo $totalLink; ?> / 50</span></h4>
					      <span class="info-box-number">Today Created Link</span>
					    </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-link"></i></span>
              <div class="info-box-content">
                <?php
                // Buat query SQL untuk menghitung jumlah siswa
                $query = "SELECT COUNT(*) AS totalLink FROM link WHERE userLink = '{$_SESSION['nameUser']}'";
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
                <span class="info-box-number">Total Created Link</span>
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
          <div class="col-md-8 offset-md-2">
            <form action="proses/safelink.php" method="POST" onsubmit="return validateUrl()">
              <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
              <input type="hidden" name="userLink" value="<?php echo isset($_SESSION['nameUser']) ? $_SESSION['nameUser'] : ''; ?>">
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
              <div class="card-header">
                My Links
              </div>
              <div class="card-body">
                <table id="linkTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Actual Link</th>
                      <th>Safe Link</th>
                      <th>Date Created</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
	                  // Query SQL untuk mengambil data link
	                  $queryLink = "SELECT * FROM link WHERE userLink = '{$_SESSION['nameUser']}'";
	                  $resultLink = $conn->query($queryLink);

	                  if ($resultLink->num_rows > 0) {
	                    while ($row = $resultLink->fetch_assoc()) {
	                      echo "<tr>";
	                      echo "<td>" . $row["realLink"] . "</td>";
	                      echo "<td style='text-align: center;'><button class='btn btn-primary btn-sm' onclick='copyToClipboard(\"https://koding-bersama-ai.great-site.net/safelink-mini/index/redirect.php?link=" . $row["safeLink1"] . "\")'><li class='fas fa-copy'></li></button></td>";
								        $dateLink = date("j F Y", strtotime($row["dateLink"]));
								        echo "<td>" . $dateLink . "</td>";
	                      echo "<td style='text-align: center;'><button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalHapus" . $row["id"] . "' alt='Delete link'><i class='fas fa-trash'></i></button></td>";
	                      echo "</tr>";
	                      // Modal untuk Hapus Data Buku
	                      echo "
	                      <div class='modal fade' tabindex='-1' role='dialog' aria-hidden='true' id='modalHapus" . $row["id"] . "'>
	                        <div class='modal-dialog modal-dialog-centered'>
	                        	<div class='modal-content'>
	                            <div class='modal-header'>
	                          		<div class='modal-title'>Delete?</div>
	                            </div>
	                            <div class='modal-body'>
	                            	<form action='proses/delete.php' method='POST'>
	                              	<input type='hidden' name='csrf_token' readonly value= '" . generateCSRFToken() . "'>
	                                <input type='hidden' class='form-control' id='id' name='id' value='" . $row["id"] . "'>
	                                <p>You will delete the safelink for this link: <b>" . $row["realLink"] . "</b></p>
	                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
	                                <button type='button' class='btn btn-secondary btn-sm' data-dismiss='modal'>Cancel</button>
	                              </form>
	                            </div>
	                          </div>
	                        </div>
	                      </div>
	                      ";
	                    }
	                  } else {
	                      echo "<tr><td colspan='4'>Not yet link have created.</td></tr>";
	                  }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                My Account
              </div>
              <div class="card-body">
                This section contain your account information. Don't share to anyone.<br><br>
                <?php
                // Ambil nilai emailUser dari sesi
                $emailUser = $_SESSION['emailUser'];

                // Query untuk mengambil informasi user berdasarkan emailUser
                $query = "SELECT * FROM user WHERE emailUser = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $emailUser);
                $stmt->execute();
                $result = $stmt->get_result();

                // Periksa apakah data ditemukan
                if ($result->num_rows > 0) {
                  $userData = $result->fetch_assoc();
                  // Tampilkan informasi dalam form control readonly
                  ?>
                  <div class="form-group row">
                    <label for="recovery" class="col-sm-2 col-form-label">Recovery Code:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="recovery" value="<?php echo $userData['idUser']; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nameUser" class="col-sm-2 col-form-label">Full Name:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nameUser" value="<?php echo $userData['nameUser']; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email:</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="emailUser" value="<?php echo $userData['emailUser']; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="role" class="col-sm-2 col-form-label">Membership:</label>
                    <div class="col-sm-2">
                      <input type="text" class="form-control" id="roleUser" value="<?php echo $userData['roleUser']; ?>" readonly>
                    </div><br>
                    <div class="col-sm-2">
                      <a href="../index/upgrade.php" class="btn btn-blok btn-primary">Upgrade to Premium</a>
                    </div>
                  </div>
                  <!-- Tambahkan form control lainnya sesuai kebutuhan -->

                  <?php
                } else {
                  // Handle jika data tidak ditemukan
                  echo "User data not found.";
                }
                ?>
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
  function validateUrl() {
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

<script>
	function copyToClipboard(text) {
        // Buat elemen textarea sementara untuk menyalin teks
		var tempTextarea = document.createElement("textarea");
		document.body.appendChild(tempTextarea);
		tempTextarea.value = text;
		tempTextarea.select();
		document.execCommand("copy");
		document.body.removeChild(tempTextarea);
		Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'The link has been successfully copied.'
      });
	}
</script>

<script>
  $(function () {
    $("#linkTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
    })
  });
</script>

<!-- /Script -->
</body>
</html>