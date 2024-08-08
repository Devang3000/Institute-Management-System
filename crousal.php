<!DOCTYPE html>
<html lang="en">
<head>
  <title>Custom Carousel Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    .carousel {
      position: relative;
      width: 100%;
      max-width: 1519px;
      margin: auto;
      overflow: hidden;
      max-height:500px
      
    }
    .carousel-inner {
      display: flex;
      transition: transform 0.5s ease;
    }
    .carousel-item {
      min-width: 100%;
      box-sizing: border-box;
    }
    .carousel-item img {
      width: 100%;
    }
    .carousel-control {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background-color: rgba(0, 0, 0, 0.5);
      color: white;
      border: none;
      cursor: pointer;
      padding: 10px;
    }
    .carousel-control.left {
      left: 10px;
    }
    .carousel-control.right {
      right: 10px;
    }
    .carousel-indicators {
      position: absolute;
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
    }
    .carousel-indicators button {
      background-color: #ccc;
      border: none;
      width: 10px;
      height: 10px;
      margin: 5px;
      border-radius: 50%;
      cursor: pointer;
    }
    .carousel-indicators button.active {
      background-color: #333;
    }
  </style>
</head>
<body>

<div class="carousel">
  <div class="carousel-inner">
    <div class="carousel-item">
      <img src="images/institue3.jpeg" alt="Los Angeles">
    </div>
    <div class="carousel-item">
      <img src="images/training.jpg" alt="Chicago">
    </div>
    <div class="carousel-item">
      <img src="images/institue2.jpeg" alt="New York">
    </div>
  </div>
  <button class="carousel-control left" onclick="prevSlide()">❮</button>
  <button class="carousel-control right" onclick="nextSlide()">❯</button>
  <div class="carousel-indicators">
    <button class="active" onclick="currentSlide(0)"></button>
    <button onclick="currentSlide(1)"></button>
    <button onclick="currentSlide(2)"></button>
  </div>
</div>

<script>
  let currentIndex = 0;
  const items = document.querySelectorAll('.carousel-item');
  const indicators = document.querySelectorAll('.carousel-indicators button');

  function showSlide(index) {
    if (index >= items.length) {
      currentIndex = 0;
    } else if (index < 0) {
      currentIndex = items.length - 1;
    } else {
      currentIndex = index;
    }
    const newTransform = -currentIndex * 100 + '%';
    document.querySelector('.carousel-inner').style.transform = `translateX(${newTransform})`;
    indicators.forEach((indicator, i) => {
      indicator.classList.toggle('active', i === currentIndex);
    });
  }

  function nextSlide() {
    showSlide(currentIndex + 1);
  }

  function prevSlide() {
    showSlide(currentIndex - 1);
  }

  function currentSlide(index) {
    showSlide(index);
  }

  function autoSlide() {
    nextSlide();
    setTimeout(autoSlide, 3000); // Change slide every 3 seconds
  }

  // Start auto slide
  setTimeout(autoSlide, 3000);
</script>

</body>
</html>
