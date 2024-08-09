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
    question: "Mihin banaanin kuoret kuuluvat?",
    options: ["Biojätteeseen", "Sekajätteeseen", "Kartonki keräykseen", "Ei mikään näistä"],
    answer: "Biojätteeseen"
  },
  {
    question: "Mihin leivinpaperi kuuluu?",
    options: ["Biojätteeseen", "Sekajätteeseen", "Varmista asia oman kuntasi kierrätysohjeista", "Vaaralliseen jätteeseen"],
    answer: "Varmista asia oman kuntasi kierrätysohjeista"
  },
  {
    question: "Kuinka paljon jätettä kerättiin suomalaista kohden vuonna 2020?",
    options: ["n. 600kg", "n. 10kg", "n. 1000kg", "n. 10 000kg"],
    answer: "n. 600kg"
  },
  {
    question: "Mihin kuuluu vanha, puhdas, puuvilla t-paita?",
    options: ["Sekajätteeseen", "Vaatekaupan kierrätyspisteeseen", "Siivousräteiksi", "Biojätteeseen"],
    answer: "Vaatekaupan kierrätyspisteeseen"
  },
  {
    question: "Mihin rikkoutunut juomalasi kuuluu?",
    options: ["Lasinkeräykseen", "Sekajätteeseen", "Vaaralliseen jätteeseen", "Biojätteeseen"],
    answer: "Sekajätteeseen"
  },
  {
    question: "Mikä seuraavista on vaarallista jätettä?",
    options: ["Yli jäänyt talon ulkomaali", "Vanha sohva", "Hiekkalapio", "Vanhentunut jogurtti"],
    answer: "Yli jäänyt talon ulkomaali"
  },
  {
    question: "Mihin tyhjä maalipurkki kuuluu?",
    options: ["Vaaralliseen jätteeseen", "Metallinkeräykseen", "Sekajätteeseen", "Biojätteeseen"],
    answer: "Metallinkeräykseen"
  },
  {
    question: "Mihin vanhentunut särkylääke kuuluu?",
    options: ["Sekajätteeseen", "Vaaralliseen jätteeseen", "Apteekkiin", "Lasinkeräykseen"],
    answer: "Apteekkiin"
  },
  {
    question: "Kuinka monta kertaa puukuituinen pahvipakkaus voidaan kierrättää?",
    options: ["Yhden kerran", "2 kertaa", "5-7 kertaa", "Loputtomasti"],
    answer: "5-7 kertaa"
  },
  {
    question: "Mihin LED-loisteputki kuuluu?",
    options: ["Sekajätteeseen", "Sähkölaiteromuun (SER)", "Lasinkeräykseen", "Metallinkeräykseen"],
    answer: "Sähkölaiteromuun (SER)"
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