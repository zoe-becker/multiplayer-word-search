# Word Search

[//]: <> (Outline a brief description of your project.)
[//]: <> (Live demo [_here_](https://www.example.com). <!-- If you have the project hosted somewhere, include the link here. -->)

## Table of Contents
* [The Team 🤝](#TheTeam) 
* [What We're Creating 🧰](#WhatWe'reCreating) 
* [Technologies Used 🧑‍💻](#TechnologiesUsed) 
* [Who Are We Doing This For? 🫵](#WhoAreWeDoingThisFor?) 
* [Why Are We Doing This? 🤷](#WhyAreWeDoingThis?) 
* [Features 🎁](#Features) 
* [Screenshots 🖼](#Screenshots) 
* [Installation 🛠](#Installation) 
* [Usage 🧩](#Usage) 
* [Sprint 1 🏃](#Sprint1) 


## The Team 🤝

🥰`Ethan Reed`🥰

🐈`Melanie Garza`🐈

🏈`Cameron Chalupa`🏈

🙈`Cruz Lopez`🙈

😹`Zoe Becker`😹

## What We're Creating 🧰
We're creating a competitive word search web app.

## Technologies Used 🧑‍💻
- [PHP](https://www.php.net/) 
- [Python](https://www.python.org/) 
- [HTML](https://developer.mozilla.org/en-US/docs/Web/HTML) 
- [CSS](https://developer.mozilla.org/en-US/docs/Web/CSS) 
- [Javascript](https://developer.mozilla.org/en-US/docs/Web/JavaScript) 
- Forked from: https://github.com/joshbduncan/word-search-generator 

## Who Are We Doing This For? 🫵
We're doing this for casual fans of word searches who want a competitive experience.

## Why Are We Doing This? 🤷
We're doing this to bring people together in fun, safe, competitive environment.

## Features 🎁
List the ready features here:
- [Wordsearch - Give the user the ablitity to play wordsearch against a friend. 🧩](https://cs3398f23gorns1.atlassian.net/browse/SCRUM-10) 

- [Leader board- Keeps score and updates for solo or head-to-head play. 🥇🥈🥉](https://cs3398f23gorns1.atlassian.net/browse/SCRUM-6) 

- [Color themes- The ability to customize the themes on the webpage. 🧑‍🎨](https://cs3398f23gorns1.atlassian.net/browse/SCRUM-9) 

- [Word Themes - The ability to chose from different word search themes. 📚](https://cs3398f23gorns1.atlassian.net/browse/SCRUM-7) 

- [Play by Play updates ⚔](https://cs3398f23gorns1.atlassian.net/browse/SCRUM-8) 


## Screenshots 🖼
![Alt text](image.png)


## Installation 🛠

Install Word-Search-Generator with pip:

$ pip install word-search-generator

## Usage 🧩

Just import the WordSearch class from the package, supply it with a list of words and you're set. 🧩

>>> from word_search_generator import WordSearch
>>> puzzle = WordSearch("dog, cat, pig, horse, donkey, turtle, goat, sheep")

## Sprint 1 🏃  (September 25 - October 6th)

## Contributions
- **Ethan**: "Added deployment scripts to deploy to webserver. Connected python generator to main PHP/JS stack. Implemented backend framework for the game timer."
	- `Jira Task SCRUM-50: Get result from python word-search-generator in PHP`
        - Jira link: https://cs3398f23gorns1.atlassian.net/browse/SCRUM-50
		- reference: https://bitbucket.org/cs3398f23gorns/word-search-generator/commits/545087a9475c636d8e59012a63342c6033558614
	- `Jira Task SCRUM-25: Create cron jobs for deployment server for instance cleanup`
        - Jira link: https://cs3398f23gorns1.atlassian.net/browse/SCRUM-25
		- reference: https://bitbucket.org/cs3398f23gorns/word-search-generator/commits/dc776f0ca5272f6856962d85ec21f275e7afbd97 
	- `Jira Task-24: Get rid of direct gamefile access in favor of server request for game data`
        - Jira link: https://cs3398f23gorns1.atlassian.net/browse/SCRUM-24
		- reference: https://bitbucket.org/cs3398f23gorns/word-search-generator/commits/d50145e61bbf156296b669d440f304bd86d053e1
	- `Jira Task-69: Start button in Home page (front-end) & (backend)`
        - Jira link: https://cs3398f23gorns1.atlassian.net/browse/SCRUM-69
		- reference: https://bitbucket.org/cs3398f23gorns/word-search-generator/commits/7c2202e8afe195179870ecafc895c7bc5b6e80b1 
	- `Jira Task-49: Configure word-search-generator to return JSON`
        - Jira link: https://cs3398f23gorns1.atlassian.net/browse/SCRUM-49
		- reference: https://bitbucket.org/cs3398f23gorns/word-search-generator/commits/edd3b69a72a408492aee1a9d3375029abb83b395
	- `Jira Task-64: Backend timer implementation`
        - Jira link: https://cs3398f23gorns1.atlassian.net/browse/SCRUM-64
		- reference: https://bitbucket.org/cs3398f23gorns/word-search-generator/commits/3c953f485fd9d68e1e98c30750196551efef0475  
<br />

- **Zoe**: "Created grid for wordsearch and parsed letters from JSON to fill grid. Worked on some HTML styling and added hover functionality for grid. Created Leaderboard button on homepage"
	- `Jira Task SCRUM-22: Add buttons/links to allow users to view the leader board from the game's main page.`
        - Jira link: https://cs3398f23gorns1.atlassian.net/browse/SCRUM-22
		- reference: https://bitbucket.org/cs3398f23gorns/word-search-generator/commits/c59d21ae3bfd228fb4bcd6a764dc82490baa1dbe
	- `Jira Task SCRUM-27: Style the game board and other UI elements with CSS for a pleasing user experience.`
        - Jira link: https://cs3398f23gorns1.atlassian.net/browse/SCRUM-27
		- reference: https://bitbucket.org/cs3398f23gorns/word-search-generator/commits/ebca6e0e7fd81b799e4aa83e82a76824d6b22a2c
	- `Jira Task-28: Design the game board layout in HTML & Jira Task 55: Parse letters from JSON on client`
        - Jira link: https://cs3398f23gorns1.atlassian.net/browse/SCRUM-28
		- reference: https://bitbucket.org/cs3398f23gorns/word-search-generator/commits/e05818188bad77403692e9bd5eff27ca4f493508
	- `Jira Task-78: More css for wordsearch board (add color)`
        - Jira link: https://cs3398f23gorns1.atlassian.net/browse/SCRUM-78
		- reference: https://bitbucket.org/cs3398f23gorns/word-search-generator/commits/e5a2c905ac05aff678fce2980ad6b8833e3c9a11
<br />

- **Melanie**: "Created the Homepage for wordsearch. Worked on a javascript feature to highlight words when selected from the word bank. Created a default word dictionary and then connected that dictionary to JSON generation."
    - 'Jira Task SCRUM-26: Enable users to select letters on the grid by clicking or dragging.'
        Jira Link: https://cs3398f23gorns1.atlassian.net/jira/software/projects/SCRUM/issues/SCRUM-26
        reference: https://bitbucket.org/cs3398f23gorns/%7B75862101-8368-4c3e-bcf6-7f917ad74bfb%7D/commits/36f74a4c58cb33e31a7c95adf2478578d3832bf9

    - 'Jira Task SCRUM-66: Create default word dictionary.'
        Jira Link: https://cs3398f23gorns1.atlassian.net/jira/software/projects/SCRUM/issues/SCRUM-66
        reference: https://bitbucket.org/cs3398f23gorns/%7B75862101-8368-4c3e-bcf6-7f917ad74bfb%7D/commits/6a7481053729b7b8ed385e210e5b9f93b2783248

    - 'Jira Task SCRUM-67: Connect Word Dictionary to initial JSON generation.'
        Jira Link: https://cs3398f23gorns1.atlassian.net/jira/software/projects/SCRUM/issues/SCRUM-67
        reference: https://bitbucket.org/cs3398f23gorns/%7B75862101-8368-4c3e-bcf6-7f917ad74bfb%7D/commits/d63ff99f5614bbfd61339ac99be0281abe8d67c2

    - 'Jira Task SCRUM-26: Home Page (HTML/CSS).'
        Jira Link: https://cs3398f23gorns1.atlassian.net/jira/software/projects/SCRUM/issues/SCRUM-68
        reference: https://bitbucket.org/cs3398f23gorns/%7B75862101-8368-4c3e-bcf6-7f917ad74bfb%7D/commits/90fe3b1aeab9de6de390a49e52a35b838284afbd

<br />