<!DOCTYPE html>
<html lang="en">

@extends('MelakaGo.layout')

@section('content')
  <section>
  <div class="pagetitle">
      <h1>Student Registration</h1>
    </div><!-- End Page Title -->
    <!-- Custom Styled Validation -->
    <div id="successMessageEdit" class="alert alert-success" style="display: none;">
      Student is successfully registered!
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
                <div class="row">
                  <div class="col-md-6">
                    <label for="validationDefault02" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" required>
                    <div class="valid-feedback">
                      Looks good!
                    </div>
                    <div class="invalid-feedback">
                      Please enter Email!
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="validationDefault02" class="form-label">Password</label>
                    <input type="text" class="form-control" id="password" required>
                    <div class="valid-feedback">
                      Looks good!
                    </div>
                    <div class="invalid-feedback">
                      Please enter Password!
                    </div>
                  </div>
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
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary">Cancel</button>
              </div>
            </form><!-- End Custom Styled Validation -->
          </div>
        </div>
      </div>
    </section>
  </section>
@endsection

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <!-- Add only the necessary scripts here if required -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var form = document.getElementById("rewardForm");

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
        var password = document.getElementById('password').value;
        var address = document.getElementById('address').value;

        console.log('name: ', name);
        console.log('email: ', email);
        console.log('password: ', password);
        console.log('address: ', address);

        addStudent(name, email, password, address, token);
      });
    });

    function addStudent(name, email, password, address, token) {
      const data = {
        name: name,
        email: email,
        password: password,
        password_confirmation: password,
        address: address
      };

      fetch('/user/registerUser', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(data)
      })
      .then(response => {
        return response.json();
      })
      .then(data => {
        console.log('data: ', data); // Log the JSON data
        if (data.user) {
          document.getElementById('successMessageEdit').style.display = 'block';
          setTimeout(() => {
            window.location = "/addStudent";
          }, 2000);
        }
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
    }
  </script>
</body>

</html>
