# Quizzy
Welcome to Quizzy! Quizzy is a side project that I'm working on and it is in continious development for now. \
This README provides a comprehensive guide on how to use the platform, including user registration, login, quiz gameplay and gamemodes, and admin-specific features.

## Table of Contents
1. [Introduction](#introduction)
2. [Getting Started](#getting-started)
3. [User Guide](#user-guide)
   - [Registration](#registration)
   - [Login](#login)
   - [Selecting a Game Mode](#selecting-a-game-mode)
   - [Playing the Quiz](#playing-the-quiz)
4. [Admin Guide](#admin-guide)
5. [Database Structure](#database-structure)
6. [Technologies Used](#technologies-used)
7. [Future Improvements](#future-improvements)

---

## Introduction
Quizzy is designed for users who wish to test their trivia knowledge.\
\
Thought about hosting a game night for your friends and family?
- You can be the admin and each user can make their own account to access the quiz and have their highest scores for each game mode saved!
- As an admin you can still enjoy the quiz while having access to additional management capabilities that would let you view all users in addition to their scores.
- Someone got caught cheating? Let them know it's just a game and they'll always be loved even if they don't try hard... then proceed to delete their account from your admin dashboard so that they can make a new account and start clean!
\
\
The application provides:
- **User-friendly registration and login system**.
- **Different quiz game modes** (short, normal, and long).
- **Score tracking** for all players.
- **Admin dashboard** with enhanced features for managing users, viewing quiz statistics, and more.

## Getting Started
The application is fully containerized with Docker, making it easy to deploy and run locally or in any environment that supports Docker.
As the main user, youre the only one that needs to take the following steps to set up the web app. Once you're done, your friends and family (as long as they are on the same wifi) can access the web app using http://localhost:8080

### Prerequisites

- Docker
- Docker Compose

### Steps to Set Up

1. **Clone the repository**:
  git clone https://github.com/programmoh/quizzy.git cd quizzy
2. **Build and start the application using Docker Compose**:
  This will build and launch all necessary services, including the web app and MySQL database.
3. **Access the application**:
  Once the services are running, open your browser and navigate to: http://localhost:8080
4. **Stopping the application**:
  To stop the application and its services, run: docker-compose down

## User Guide

### Registration
1. **Create an account** by filling in the username, password, and confirmation fields on the registration page.
2. Upon successful registration, users are redirected to the login page to access Quizzy.

### Login
1. **Log in** using the username and password created during registration.
2. Users will be redirected to the main landing page where they can start playing the quiz or explore other features(coming soon!).

### Selecting a Game Mode
1. After logging in, users are prompted to select a **game mode**:
   - **Short Mode** (5 questions)
   - **Normal Mode** (10 questions)
   - **Long Mode** (20 questions)
2. Based on the game mode selected, the quiz will end after the specified number of questions.

### Playing the Quiz
1. **Question Presentation**:
   - Each question is displayed along with answer options.
   - The question's difficulty level is dynamically adjusted based on the user’s performance, starting with easy questions. The better you do, the harder it gets!
2. **Answering Questions**:
   - Users can select an answer and receive immediate feedback (correct answers are highlighted in green, incorrect in red).
3. **Score Tracking**:
   - Scores are updated after each question and shown in real-time on the quiz screen.
4. **Scores**:
   - Once the quiz is completed, scores are saved, and users can view their highscores for each game mode.
5. **Game Mode Selection on Completion**:
   - After completing a quiz, users can choose to play again by selecting a game mode.

## Admin Guide

Admin users have exclusive access to the **Admin Dashboard**. Here, they can view and manage additional platform features. The dashboard includes:
- **User Management**: View all registered users and delete their accounts, if needed (or if someone is stealing your top spot, no judgement here!)
- **Quiz Statistics**: Access data on the overall user performance in each game mode.


## Database Structure
The database consists of the following tables:

1. **Users Table**:
   - `id`: Unique user ID.
   - `username`: Username selected during registration.
   - `password`: Hashed password.
   - `salt`: Salt used for hashing the password.
2. **Scores Table**:
   - `user_id`: References the `id` of a user.
   - `high_score_short`: Highest score achieved by the user in the short mode.
   - `high_score_normal`: Highest score achieved by the user in the normal mode.
   - `high_score_long`: Highest score achieved by the user in the long mode.


## Technologies Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP, MySQL
- **Database**: MySQL
- **Session Management**: PHP Sessions
- **Containerization**: Docker, Docker Compose

## Future Improvements
- **Users Leaderboard**: Allow users to view their ranking on the leaderboard, once the quiz is completed.
- **Customizable Game Modes**: Let users choose custom quizzes with specific topics not just general trivia.
- **Achievements System**: Reward users with badges for reaching milestones.
- **Enhanced Quiz Statistics**: Provide more detailed analytics on quiz difficulty, user performance trends, and question accuracy rates, as well as the number of quizzes taken and average scores.
- **Website hosting**: Host the Web app at a domain for ease of use and set up.

---
