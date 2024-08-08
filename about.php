<?php include 'header.php'; ?>
<style>
     @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
     
    .content-container {
        display: flex;
        flex-direction: column;
        margin: 2em auto;
        width: 80%;
    }

    .main-content {
        background-color: #ffffff;
        padding: 20px;
        margin: 10px 0;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .sidebar {
        background-color: #f8f8f8;
        padding: 20px;
        margin: 10px 0;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #333;
        margin-bottom: 1em;
    }

    p {
        line-height: 1.6;
        margin-bottom: 1em;
        color: #666;
    }

    .content-container ul {
        list-style: disc inside;
        padding-left: 20px;
    }

    .content-container li {
        margin-bottom: 0.5em;
    }
</style>
</head>
<body>
    <div class="content-container">
        <main class="main-content">
            <h2>About Us</h2>
            <p>Welcome to [Your Company Name], where we are dedicated to providing exceptional services and solutions tailored to meet your needs. Our team of experts is committed to delivering excellence in every project we undertake.</p>
            <p>Founded in [Year], [Your Company Name] has grown to become a leader in the [Industry] industry, known for our innovative approaches and customer-centric philosophy. Our mission is to help our clients achieve their goals through reliable and efficient services.</p>

            <h2>Our Mission</h2>
            <p>Our mission is to deliver high-quality services that exceed our clients' expectations. We strive to foster long-term relationships built on trust, integrity, and mutual respect. By continuously improving and adapting to the latest industry trends, we ensure that our clients receive the best possible solutions.</p>

            <h2>Our Team</h2>
            <p>At [Your Company Name], we believe that our strength lies in our people. Our team comprises highly skilled professionals with diverse backgrounds and expertise. Together, we work collaboratively to provide innovative solutions and outstanding service to our clients.</p>
            <p>Our leadership team includes:</p>
            <ul>
                <li><strong>[Name]</strong> - CEO</li>
                <li><strong>[Name]</strong> - COO</li>
                <li><strong>[Name]</strong> - CFO</li>
                <li><strong>[Name]</strong> - CTO</li>
            </ul>

            <h2>Our Values</h2>
            <p>Our core values guide everything we do at [Your Company Name]. These include:</p>
            <ul>
                <li><strong>Integrity:</strong> We conduct our business with the highest standards of honesty and fairness.</li>
                <li><strong>Excellence:</strong> We strive for excellence in all aspects of our work.</li>
                <li><strong>Innovation:</strong> We embrace creativity and innovation to provide the best solutions.</li>
                <li><strong>Customer Focus:</strong> We are dedicated to understanding and meeting our clients' needs.</li>
                <li><strong>Collaboration:</strong> We believe in the power of teamwork and collaboration.</li>
            </ul>

            <h2>Contact Us</h2>
            <p>If you have any questions or would like to learn more about our services, please feel free to <a href="contact.php">contact us</a>. We look forward to working with you!</p>
        </main>

        
    </div>

    <!-- <footer> -->
        <!-- <?php include 'footer.php'; ?> -->
    <!-- </footer> -->
</body>
</html>
<?php include 'footer.php'; ?>
