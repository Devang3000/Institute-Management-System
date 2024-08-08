<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>coursesslider</title>
    <link rel="stylesheet" href="style.css">
    <style>
      .body {
          background: linear-gradient(to right, #ece6e6, #000000);
          min-height: 100vh;
          display: flex;
          justify-content: center;
          align-items: center;
          padding: 0 35px;
      }
      .slider-card {
          max-width: 1460px;
          width: 100%;
          border-radius: 15px;
          position: relative;
      }
      .slider-card i {
          background-color: #fff;
          top: 50%;
          height: 46px;
          width: 46px;
          position: absolute;
          font-size: 1.4rem;
          cursor: pointer;
          text-align: center;
          line-height: 46px;
          border-radius: 50%;
          transform: translateY(-50%);
      }
      .slider-card i:first-child {
          left: -23px;
          display: none;
      }
      .slider-card i:last-child {
          right: -23px;
      }
      ion-icon {
          height: 46px;
          width: 46px;
          transform: translateY(-5%);
      }
      .slider-card .card-img {
          white-space: nowrap;
          font-size: 0px;
          overflow: hidden;
          scroll-behavior: smooth;
          width: 1450px;
      }
      .card-img.dragging {
          cursor: grab;
          scroll-behavior: auto;
      }
      .card-img.dragging img {
          pointer-events: none;
      }
      .card-img img {
          height: 350px;
          object-fit: cover;
          margin-left: 14px;
          width: calc(100% / 3);
          border-radius: 15px;
      }
      .card-img img:first-child {
          margin-left: 0px;
      }
      @media screen and (max-width: 900px) {
          .card-img img {
              width: calc(100% / 2);
          }
      }
      @media screen and (max-width: 550px) {
          .card-img img {
              width: 100%;
          }
      }
    </style>
  </head>
  <body>
      <div class="slider-card">
        <i id="left"><ion-icon name="caret-back-outline"></ion-icon></i>
        <div class="card-img"> 
            <img style="background: #3c04d8;" src="images/training.jpg" alt="" draggable="false">
            <img style="background: #04d1d8;" src="images/institue2.jpeg" alt="" draggable="false">
            <img style="background: #04d84b;" src="images/institue1.jpeg" alt="" draggable="false">
            <img style="background: #24037e;" src="images/institue3.jpeg" alt="" draggable="false">
            <img style="background: #3c04d8;" src="images/training.jpg" alt="" draggable="false">
            <img style="background: #04d1d8;" src="images/institue2.jpeg" alt="" draggable="false">
            <img style="background: #04d84b;" src="images/institue1.jpeg" alt="" draggable="false">
            <img style="background: #24037e;" src="images/institue3.jpeg" alt="" draggable="false">
            <img style="background: #04d84b;" src="images/institue1.jpeg" alt="" draggable="false">
            <img style="background: #24037e;" src="images/institue3.jpeg" alt="" draggable="false">
        </div>
        <i id="right"><ion-icon name="caret-forward-outline"></ion-icon></i>
      </div>
      <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
      <script>
        const cardImg = document.querySelector(".card-img");
        const firstImg = cardImg.querySelectorAll("img")[0];
        const cardIcons = document.querySelectorAll(".slider-card i");
        let isDragging = false, isAutoSliding = false, prevPageX, prevScrollLeft, positionDiff;
        
        const showHideIcons = () => {
            let scrollWidth = cardImg.scrollWidth - cardImg.clientWidth;
            cardIcons[0].style.display = cardImg.scrollLeft == 0 ? "none" : "block";
            cardIcons[1].style.display = cardImg.scrollLeft == scrollWidth ? "none" : "block";
        }
        
        cardIcons.forEach(icon => {
            icon.addEventListener("click", () => {
                let firstImgWidth = firstImg.clientWidth + 14;
                cardImg.scrollLeft += icon.id == "left" ? -firstImgWidth : firstImgWidth;
                setTimeout(() => showHideIcons(), 60);
            })
        });
        
        const autoSlide = () => {
            if(cardImg.scrollLeft == (cardImg.scrollWidth - cardImg.clientWidth)) return;

            positionDiff = Math.abs(positionDiff);
            let firstImgWidth = firstImg.clientWidth + 14;
            let valDifference = firstImgWidth - positionDiff;

            if(cardImg.scrollLeft > prevScrollLeft){
               return cardImg.scrollLeft += positionDiff > firstImgWidth / 3 ? valDifference : -positionDiff;
            }
            cardImg.scrollLeft -= positionDiff > firstImgWidth / 3 ? valDifference : -positionDiff;
        }

        const startAutoSlide = () => {
            setInterval(() => {
                let firstImgWidth = firstImg.clientWidth + 14;
                if (cardImg.scrollLeft == (cardImg.scrollWidth - cardImg.clientWidth)) {
                    cardImg.scrollLeft = 0;
                } else {
                    cardImg.scrollLeft += firstImgWidth;
                }
                showHideIcons();
            }, 3000); // Change image every 3 seconds
        }

        const dragStart = (e) => {
            isDragging = true;
            prevPageX = e.pageX || e.touches[0].pageX;
            prevScrollLeft = cardImg.scrollLeft
        }
        const dragging =(e) => {
            if(!isDragging) return;
            e.preventDefault()
            isAutoSliding = true;
            cardImg.classList.add("dragging");
            positionDiff = (e.pageX || e.touches[0].pageX) - prevPageX;
            cardImg.scrollLeft = prevScrollLeft - positionDiff;
            showHideIcons();
        }

        const dragStop = () => {
            isDragging = false;
            cardImg.classList.remove("dragging");

            if(!isAutoSliding) return;
            isAutoSliding = false;
            autoSlide();
        }

        cardImg.addEventListener("mousedown", dragStart);
        cardImg.addEventListener("touchstart", dragStart);

        cardImg.addEventListener("mousemove", dragging);
        cardImg.addEventListener("touchmove", dragging);

        cardImg.addEventListener("mouseup", dragStop);
        cardImg.addEventListener("mouseleave", dragStop);
        cardImg.addEventListener("touchend", dragStop);

        startAutoSlide();
      </script>
  </body>
</html>
