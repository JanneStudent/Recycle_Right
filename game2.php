<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycling Sorter Game 2</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            color: white; /* Set text color to white */
        }
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-image: url('pictures/gameforest.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        #gameArea {
            position: relative;
            width: 80%;
            height: 100vh;
            overflow: hidden;
            margin: 0 auto;
        }
        .item {
            width: 50px;
            height: 50px;
            position: absolute;
        }
        .bins {
            display: flex;
            position: absolute;
            bottom: 80px; /* Position adjusted */
            left: 50%;
            transform: translateX(-50%);
            pointer-events: none;
        }
        .bin {
            width: 100px;
            height: 120px; /* Adjusted height to make space for the text below */
            display: flex;
            flex-direction: column; /* Ensures text is below the bin image */
            align-items: center;
            justify-content: flex-end; /* Text is placed at the bottom */
            margin: 0 5px;
            background-color: transparent;
            position: relative;
            text-align: center;
            border: none;
        }
        .bin img {
            width: 100%;
            height: auto;
            pointer-events: none; /* Ensure images are not draggable */
        }
        .bin span {
            margin-top: 5px;
            color: white; /* Make text color white */
            font-weight: bold;
            z-index: 2; /* Ensure text is above the image */
        }
        #score, #timer {
            font-size: 24px;
            margin-top: 20px;
            color: white; /* Ensure score and timer are white */
        }
        #gameOver {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 2px solid #333;
            border-radius: 10px;
            text-align: center;
            color: black; /* Text inside game over is black for contrast */
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="pictures/RRLogo-transformed.png" alt="Logo">
        </div>
        <div class="company-name">Recycle Right</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="gamecenter.html">Game Center</a></li>
                <li><a href="login.html" class="login-button">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div id="gameArea"></div>
        <div class="bins" id="binsContainer">
            <div class="bin" id="plasticBin" data-type="plastic">
                <img src="images/bin.png" alt="Plastic Bin">
                <span>Plastic</span>
            </div>
            <div class="bin" id="paperBin" data-type="paper">
                <img src="images/bin.png" alt="Paper Bin">
                <span>Paper</span>
            </div>
            <div class="bin" id="metalBin" data-type="metal">
                <img src="images/bin.png" alt="Metal Bin">
                <span>Metal</span>
            </div>
            <div class="bin" id="organicBin" data-type="organic">
                <img src="images/bin.png" alt="Organic Bin">
                <span>Organic</span>
            </div>
            <!-- New Mixed Waste Bin -->
            <div class="bin" id="mixedWasteBin" data-type="mixed">
                <img src="images/bin.png" alt="Mixed Waste Bin">
                <span>Mixed</span>
            </div>
        </div>
        <div id="score">Score: 0</div>
        <div id="timer">Time left: 60s</div>
    </main>

    <div id="gameOver">
        <h2>Game Over!</h2>
        <p>Your score is: <span id="finalScore"></span></p>
        <button onclick="location.reload()">Play Again</button>
    </div>

    <script>
        let score = 0;
        let itemSpeed = 2;
        const items = [
            { type: 'plastic', src: 'images/bag.png' },
            { type: 'plastic', src: 'images/plastic-cup.png' },
            { type: 'paper', src: 'images/newspaper.png' },
            { type: 'paper', src: 'images/paper.png' },
            { type: 'metal', src: 'images/bolt.png' },
            { type: 'metal', src: 'images/chain (1).png' },
            { type: 'metal', src: 'images/clip.png' },
            { type: 'metal', src: 'images/steel.png' },
            { type: 'organic', src: 'images/dried-fruits.png' },
            { type: 'organic', src: 'images/durian.png' },
            { type: 'organic', src: 'images/fruits.png' },
            // New Mixed Waste Items
            { type: 'mixed', src: 'images/diaper.png' },
            { type: 'mixed', src: 'images/pen.png' },
            { type: 'mixed', src: 'images/t-shirt.png' },
        ];
        let timeLeft = 60;
        let gameInterval;
        let timerInterval;
        const gameArea = document.getElementById('gameArea');
        const binsContainer = document.getElementById('binsContainer');
        const bins = document.querySelectorAll('.bin');

        function getRandomItem() {
            return items[Math.floor(Math.random() * items.length)];
        }

        function createItem() {
            const item = getRandomItem();
            const itemElement = document.createElement('img');
            itemElement.src = item.src;
            itemElement.classList.add('item');
            itemElement.dataset.type = item.type;
            itemElement.style.left = Math.floor((gameArea.offsetWidth * 0.2) + Math.random() * (gameArea.offsetWidth * 0.6 - 50)) + 'px';
            itemElement.style.top = '0px';
            gameArea.appendChild(itemElement);

            let position = 0;
            const interval = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    itemElement.remove();
                } else if (position >= (gameArea.offsetHeight - itemElement.offsetHeight)) {
                    clearInterval(interval);
                    itemElement.remove();
                    score--; // Deduct score for missing item
                    updateScore();
                } else {
                    position += itemSpeed;
                    itemElement.style.top = position + 'px';
                    checkItemCollision(itemElement, interval);
                }
            }, 20);
        }

        function updateScore() {
            document.getElementById('score').innerText = 'Score: ' + score;
        }

        function updateTime() {
            if (timeLeft <= 0) {
                clearInterval(gameInterval);
                clearInterval(timerInterval);
                document.getElementById('finalScore').innerText = score;
                document.getElementById('gameOver').style.display = 'block';
            } else {
                timeLeft--;
                document.getElementById('timer').innerText = 'Time left: ' + timeLeft + 's';
                if (timeLeft === 30 || timeLeft === 15) {
                    itemSpeed *= 1.5;
                }
            }
        }

        document.addEventListener('mousemove', function (event) {
            const mouseX = event.clientX;
            binsContainer.style.left = (mouseX - binsContainer.offsetWidth / 2) + 'px';
        });

        function checkItemCollision(item, interval) {
            const itemRect = item.getBoundingClientRect();
            bins.forEach(bin => {
                const binRect = bin.getBoundingClientRect();
                if (
                    itemRect.bottom >= binRect.top &&
                    itemRect.top <= binRect.bottom &&
                    itemRect.left <= binRect.right &&
                    itemRect.right >= binRect.left
                ) {
                    if (item.dataset.type === bin.dataset.type) {
                        score++;
                    } else {
                        score--;
                    }
                    updateScore();
                    clearInterval(interval); // Stop the item's interval
                    item.remove(); // Remove the item
                }
            });
        }

        gameInterval = setInterval(createItem, 2000);
        timerInterval = setInterval(updateTime, 1000);
    </script>
</body>
</html>
