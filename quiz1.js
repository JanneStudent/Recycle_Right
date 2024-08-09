  let score = 0;
  let currentQuestion = 0;
  
  const quiz = document.getElementById('quiz');
  const questionElement = document.createElement('div');
  questionElement.id = 'question';
  questionElement.classList.add('question'); 
  quiz.appendChild(questionElement);
  
  const optionsElement = document.createElement('div');
  optionsElement.id = 'options';
  optionsElement.classList.add('options');
  quiz.appendChild(optionsElement);
  
  const quizData = [
    {
      question: "Mikä seuraavista on uusiutuva energianlähde?",
      options: ["Bensiini", "Aurinkoenergia", "Kivihiili", "Öljy"],
      answer: "Aurinkoenergia"
    },
    {
      question: "Uusiutumattomat energianlähteet ovat toiselta nimeltään?",
      options: ["Fossiilisia polttoaineita", "Biopolttoaineita", "Vanhoja polttoaineita", "Uusia polttoaineita"],
      answer: "Fossiilisia polttoaineita"
    },
    {
      question: "Kuinka paljon sähköä kulutettiin Suomessa vuonna 2022?",
      options: ["1,3 miljoonaa terajoulea", "1,3 miljoonaa kilojoulea", "1,5 megawattia", "1,5 kilowattia"],
      answer: "1,3 miljoonaa terajoulea"
    },
    {
      question: "Kuinka suuri oli uusiutuvien energianlähteiden osuus vuonna 2022?",
      options: ["76%", "42%", "100%", "14%"],
      answer: "42%"
    },
    {
      question: "Mihin seuraavista voi saada energiatukea?",
      options: ["Omakotitalon lämmitysjärjestelmän uusimiseen", "Hukkalämmön hyödyntämistä tutkivaan projektiin", "Puiden istutukseen hakkuuaukealle", "Auton tankkaamiseen"],
      answer: "Hukkalämmön hyödyntämistä tutkivaan projektiin"
    },
    // Add more questions here...
  ];
  
  function showQuestion() {
    const question = quizData[currentQuestion];
    questionElement.innerText = question.question;
  
    optionsElement.innerHTML = "";
    question.options.forEach(option => {
      const button = document.createElement("button");
      button.innerText = option;
      optionsElement.appendChild(button);
      button.addEventListener("click", selectAnswer);
    });
  }
  
  function selectAnswer(e) {
    const selectedButton = e.target;
    const answer = quizData[currentQuestion].answer;
  
    if (selectedButton.innerText === answer) {
      score++;
    }
  
    currentQuestion++;
  
    if (currentQuestion < quizData.length) {
      showQuestion();
    } else {
      showResult();
    }
  }
  
  function showResult() {
    quiz.innerHTML = `
      <h1>Quiz Completed!</h1>
      <p>Your score: ${score}/${quizData.length}</p>
      <button id="restartButton">Restart Quiz</button>
    `;
    document.getElementById('restartButton').addEventListener('click', restartQuiz);
  }
  
  function restartQuiz() {
    score = 0;
    currentQuestion = 0;
    quiz.innerHTML = ''; // Clear the quiz container
  
    // Reinitialize the quiz UI elements
    quiz.appendChild(questionElement);
    quiz.appendChild(optionsElement);
  
    showQuestion();
  }
  
  showQuestion();