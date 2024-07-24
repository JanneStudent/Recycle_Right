<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycle Right - Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="pictures/RRLogo-transformed.png" alt="Logo">
        </div>
        <div class="company-name">Recycle Right</div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="gamecenter.html">Game Center</a></li>
                <li><a href="login.html" class="login-button">Login</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <div class="hero-text">
                <h1>Recycle Right</h1>
                <button>Learn More</button>
            </div>
        </section>
        <a href="#content" class="scroll-down">&#8595;</a>
        <section id="content" class="content">
            <div class="text-box">
                <h2>For teachers</h2>
                <p>This website contains ready-made teaching materials for teaching recycling in grades 3-5.​
                    On the teacher's website you will find videos, 360° demonstration tours, ready-made quizzes and much more to support teaching.</p>
            </div>
            <div class="text-box">
                <h2>For parents</h2>
                <p>On this website you can find more information about the recycling game and the parental control panel for the application.​
                    We want you to feel safe letting your child play with our app and make learning fun.</p>
            </div>
            <div class="text-box full-width">
                <h2>Comments about the app</h2>
                <p>“The website has saved my time in the preparation of social studies lessons, and the interactive materials draw the children into learning.”​
                    - 3rd grade teacher</p>
            </div>
        </section>
    </main>
    <footer class="site-footer">
        <div class="container">
          <div class="footer-content">
            <h3>Contact Us</h3>
            <p>Email: info@recycleright.com</p>
            <p>Phone: (123) 456-7890</p>
          </div>
          <div class="footer-social-media">
            <h3>Follow Us</h3>
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
          </div>
        </div>
      </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var scrollDownButton = document.querySelector('.scroll-down');
            var contentSection = document.querySelector('.content');
    
            function toggleScrollButton() {
                if (contentSection.getBoundingClientRect().top < window.innerHeight) {
                    scrollDownButton.style.display = 'none';
                } else {
                    scrollDownButton.style.display = 'flex';
                }
            }
    
            window.addEventListener('scroll', toggleScrollButton);
    
            // Call the function once on page load to set initial state
            toggleScrollButton();
        });
    </script>    
</body>
</html>


