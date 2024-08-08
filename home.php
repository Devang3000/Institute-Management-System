<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin-top: 0px;
        }
        main {
            padding: 0;
            margin: 0;
            width: 100%;
        }
        .google-map {
            padding-bottom: 50%;
            position: relative;
        }
        .google-map iframe {
            height: 100%;
            width: 100%;
            left: 0;
            top: 0;
            position: absolute;
        }
        .services-container {
            margin: 2em auto;
            width: 80%;
            display: flex;
            flex-direction: column;
        }
        .sectionintro {
            margin-bottom: 2em;
        }
        .section.features {
            margin-bottom: 2em;
        }
        @media screen and (max-width: 900px) {
            .services-container {
                width: 95%;
            }
            .sectionintro, .section.features {
                margin-bottom: 1.5em;
            }
        }
        @media screen and (max-width: 600px) {
            .google-map {
                padding-bottom: 75%;
            }
            h1, h2 {
                font-size: 1.5em;
            }
            p {
                font-size: 1em;
            }
        }
        #loading {
            position: fixed;
            width: 100%;
            height: 100%;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            z-index: 9999; /* Ensure it's on top of other content */
        }
    </style>
     <script>
        // JavaScript to hide the loading screen after 2 seconds
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loading').style.display = 'none';
            }, 1000);
        });
    </script>
</head>
<body>
<div id="loading">Loading, please wait...</div>
    <div class="container">
        <main>
            <div>
                <?php include("crousal.php")?>
            </div>
            <div class="services-container">
                <div class="sectionintro">
                    <h2>Welcome to Alpha IT Training Institute</h2>
                    <p>At AlphaIT Training Institute, we are dedicated to providing top-notch IT education to help you excel in your career. Whether you're a beginner or an experienced professional, our comprehensive courses are designed to cater to all levels of expertise.</p>
                    <p>Our expert instructors bring real-world experience and knowledge to the classroom, ensuring that you gain the skills and confidence needed to succeed in the rapidly evolving IT industry. Join us and take the first step towards a brighter future.</p>
                    <p>Located in the heart of the city, our state-of-the-art facilities and hands-on training approach create an ideal learning environment. We believe in empowering our students with practical knowledge and real-time problem-solving skills, making them industry-ready from day one.</p>
                </div>
                <div>
                    <h1>Courses</h1>
                    <?php include("courseslider.php")?>
                </div>
                <div class="section features">
                    <h2>Why Choose Us?</h2>
                    <p><strong>Experienced Instructors:</strong> Our instructors are industry experts with years of practical experience. They bring a wealth of knowledge to the classroom, providing you with insights that go beyond textbooks.</p>
                    <p><strong>Comprehensive Curriculum:</strong> Our courses are designed to cover all essential aspects of the subject, ensuring a thorough understanding of both theoretical concepts and practical applications.</p>
                    <p><strong>Flexible Learning Options:</strong> We offer both in-person and online classes to fit your schedule. Our flexible learning options ensure that you can balance your education with your personal and professional life.</p>
                    <p><strong>Career Support:</strong> We provide career counseling, resume workshops, and job placement assistance to help you transition smoothly from learning to earning. Our extensive network of industry contacts opens doors to exciting job opportunities.</p>
                    <p><strong>State-of-the-Art Facilities:</strong> Our training center is equipped with modern facilities and the latest technology, creating a conducive learning environment where you can thrive and grow.</p>
                    <p>Join Alpha IT Training Institute today and start your journey towards a successful IT career. Explore our courses, meet our instructors, and experience the difference that quality training can make.</p>
                </div>
                <div>
                    <h2>Testimonials</h2>
                    <?php include 'imageslider.php'; ?>
                </div>
                <h2>LOCATION</h2>
                <div class="google-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3692.268306313414!2d73.14811377511738!3d22.267824079709925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395fc6159fe3c1a3%3A0x81edeb57806aa112!2sshree%20krishna%20infotech%20-%20computer%20%26%20IT%20education%20and%20Training%20centre!5e0!3m2!1sen!2sin!4v1719040131047!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
