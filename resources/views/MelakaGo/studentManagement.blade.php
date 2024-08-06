<!DOCTYPE html>
<html lang="en">

@extends('MelakaGo.layout')

@section('content')
  <section>
  <div class="pagetitle">
      <h1>Student Management</h1>
    </div><!-- End Page Title -->

    <div id="alert1" class="alert alert-success alert-dismissible fade show" role="alert1" style="display: none;">
      Here is the student you were searching for.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="alert alert-danger alert-dismissible fade show" role="alert2" style="display: none;">
      Houston... we can't find the student you search.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div id="alert3" class="alert alert-success alert-dismissible fade show" role="alert3" style="display: none;">
      Student Successfully Deleted..
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
  </section>
@endsection

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
                          <button type="button" class="btn btn-primary" onclick="editStudent(${item.id})">Edit</button>
                          <button type="button" class="btn btn-danger" onclick="deleteStudent(${item.id})">Delete </button>
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
        //document.querySelector('.alert.alert-success.alert-dismissible.fade.show[role="alert1"]').style.display = 'block';
        document.getElementById('alert1').style.display ='block';
        document.querySelector('.alert.alert-danger.alert-dismissible.fade.show[role="alert2"]').style.display = 'none';
      }
      else{
        document.querySelector('.alert.alert-success.alert-dismissible.fade.show[role="alert1"]').style.display = 'none';
        document.querySelector('.alert.alert-danger.alert-dismissible.fade.show[role="alert2"]').style.display = 'block';
      }
    }


    function editStudent(student_id){
      // Get the tourismServiceId from the URL
      var student = `editStudent?id=${student_id}`;
      window.open(`${student}`,'_self');
    }

    function deleteStudent(student_id) {
      // Confirm with the user before proceeding
      if (confirm('Are you sure you want to delete this student?')) {
        // Retrieve the JSON string from sessionStorage
        var token = JSON.parse(sessionStorage.getItem('token'));
        console.log('User Token: ', token);

        // Create an object to hold the data you want to send
        const data = {
          studentId: student_id,
        };

        fetch('/user/deleteUser', {
          method: 'DELETE', // Use the DELETE method
          headers: {
            'Content-Type': 'application/json', // Set the content type to JSON
            'Authorization': `Bearer ${token}`,
          },
          body: JSON.stringify(data), // Convert the data object to a JSON string
        })
        .then(response => response.json())
        .then(data => {
          // Handle the response from the server
          console.log("Student successfully deleted", data);
          document.getElementById('alert3').style.display = 'block';
          setTimeout(() => {
            window.location = "/studentManagement";
          }, 2000);
        })
        .catch(error => {
          console.error('Error deleting student:', error);
        });
      } else {
        // User canceled the deletion
        console.log('Student deletion canceled');
      }
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
