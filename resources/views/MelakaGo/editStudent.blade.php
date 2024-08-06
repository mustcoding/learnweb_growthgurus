<!DOCTYPE html>
<html lang="en">

  @extends('MelakaGo.layout')

  @section('content')
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
                  <button type="button" class="btn btn-secondary" onClick="back()">Cancel</button>
                </div>
              </form><!-- End Custom Styled Validation -->
            </div>
          </div>
        </div>
      </section>
  @endsection


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

    function back(){
      window.location.href = "/studentManagement";
    }

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
