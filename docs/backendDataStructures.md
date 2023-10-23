# Format of the various backend data structures

## Word search instance game file (puzzle.json)
- puzzle: NxN array of letters, organized by row, where N is the size of the grid
- key: dictionary of all words mapped to solution objects
    - solution object: 
        - start_row: row of the first letter of the solution
        - start_col: column of the first letter of the solution
        - direction: direction (N,E,S,W,NE,NW,SE,SW) that the solution goes in
        - secret: unused
- expireTime: UTC timestamp (seconds) of when the game ends
- instanceExpiration: UTC timestamp of when the instance is eligible to be deleted from the server
- foundWords: dictionary of words found so far mapped to the name of the player that found it
## Lobby instance file (lobbyData.json)
- instanceExpiration: UTC timestamp of when the instance is eligible to be deleted from the server
- Players: array of player objects representing the players in that lobby
    - player object:
        - name: name of the player
        - accessToken: access token for that player
        - boardRetrieved: whether or not the player has retrieved the game board from the server
        - isHost: whether or not the player is the host
        - score: score for this player