<?php include 'header.php' ?>
<!DOCTYPE html>
<html lang="en">
  <head>


    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Registration Form in HTML CSS</title>
    
    
<style>

/* Import Google font - Poppins */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");


/* Global styles */
body {
  background-color: darkgrey;
  font-family: 'Poppins', sans-serif;
  margin: 0;
  padding: 0;
}

/* Container styles */
.container {
  max-width: 650px;
  width: 100%;
  background: #fff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 0 15px grey;
  margin: 30px auto; /* Centering the container */
}

.container header {
  font-size: 1.5rem;
  color: #333;
  font-weight: 500;
  text-align: center;
  margin-bottom: 20px;
}

/* Form styles */
.form {
  margin-top: 30px;
}

.input-box {
  margin-top: 25px;
}

.input-box label {
  color: #333;
}

/* Input and select styles */
.input-box input[type="text"],
.input-box input[type="number"],
.input-box input[type="date"],
.select-box select {
  width: 100%;
  height: 50px;
  padding: 10px;
  font-size: 1rem;
  color: #707070;
  margin-top: 8px;
  border: 1px solid #ddd;
  border-radius: 6px;
  outline: none;
}

.input-box input:focus {
  box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
}

/* Columns and layout */
.form .column {
  display: flex;
  gap: 15px;
}

.mode-box {
  margin-top: 20px;
}

.mode-box h3 {
  color: #333;
  font-size: 1rem;
  font-weight: 400;
  margin-bottom: 8px;
}

.mode-option {
  display: flex;
  align-items: center;
  gap: 50px;
  flex-wrap: wrap;
}

.mode label {
  color: #707070;
}

/* Address styles */
.input-box.address input[type="text"],
.input-box.address select {
  margin-top: 15px;
}

.input-box.address .column {
  display: flex;
  gap: 15px;
}

/* Button styles */
.form button {
  height: 55px;
  width: 100%;
  color: #fff;
  font-size: 1rem;
  font-weight: 400;
  margin-top: 30px;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s ease;
  background: rgb(130, 106, 251);
  border-radius: 25px;
}

.form button:hover {
  background: rgb(88, 56, 250);
}

#postal{
    padding:20px;
    margin-top:15px;
}

#country{
    width:290px;
}
#city{
    width:290px;
}


/* Responsive styles */
@media screen and (max-width: 500px) {
  .form .column {
    flex-wrap: wrap;
  }

  .mode-option {
    gap: 15px;
  }
}

/* Header style */
.headerf {
  font-size: 1.5rem;
  color: #333;
  font-weight: bold;
  text-align: center;
  margin-bottom: 50px;
}


</style>


    
  </head>
  <body>

  <?php
     include("connection.php");
    ?>
<?php
if(isset($_POST['submit']))
 {

	// collect value of input field
	$course_id = $_POST['course_id'];
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $mob = $_POST['mob'];
  $demo_date = $_POST['demo_date'];
  $lect_mode = $_POST['lect_mode'];
  $add_line = $_POST['add_line'];
  $add_line2 = $_POST['add_line2'];
  $country = $_POST['country'];
  $city = $_POST['city'];
  $region = $_POST['region'];
  $postalcode = $_POST['postalcode'];
  $sql = "INSERT INTO enquiry (course_id, full_name, email, mob, demo_date, lect_mode, add_line, add_line2,country,city,region,postalcode) VALUES ('$course_id', '$full_name', '$email', '$mob', '$demo_date', '$lect_mode', '$add_line', '$add_line2', '$country', '$city', '$region', '$postalcode')";
  
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo '<script>alert("Enquiry sent successfully ")</script>'
    ?>

    <!--<meta http-equiv = "refresh" content = "0 ; url = http://localhost/test/display.php" /> -->
<?php
    
} else {
    echo "Error: " . mysqli_error($conn);
}

	if (empty($course_id))
  {
		echo "data is empty";
	} else {
	
	}
 
 }


// Closing the connection.
$conn->close();
?>


    <section class="container">
    
      <form  class="form" method="post" value="submit">

      <div class="headerf">Enqiry form</div> 
       <!-- <div class="input-box">
          <label>Course name</label>
          <input type="text" placeholder="Enter Course name" required name = 'course_name' />
        </div> -->

        <div class="select-box">
             <select name="course_id">
               <?php
                  include('connection.php');
                  $course_name = mysqli_query($conn, "SELECT * FROM courses");
                  while($result = mysqli_fetch_array($course_name)) {
               ?>
               <option hidden>course</option>
               <option value="<?php echo $result['course_id']; ?>"><?php echo $result['course_name']; ?></option>
               <?php } ?>
               
             </select>
            </div>







        <div class="input-box">
          <label>Full Name</label>
          <input type="text" placeholder="Enter full name" required name = "full_name" />
        </div>

        



        <div class="input-box">
          <label>Email Address</label>
          <input type="text" placeholder="Enter email address" required name = "email" />
        </div>

        <div class="column">
          <div class="input-box">
            <label>Phone Number</label>
            <input type="number" placeholder="Enter phone number" required name = "mob" />
          </div>
          <div class="input-box">
            <label>Date for demo lecture</label>
            <input type="date" placeholder="Date for demo lecture" required name = "demo_date" />
          </div>
        </div>
        <div class="mode-box">
          <h3>Mode for Lect</h3>


          <div class="mode-option">
            <div class="mode">
              <input type="radio" id="check-online" name="lect_mode" checked value="online" />
              <label for="check-online">online</label>
            </div>
            <div class="mode">
              <input type="radio" id="check-offline" name="lect_mode" value="offline" />
              <label for="check-offline">offline</label>

           </div>
      
            </div>
          </div>
        </div>



        <div class="input-box address">
          <label>Address</label>
          <input type="text" placeholder="Enter street address" required name = "add_line" />
          <input type="text" placeholder="Enter street address line 2" required  name = "add_line2"/>
          <div class="column">
          
          <div class="select-box">
          <br>
          <label>Country</label>
            <select name = "country" id = 'country' required>
              
              <option value = "America">America</option>
              <option value = "Japan">Japan</option>
              <option value = "India">India</option>
              <option value = "Nepal">Nepal</option>
            </select>
          </div>
          <div>
          <br>
              <label>City</label>
              <input type="text" id = 'city' placeholder="Enter your city" required name = 'city' />
              </div>
        </div>
          <div class="column">
            <input type="text" placeholder="Enter your region" required name = 'region' />
            <input type="number" placeholder="Enter postal code" required name = 'postalcode' />
          </div>
        </div>
        <button class="form" type="submit" name="submit">SUBMIT</button>

      </form>
    </section>
    <!-- <footer> -->
        <!-- <?php include 'footer.php' ?> -->
    <!-- </footer> -->
  </body>
</html>
<?php include 'footer.php'; ?>
