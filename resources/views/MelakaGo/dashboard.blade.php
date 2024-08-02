<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Melaka Go Web Application</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Nov 17 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

 @include('MelakaGo.sideBar')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard System Admin</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-16">
          <div class="row">

            

           
            
            <!-- INTERNATIONAL USER Card -->
            <div class="col-xxl-4 col-xl-12">

                <div class="card info-card internationalUser-card">
  
                  <div class="card-body">
                    <h5 class="card-title">STUDENT <span>| TOTAL STUDENT</span></h5>
  
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-vcard"></i>
                      </div>
                      <div class="ps-3">
                        <h6 id="totalStudent">0</h6>
                      </div>
                    </div>
  
                  </div>
                </div>
  
              </div><!-- End INTERNATIONAL USER Card -->

          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>MelakaGo</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  

  <script>

      // Initialize variables outside the loop
    var internationalUser=0, activeUser=0,localUser=0,totalUser=0;
 
    document.addEventListener("DOMContentLoaded", function () {
      console.log('DOMContentLoaded event fired.');

      // Retrieve the JSON string from sessionStorage DONE
      var storedAppUserProfile = JSON.parse(sessionStorage.getItem('studentProfile'));
      console.log('User Profile: ', storedAppUserProfile);

      // Retrieve the JSON string from sessionStorage DONE
      var token = JSON.parse(sessionStorage.getItem('token'));
      console.log('User Token: ', token);


      // Update user nickname in the profile dropdown
      document.querySelector('.dropdown-menu .dropdown-header h6').textContent = storedAppUserProfile.name ;
      document.getElementById('userName').textContent = storedAppUserProfile.name;

      totalStudent(token);
    
      
    });
  </script>

  <script>
    function totalStudent(token){
      fetch('/user/totalStudent',
      {
        method: 'GET', // Use the POST method
        headers: 
        {
          'Content-Type': 'application/json', //set the content type to JSON
          'Authorization': `Bearer ${token}` //bind the bearer token
        },
      })
      .then(response => response.json())
      .then(data => 
      {

        document.getElementById('totalStudent').textContent = data.totalStudents;

      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
      
    }
  </script>

  <script>

    function signOut()
    {

      history.pushState(null, null, location.href);
      window.onpopstate = function () {
        history.go(1);
      };

          // Clear the session storage
      sessionStorage.clear();

      // Redirect to the login page
      window.location.replace('login.html');
    }

  </script>


</body>

</html>
