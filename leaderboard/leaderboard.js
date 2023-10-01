// Function to fetch current top scores from top_scores.json
async function fetchTopScores() {
    const response = await fetch('top_scores.json');
    const data = await response.json();
    return data.topPlayers;
  }
  
// Function to update the leaderboard with a new player's score and date
async function updateLeaderboard(playerName, playerScore, playerDate) {
    const topPlayers = await fetchTopScores();
  
    // Add the new player to the topPlayers array
    topPlayers.push({ name: playerName, score: playerScore, date: playerDate });
  
    // Sort the topPlayers array in descending order of scores
    topPlayers.sort((a, b) => b.score - a.score);
  
    // Keep only the top 5 players
    topPlayers.splice(5);
  
    // Save the updated topPlayers array back to top_scores.json
    const updatedData = { topPlayers };
    const updatedDataString = JSON.stringify(updatedData, null, 2);
    
    // Send a PUT request to update the file
    await fetch('top_scores.json', {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: updatedDataString,
    });
  }
  function addHighlightHoverBehavior() {
    // Get all elements with the 'highlight-hover' class
    const highlightElements = document.querySelectorAll('.highlight-hover');

    // Add event listeners for mouseover and mouseout
    highlightElements.forEach((element) => {
        element.addEventListener('mouseover', () => {
            // Add a CSS class to highlight the boxes on hover
            element.classList.add('highlighted');
        });

        element.addEventListener('mouseout', () => {
            // Remove the CSS class to remove the highlight when the hover state ends
            element.classList.remove('highlighted');
        });
    });
}

// Call the function to add "highlight-hover" behavior after the DOM has loaded
document.addEventListener('DOMContentLoaded', () => {
    addHighlightHoverBehavior();
});