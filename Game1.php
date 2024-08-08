<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycling Sorter Game</title>
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
        .bins {
            display: flex;
            position: absolute;
            bottom: 80px; /* Moved up from 20px to 80px */
            left: 50%;
            transform: translateX(-50%);
            pointer-events: none;
            color: white; /* Ensure bin text is white */
        }
        .bin {
            width: 100px;
            height: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            position: relative;
            pointer-events: auto;
            background-color: transparent; /* Remove the green background */
            border: none; /* Remove any border */
        }
        .bin img {
            width: 100%;  /* Ensure image fits the bin */
            height: auto;
        }
        .bin-text {
            margin-top: 5px;
            text-align: center;
            font-size: 18px; /* Ensure text size is readable */
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
        .item {
            width: 50px;
            height: 50px;
            position: absolute;
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
        <div class="conveyor-belt" id="conveyorBelt"></div>
        <div class="bins">
            <div class="bin" id="plasticBin" data-type="plastic">
                <img src="images/bin.png" alt="Plastic Bin">
                <div class="bin-text">Plastic</div>
            </div>
            <div class="bin" id="paperBin" data-type="paper">
                <img src="images/bin.png" alt="Paper Bin">
                <div class="bin-text">Paper</div>
            </div>
            <div class="bin" id="metalBin" data-type="metal">
                <img src="images/bin.png" alt="Metal Bin">
                <div class="bin-text">Metal</div>
            </div>
            <div class="bin" id="organicBin" data-type="organic">
                <img src="images/bin.png" alt="Organic Bin">
                <div class="bin-text">Organic</div>
            </div>
            <div class="bin" id="mixedBin" data-type="mixed">
                <img src="images/bin.png" alt="mixed">
                <div class="bin-text">Mixed Waste</div>
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
            { type: 'mixed', src: 'images/diaper.png' }, /* Mixed waste items */
            { type: 'mixed', src: 'images/pen.png' },
            { type: 'mixed', src: 'images/t-shirt.png' },
        ];
        let timeLeft = 60;
        let gameInterval;
        let timerInterval;
        const activeItems = new Set();

        function getRandomItem() {
            return items[Math.floor(Math.random() * items.length)];
        }

        function createItem() {
            const item = getRandomItem();
            const itemElement = document.createElement('img');
            itemElement.src = item.src;
            itemElement.classList.add('item');
            itemElement.draggable = true;
            itemElement.dataset.type = item.type;

            itemElement.ondragstart = function (event) {
                event.dataTransfer.setData('type', item.type);
            };

            document.getElementById('conveyorBelt').appendChild(itemElement);
            activeItems.add(itemElement);

            itemElement.style.left = '0px';
            let position = 0;
            const interval = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    itemElement.remove();
                    activeItems.delete(itemElement);
                } else if (position >= window.innerWidth) {
                    clearInterval(interval);
                    if (activeItems.has(itemElement)) {
                        itemElement.remove();
                        activeItems.delete(itemElement);
                        score--; // Decrease score when item goes out of sight
                        updateScore();
                    }
                } else {
                    position += itemSpeed;
                    itemElement.style.left = position + 'px';
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

                if (timeLeft === 45 || timeLeft === 30 || timeLeft === 15) {
                    itemSpeed *= 1.25;
                }
            }
        }

        document.querySelectorAll('.bin').forEach(bin => {
            bin.ondragover = function (event) {
                event.preventDefault();
            };

            bin.ondrop = function (event) {
                event.preventDefault();
                const type = event.dataTransfer.getData('type');
                const draggedItem = document.querySelector(`img[data-type=${type}]`);

                if (draggedItem) {
                    draggedItem.remove();  // Remove the item from the conveyor belt
                    activeItems.delete(draggedItem);

                    if (bin.dataset.type === type) {
                        score++;
                    } else {
                        score--;
                    }
                    updateScore();
                }
            };
        });

        gameInterval = setInterval(createItem, 2000);
        timerInterval = setInterval(updateTime, 1000);
    </script>
</body>
</html>
