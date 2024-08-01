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
        let itemSpeed = 2; // Initial speed in pixels per frame
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
        ];
        let timeLeft = 60; // 1 minute timer
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

                // Increase item speed at specific times
                if (timeLeft === 45 || timeLeft === 30 || timeLeft === 15) {
                    itemSpeed *= 1.25; // Slow down the speed increase
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
