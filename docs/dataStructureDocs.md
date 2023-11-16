# Format of the various backend data structures
### Word search instance game file (puzzle.json)
- puzzle: NxN array of letters, organized by row, where N is the size of the grid
- words: array of all the words in the puzzle
- key: dictionary of all words mapped to solution objects
    - solution object: 
        - start_row: row of the first letter of the solution
        - start_col: column of the first letter of the solution
        - direction: direction (N,E,S,W,NE,NW,SE,SW) that the solution goes in
        - secret: unused
- startTime: UTC timestamp (seconds) of when the game starts
- expireTime: UTC timestamp (seconds) of when the game ends
- ended: whether the game has ended (either by timer expiration or all words found)
- instanceExpiration: UTC timestamp of when the instance is eligible to be deleted from the server
- foundWords: dictionary of words found so far mapped to foundWord objects
    - foundWord object
        - start_row: row of the first letter of the solution
        - start_col: column of the first letter of the solution
        - direction: direction of the word
        - name: person that found this word
- players: array of player objects representing the players in that lobby
    - player object:
        - name: name of the player
        - accessToken: access token for that player
        - boardRetrieved: whether or not the player has retrieved the game board from the server
        - isHost: whether or not the player is the host
        - score: score for this player
- dbUpdated: whether the database has been updated with data from this game (true/false)
- theme: themeData object for the theme that was chosen in the lobby phase
    - NOTE: does not contain the words key

### ThemeData object
- words: array of possible words that can be in the wordlist for the theme
- backgroundImage: background image name
    - NOTE: not full path, use a global variable for the themeAssets directory
- video (optional): background video
    - NOTE not full path, use a global variable for the themeAssets directory
### Lobby instance file (lobbyData.json)
- instanceExpiration: UTC timestamp of when the instance is eligible to be deleted from the server
- players: same as players in puzzle.json
- gameLink: false if game not started, otherwise the relative path from the lobby instance to the game instance
- theme: currently selected theme (in string form)

# Response objects that are returned by backend scripts:
### PuzzleStructure object
- puzzle, words, startTime, expireTime, foundWords, theme, and players keys from puzzle.json above
    - NOTE: player objects in the players list only contain name, score, and isHost keys

- puzzle: NxN array of letters, organized by row, where N is the size of the grid
- words: array of all the words in the puzzle
- startTime: UTC timestamp (seconds) of when the game starts
- expireTime: UTC timestamp (seconds) of when the game ends
- foundWords: dictionary of words found so far mapped to foundWord objects
    - foundWord object:
        - start_row: row of the first letter of the solution
        - start_col: column of the first letter of the solution
        - direction: direction of the word
        - name: person that found this word
- theme: themeData object (see backendDataStructures for details) for the theme that was chosen in the lobby phase
    - NOTE: does not contain the words key
- players: array of player objects (see backendDataStructures for details) representing the players in that lobby
    - NOTE: player objects in the players list only contain name, score, and isHost keys
- gameMode: game mode will either be timeAttack or multiplayer
- themeName: name of theme is taken LobbyData object
### PuzzleState object
- expired: whether the game timer is up (true/false)
- foundWords: dictionary of words found so far mapped to foundWord objects
- players: array of player objects (see puzzle.json for details) representing the players in that lobby
    - NOTE: player objects in the players list only contain name, score, and isHost keys
### LobbyData object
- players: array of player objects (see puzzle.json for details) representing the players in that lobby
    - NOTE: player objects in the players list only contain name, score, and isHost keys
- gameLink: false if game not started, otherwise the relative path from the lobby instance to the game instance
- theme: currently selected theme (in string form)
### SetNameResponse object
- accessToken: access token of the newly created player
- isHost: true if the player is the host, false otherwise
- themes (only present if isHost is true): array of available themes
# Frontend data structures that backend may expect:
### WordInfo object
- startRow: row number (from 0) of the beginning of the word
- startCol: column number (from 0) of the beginning of the word
- direction: direction of the word (N, E, S, W, NE, SE, NW, SW)
- word: word that was found
