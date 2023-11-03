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