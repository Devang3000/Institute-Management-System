<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alpha Institute Footer</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --background-color: #222426;
            --white: rgb(242, 242, 242);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        .footer {
            background-color: var(--background-color);
            padding: 50px 0;
            color: var(--white);
            bottom: 0;
        }
        .wrap {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .footer-container {
            flex: 1;
            padding: 10px;
            text-align: center;
            width: 500px;
        }
        .logo {
            font-size: 1.7em;
            color: var(--white);
        }
        .footer-container h3 {
            margin-bottom: auto;
            font-size: 1.2em;
            font-weight: 600;
            letter-spacing: 2px;
            text-decoration: underline;
        }
        .footer-container ul {
            display: list-item;
            list-style: none;
            justify-content: center;
            flex-wrap: wrap;
            padding: 0;
            text-decoration: none;
        }
        .footer-container ul li {
            margin: 5px;
            list-style: none;
            text-decoration: none;
        }
        .footer-container ul li a {
            font-size: 1em;
            color: var(--white);
            text-decoration: none;
            padding: 5px;
        }
        .footer-container ul li a:hover,
        .footer-container ul li a:focus {
            border-bottom: 2px solid var(--white);
            outline: none;
        }
        @media screen and (max-width: 950px) {
            .footer-container {
                flex: 1 0 45%; /* Allows two columns */
                padding: 30px 10px;
            }
        }
        @media screen and (max-width: 500px) {
            .footer-container {
                flex: 1 0 100%; /* Stacks columns */
                padding: 25px 10px;
            }
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="wrap">
            <div class="footer-container">
                <img src="http://localhost/test/images/icon.png" style="width:120px; height:120px" class="logo" aria-label="Footer Logo">
            </div>
            <div class="footer-container">
                <h3>Alpha Institute</h3>
                <ul>
                    <li><a href="http://localhost/test/about.php" aria-label="About us">About Us</a></li>
                    <li><a href="http://localhost/test/contact.php" aria-label="Contact">Contact</a></li>
                    <li><a href="http://localhost/test/news.php" aria-label="News">News</a></li>
                </ul>
            </div>
            <div class="footer-container">
                <h3>Support</h3>
                <ul>
                    <li><a href="http://localhost/test/faq.php" aria-label="FAQ">FAQ</a></li>
                    <li><a href="http://localhost/test/helpdesk.php" aria-label="Help Desk">Help Desk</a></li>
                    <li><a href="http://localhost/test/terms.php" aria-label="Terms of Service">Terms of Service</a></li>
                </ul>
            </div>
            <div class="footer-container">
                <h3>Academics</h3>
                <ul>
                    <li><a href="http://localhost/test/courses.php" aria-label="Courses">Courses</a></li>
                    <li><a href="http://localhost/test/admissions.php" aria-label="Admissions">Admissions</a></li>
                    <li><a href="http://localhost/test/scholarships.php" aria-label="Scholarships">Scholarships</a></li>
                </ul>
            </div>
            
        </div>
    </footer>
</body>
</html>
