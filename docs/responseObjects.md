# Response objects that are returned by backend scripts:
### PuzzleStructure object
- puzzle, words, expireTime, foundWords, theme, and players keys from puzzle.json above
    - NOTE: player objects in the players list only contain name, score, and isHost keys
### PuzzleState object
- ended: whether the game timer is up (true/false)
- foundWords, and players keys from puzzle.json above
    - NOTE: player objects are sanitized the same way as above
### LobbyData object
- players and gameLink keys from lobbyData.json above
    - NOTE: player objects are sanitized the same way as in PuzzleStructure
### SetNameResponse object
- accessToken: access token of the newly created player
- isHost: true if the player is the host, false otherwise
- themes (only present if isHost is true): array of available themes