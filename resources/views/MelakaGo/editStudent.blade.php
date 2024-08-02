<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Forms / Layouts - NiceAdmin Bootstrap Template</title>
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
      <h1>Edit Student</h1>
    </div><!-- End Page Title -->
    <!-- Custom Styled Validation -->
    <div id="successMessageEdit" class="alert alert-success" style="display: none;">
      Student is successfully edited!
    </div>
    <section class="section">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Student Details</h5>

            <form id="rewardForm" class="row g-3 needs-validation" novalidate>
              <div class="col-12">
                <label for="validationCustom01" class="form-label">Student Name</label>
                <input type="text" class="form-control" id="name" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Please enter Student Name!
                </div>
              </div>
              <div class="col-12">
                <label for="validationDefault02" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Please enter Email!
                </div>
              </div>
              <div class="col-12">
                <label for="validationCustom02" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Please enter Address!
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary">Cancel</button>
              </div>
            </form><!-- End Custom Styled Validation -->
          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      const student_id = urlParams.get('id');

      var token = JSON.parse(sessionStorage.getItem('token'));
      console.log('User Token: ', token);

      fetchData(student_id, token); // Call the fetchData function correctly

      const form = document.getElementById('rewardForm');

      form.addEventListener("submit", function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
          form.classList.add("was-validated");
          return;
        }

        event.preventDefault(); // Prevent the default form submission behavior

        // Retrieve the JSON string from sessionStorage
        var token = JSON.parse(sessionStorage.getItem('token'));
        console.log('User Token: ', token);

        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var address = document.getElementById('address').value;

        updateStudent(name, email, address, token, student_id);

      });

    });

    function fetchData(studentId, token) {
      const data = {
        studentId: studentId
      };

      fetch('user/findUser', { // Ensure the correct URL
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(data => {
        updateTable(data.student);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
    }

    function updateTable(data) {
      document.getElementById('name').value = data.name;
      document.getElementById('email').value = data.email;
      document.getElementById('address').value = data.address;
    }
  </script>

  <script>
    function updateStudent(name, email, address, token, student_id){
      
      const data ={
        name : name,
        email : email,
        address : address,
        studentId : student_id
      };

      fetch('user/updateUser', {
        method: 'PUT', // Use the POST method
        headers: {
          'Content-Type': 'application/json', // Set the content type to JSON
          'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(data) // Convert the data object to a JSON string
      })
      .then(response => response.json())
      .then(data => {
        // Handle the response from the server
        console.log("student Successfully being saved ", data);

        setTimeout(() => {
          window.location = "/studentManagement";
        }, 2000);
        
              
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
