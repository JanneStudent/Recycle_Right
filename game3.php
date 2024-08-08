<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycling Sorter Game 3</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            color: white; /* Ensure text color is white */
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
            height: 80vh;
            overflow: hidden;
            margin: 0 auto;
        }
        .item {
            width: 50px;
            height: 50px;
            position: absolute;
        }
        .garbage-can {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.8); /* Slight transparency */
            border-radius: 5px;
            position: absolute;
            pointer-events: none;
            text-align: center;
            font-weight: bold;
            color: black; /* Ensure contrast with white background */
        }
        #score, #timer {
            font-size: 24px;
            margin-top: 20px;
            color: white; /* Set score and timer text color to white */
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
        <div id="score">Score: 0</div>
        <div id="timer">Time left: 60s</div>
        <div class="garbage-can" id="garbageCan">Plastic</div>
    </main>

    <div id="gameOver">
        <h2>Game Over!</h2>
        <p>Your score is: <span id="finalScore"></span></p>
        <button onclick="location.reload()">Play Again</button>
    </div>

    <script>
        let score = 0;
        let timeLeft = 60;
        let currentType = 'plastic';
        let previousType = 'plastic';
        let itemSpawnRate = 1000; // Faster spawn rate
        let itemVanishTime = 5000; // Shorter vanish time
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
        let gameInterval;
        let timerInterval;
        const gameArea = document.getElementById('gameArea');
        const garbageCan = document.getElementById('garbageCan');

        function getRandomItem() {
            return items[Math.floor(Math.random() * items.length)];
        }

        function createItem() {
            const item = getRandomItem();
            const itemElement = document.createElement('img');
            itemElement.src = item.src;
            itemElement.classList.add('item');
            itemElement.dataset.type = item.type;
            itemElement.style.left = Math.floor(Math.random() * (gameArea.offsetWidth - 50)) + 'px';
            itemElement.style.top = Math.floor(Math.random() * (gameArea.offsetHeight - 50)) + 'px';
            gameArea.appendChild(itemElement);

            itemElement.onclick = function() {
                if (itemElement.dataset.type === currentType) {
                    score++;
                } else {
                    score--;
                }
                updateScore();
                itemElement.remove();
                switchGarbageCan();
            };

            setTimeout(() => {
                if (gameArea.contains(itemElement)) {
                    itemElement.remove();
                }
            }, itemVanishTime); // Item disappears after the set vanish time
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

                // Adjust spawn rate and vanish time based on the remaining time
                if (timeLeft % 15 === 0) {
                    itemSpawnRate *= 0.9; // Increase spawn rate every 15 seconds
                    clearInterval(gameInterval);
                    gameInterval = setInterval(createItem, itemSpawnRate);
                }
                if (timeLeft === 30) {
                    itemVanishTime *= 1.2; // Items vanish slightly slower in the last 30 seconds
                }
            }
        }

        document.addEventListener('mousemove', function(event) {
            garbageCan.style.left = (event.clientX - garbageCan.offsetWidth / 2) + 'px';
            garbageCan.style.top = (event.clientY - garbageCan.offsetHeight / 2) + 'px';
        });

        function switchGarbageCan() {
            const types = ['plastic', 'paper', 'metal', 'organic', 'mixed']; // Added 'mixed' type
            let nextType;
            do {
                nextType = types[Math.floor(Math.random() * types.length)];
            } while (nextType === currentType);
            previousType = currentType;
            currentType = nextType;
            garbageCan.innerText = capitalizeFirstLetter(nextType);
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        window.onload = function() {
            gameInterval = setInterval(createItem, itemSpawnRate);
            timerInterval = setInterval(updateTime, 1000);
        }
    </script>
</body>
</html>
