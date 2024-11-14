// Question class
class Question {
    constructor(text, choices, correctAnswer, difficulty) {
      this.text = text;
      this.choices = choices;
      this.correctAnswer = correctAnswer;
      this.difficulty = difficulty; // Store the difficulty level of the question
    }
  
    isCorrectAnswer(choice) {
      return choice === this.correctAnswer;
    }
  }
  
  // Quiz class
  class Quiz {
    constructor() {
      this.currentQuestionIndex = 0;
      this.score = 0;
      this.questionsAnswered = 0; // Track total questions answered
    }
  
    checkAnswer(answer, incorrect) {
      if (this.currentQuestion && this.currentQuestion.isCorrectAnswer(answer)) {
        if (!incorrect) {
          this.score++;
        }
        return true;
      }
      return false;
    }
  
    hasEnded() {
      return this.questionsAnswered >= 5; // End after 5 questions
    }
  }

  // Game mode selection
function selectGameMode() {
  const gameModeContainer = document.getElementById("game-mode-selection");
  gameModeContainer.style.display = "block"; // Show game mode selection

  document.getElementById("short-mode").onclick = () => startQuiz(3); // Short game (3 questions)
  document.getElementById("normal-mode").onclick = () => startQuiz(5); // Normal game (5 questions)
  document.getElementById("long-mode").onclick = () => startQuiz(10); // Long game (10 questions)
}
  
  // Fetch questions async from API based on difficulty
  async function fetchQuestion(difficulty, retryCount = 0) {
    try {
      console.log(`Fetching a ${difficulty} question...`);
      const response = await fetch(
        `https://opentdb.com/api.php?amount=1&difficulty=${difficulty}`
      );
  
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
  
      const data = await response.json();
      const q = data.results[0];
      let choices = [...q.incorrect_answers];
      let correctAnswer = q.correct_answer;
      choices.push(correctAnswer);
      // Shuffle choices
      choices.sort(() => Math.random() - 0.5);
      return new Question(q.question, choices, correctAnswer, q.difficulty);
  
    } catch (error) {
      console.error(`Error fetching question: ${error.message}`);
      
      // Retry logic for API errors (e.g., "Too Many Requests" 429)
      if (retryCount < 3) {
        console.log(`Retrying fetch... Attempt ${retryCount + 1}`);
        await new Promise(resolve => setTimeout(resolve, 1000)); // Wait 1 second before retrying
        return fetchQuestion(difficulty, retryCount + 1);
      } else {
        console.error('Max retries reached. Unable to fetch question.');
        return null;
      }
    }
  }
  
  // Display the question and handle quiz flow
  async function startQuiz() {
    const gameModeContainer = document.getElementById("game-mode-selection");
    gameModeContainer.style.display = "none"; // Hide game mode selection
    document.getElementById("quiz-container").style.display = "block"; // Show quiz container

    let difficulty = 'easy'; // Start with easy questions
    const quiz = new Quiz();
    let answered = false; // Track if the current question has been answered
  
    async function displayQuestion() {
      if (quiz.hasEnded()) {
        showScores();
        return;
      }
  
      quiz.currentQuestion = await fetchQuestion(difficulty);
      
      if (!quiz.currentQuestion) {
        document.getElementById("question").innerHTML = "Error fetching question. Please try again.";
        return;
      }
  
      document.getElementById("question").innerHTML = quiz.currentQuestion.text;
  
      let choicesList = document.getElementById("choices");
      choicesList.innerHTML = "";
  
      quiz.currentQuestion.choices.forEach((choice) => {
        let li = document.createElement("li");
        li.innerHTML = `<button class="choice-btn">${choice}</button>`;
        choicesList.appendChild(li);
  
        const button = li.querySelector(".choice-btn");
  
        li.addEventListener("click", () => {
          if (!answered) {
            let correct = quiz.checkAnswer(choice, false);
            if (correct) {
              button.style.backgroundColor = "green";
            } else {
              button.style.backgroundColor = "red";
              choicesList.querySelectorAll('.choice-btn').forEach(btn => {
                if (btn.textContent === quiz.currentQuestion.correctAnswer) {
                  btn.style.backgroundColor = "green";
                }
              });
            }
            answered = true;
            quiz.questionsAnswered++;
            showScore();
          }
        });
      });
    }
  
    function adjustDifficulty() {
      const scoreRatio = quiz.score / quiz.questionsAnswered;
  
      if (scoreRatio >= 0.6 && difficulty !== 'hard') {
        difficulty = 'hard';
      } else if (scoreRatio >= 0.3 && scoreRatio < 0.6 && difficulty !== 'medium') {
        difficulty = 'medium';
      } else if (scoreRatio < 0.3 && difficulty !== 'easy') {
        difficulty = 'easy';
      }
  
      console.log(`Adjusted difficulty to: ${difficulty}`);
    }
  
    async function displayNextQuestion() {
      if (answered) {
        adjustDifficulty(); // Adjust difficulty before fetching next question
        answered = false; // Reset for the next question
        await displayQuestion();
      }
    }
  
    function showScores() {
      document.getElementById("quiz").innerHTML = `
        <h2 style="color: #fff;">Quiz Completed</h2>
        <p style="color: #fff;">Your score: ${quiz.score}/5</p>
      `;
    }
  
    function showScore() {
      document.getElementById("results").innerHTML = `
        <p style="color: #fff;">Your score: ${quiz.score}/${quiz.questionsAnswered}</p>
      `;
    }
  
    // Event listener for the "Next Question" button
    document
      .getElementById("next-btn")
      .addEventListener("click", displayNextQuestion);
  
    // Start quiz by displaying the first question
    displayQuestion();
  }
  
  startQuiz();
  