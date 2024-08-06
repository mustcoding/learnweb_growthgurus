<!DOCTYPE html>
<html lang="en">

  @extends('MelakaGo.layout')
    
  @section('content')
  <section>
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

      </section>
  @endsection




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

    


</html>
