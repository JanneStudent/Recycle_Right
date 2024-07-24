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
            background: inherit;
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
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            pointer-events: none;
        }
        .bin {
            width: 100px;
            height: 100px;
            border: 2px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            border-radius: 5px;
            margin: 0 5px;
        }
        #score {
            font-size: 24px;
            margin-top: 20px;
        }
        #timer {
            font-size: 24px;
            margin-top: 20px;
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
            <div class="bin" id="plasticBin" data-type="plastic">Plastic</div>
            <div class="bin" id="paperBin" data-type="paper">Paper</div>
            <div class="bin" id="metalBin" data-type="metal">Metal</div>
            <div class="bin" id="organicBin" data-type="organic">Organic</div>
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
            { type: 'plastic', src: 'images/plastic.jpg' },
            { type: 'paper', src: 'images/paper.jpg' },
            { type: 'metal', src: 'images/metal.jpg' },
            { type: 'organic', src: 'images/organic.jpg' }
        ];
        let timeLeft = 60;
        let gameInterval;
        let timerInterval;
        const gameArea = document.getElementById('gameArea');
        const binsContainer = document.getElementById('binsContainer');
        const bins = document.querySelectorAll('.bin');
        const binWidth = 100;
        const binSpacing = 5;

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
