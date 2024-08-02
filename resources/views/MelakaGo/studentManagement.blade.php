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
      <h1>Student Management</h1>
    </div><!-- End Page Title -->

    <div class="alert alert-success alert-dismissible fade show" role="alert1" style="display: none;">
      Here is the student you were searching for.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="alert alert-danger alert-dismissible fade show" role="alert2" style="display: none;">
      Houston... we can't find the student you search.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Search Student</h5>
    
            <form class="row g-3 align-items-center">
              <div class="col-md-6">
                  <div class="input-group">
                      <input type="text" class="form-control me-2" id="services" placeholder="Enter Student Name">
                      <button type="button" class="btn btn-primary" onclick="searchServices()">
                          Search
                      </button>
                  </div>
              </div>
          </form><!-- Horizontal Form -->
    
        </div>
    </div>

 

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                List of Student
              </h5>

              <!-- Default Table -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>

                    </td>
                  </tr>
                </tbody>
              </table>
              <!-- End Default Table Example -->
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>SMA Jawahir Al-Ulum</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->

    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>


  <script>

    // Wait for the DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function () {

      // Retrieve the JSON string from sessionStorage DONE
      var token = JSON.parse(sessionStorage.getItem('token'));
      console.log('User Token: ', token);

      fetchData(token);

    });

  
    // Function to fetch data from the server
    function fetchData(token) {
      fetch('/user/getAllStudents',
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

        updateTable(data.students);

      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
    
    }

    
    // Function to update the table with data
    function updateTable(data) {
      const tbody = document.querySelector('table tbody');

      // Clear existing rows
      tbody.innerHTML = '';

      
      // Iterate over the data and create rows
      data.forEach((item, index) => 
      {
        
        const row = `<tr>
                      <td>${index + 1}</td>
                      <td>${item.name}</td>
                      <td>${item.email}</td>
                      <td>${item.address}</td>
                      <td>
                        <div class="button-column">
                          <button type="button" class="btn btn-primary" onclick="editClassroom(${item.id})">Edit</button>
                          <button type="button" class="btn btn-danger" onclick="deleteClassroom(${item.id})">Delete </button>
                        </div>
                      </td>
                    </tr>`;

        // Append the row to the tbody
        tbody.innerHTML += row;
      });
    }


    function searchServices() {
    // Get the search term
    var searchTerm = document.getElementById('services').value.toLowerCase();
    console.log('KEYWORD:',searchTerm);

    // Get all rows in the table
    var rows = document.querySelectorAll('table tbody tr');

    var studentFound = false;

    // Loop through each row and hide/show based on the search term
    rows.forEach(function (row) {
        // Update the selector to target the correct cell (company name)
        var student = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

        // Convert both the company name and the search term to lowercase for comparison
        if (student.includes(searchTerm)) {
            row.style.display = 'table-row';
            studentFound = true;
        } else {
            row.style.display = 'none';
        }
    });

    if(studentFound){
      document.querySelector('.alert.alert-success.alert-dismissible.fade.show[role="alert1"]').style.display = 'block';
      document.querySelector('.alert.alert-danger.alert-dismissible.fade.show[role="alert2"]').style.display = 'none';
    }
    else{
      document.querySelector('.alert.alert-success.alert-dismissible.fade.show[role="alert1"]').style.display = 'none';
      document.querySelector('.alert.alert-danger.alert-dismissible.fade.show[role="alert2"]').style.display = 'block';
    }
  }


  function editClassroom(student_id){
    // Get the tourismServiceId from the URL
    var student = `editStudent?id=${student_id}`;
    window.open(`${student}`,'_self');
  }

  function deleteClassroom(classroom_id)
  {
    var is_Delete=1;
    //Create an object to hold the data you want to send
    const data = {
      id : classroom_id,
      is_Delete:is_Delete,
    };

    fetch('/classroom/delete/'+classroom_id, {
            method: 'PUT', // Use the POST method
            headers: {
            'Content-Type': 'application/json' // Set the content type to JSON
            },
            body: JSON.stringify(data) // Convert the data object to a JSON string
    })
      .then(response => response.json())
      .then(data => {
            // Handle the response from the server
            console.log("Student Successfully deleted ", data);
            window.location.href = "/classroomManagement";
            
        })
      .catch(error => {
            console.error('Error fetching data:', error);
      });
        
    }
    

  </script>

  <script>

function signOut()
{
  const data={};

    fetch('/user/logout', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
      console.log('Response:', data);
      
      // Redirect to the login page
      window.location.replace('/login');
        
    })
    .catch(error => {
        console.error('Error during fetch:', error);
    });

}
  </script>

</body>

</html>
