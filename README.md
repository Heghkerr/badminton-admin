<p align="center">
  <img src="https://cdn-icons-png.flaticon.com/512/1046/1046857.png" width="120" alt="Badminton Logo">
</p>

<p align="center">
<b>🏸 Badminton Club Admin System</b><br>
Smart management system for badminton communities
</p>

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/build-passing-brightgreen" alt="Build Status"></a>
<a href="#"><img src="https://img.shields.io/github/stars/your-username/your-repo" alt="Stars"></a>
<a href="#"><img src="https://img.shields.io/github/license/your-username/your-repo" alt="License"></a>
</p>

---

## About Badminton Club Admin System

Badminton Club Admin System is a web-based application built to simplify badminton community management.

This system helps organizers manage players, matches, and financial tracking in a structured and efficient way — eliminating manual tracking and ensuring fair gameplay for everyone.

---

## Features

- 🎯 **Player Recommendation System**  
  Automatically recommends players for matches (A/B vs C/D) to ensure fair rotation.

- 👥 **Player Management**  
  Add, edit, and manage player data easily.

- 🔢 **Match Tracking**  
  Track how many times each player has played in a session.

- 💰 **HTM & Payment Management**  
  Handle:
  - Daily (insidental) fees  
  - Member payments  
  - Total income tracking  

- 🧾 **Member System**  
  Differentiate between:
  - Member players  
  - Non-member players  

- ⚖️ **Fair Play System**  
  Prevent players from playing too often or too little.

---

## Why This Project Exists

Managing badminton sessions manually often leads to:

- Unfair player rotation  
- Confusion in match arrangement  
- Difficulty tracking payments  
- No clear record of player activity  

This system solves all of those problems in one platform.

---

## Tech Stack

- **Backend:** Laravel  
- **Frontend:** Blade / Vue (optional)  
- **Database:** MySQL  
- **Architecture:** MVC  

---

## Installation

```bash
git clone https://github.com/your-username/your-repo.git
cd your-repo

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate
php artisan serve
