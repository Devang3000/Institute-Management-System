<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

    .services-container {
     
      margin: 2em auto;
      width: 80%;
      justify-content: space-between;
    }

    .service-box {
      flex: 0 1 calc(50% - 20px);
      margin: 10px;
      padding: 20px;
      background-color: #f4f4f4;
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .service-box h2 {
      margin-bottom: 10px;
      font-size: 1.5em;
      color: #333;
    }

    .service-box p {
      font-size: 1em;
      color: #666;
    }

    .service-box button {
      background-color: #5bc0de;
      border: none;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin-top: 10px;
      cursor: pointer;
      border-radius: 5px;
    }

    .collapse {
      display: none;
    }

    .collapse.show {
      display: block;
      margin-top: 10px;
    }

    @media screen and (max-width: 900px) {
      .service-box {
        flex: 0 1 calc(100% - 20px);
      }
    }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const buttons = document.querySelectorAll('.service-box button');
      buttons.forEach(button => {
        button.addEventListener('click', function () {
          const targetId = this.getAttribute('data-target');
          const target = document.getElementById(targetId);
          target.classList.toggle('show');
        });
      });
    });
  </script>
</head>
<body>
  <div class="services-container">
    <div class="service-box">
      <h2>Web Development</h2>
      <p>We offer modern web development services to build responsive and dynamic websites.</p>
      <button type="button" data-target="know">Know more</button>
      <div id="know" class="collapse">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>
    <div class="service-box">
      <h2>Mobile App Development</h2>
      <p>Our team creates intuitive and robust mobile applications for both Android and iOS platforms.</p>
      <button type="button" data-target="2">Know more</button>
      <div id="2" class="collapse">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>
    <div class="service-box">
      <h2>UI/UX Design</h2>
      <p>Enhance your product's usability and aesthetics with our professional UI/UX design services.</p>
      <button type="button" data-target="3">Know more</button>
      <div id="3" class="collapse">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>
    <div class="service-box">
      <h2>Digital Marketing</h2>
      <p>Boost your online presence with our comprehensive digital marketing strategies.</p>
      <button type="button" data-target="4">Know more</button>
      <div id="4" class="collapse">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>
    <div class="service-box">
      <h2>SEO Services</h2>
      <p>Improve your website's ranking on search engines with our expert SEO services.</p>
      <button type="button" data-target="5">Know more</button>
      <div id="5" class="collapse">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>
    <div class="service-box">
      <h2>Content Creation</h2>
      <p>Engage your audience with high-quality content crafted by our skilled writers.</p>
      <button type="button" data-target="6">Know more</button>
      <div id="6" class="collapse">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>
    <div class="service-box">
      <h2>Cloud Solutions</h2>
      <p>Optimize your business operations with our scalable and secure cloud solutions.</p>
      <button type="button" data-target="7">Know more</button>
      <div id="7" class="collapse">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>
    <div class="service-box">
      <h2>IT Consulting</h2>
      <p>Get expert advice and insights to drive your business technology forward.</p>
      <button type="button" data-target="8">Know more</button>
      <div id="8" class="collapse">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>
  </div>

</body>
</html>
<?php include 'footer.php'; ?>
