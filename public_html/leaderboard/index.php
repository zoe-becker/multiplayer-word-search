<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://unpkg.com/htmx.org@1.9.8" integrity="sha384-rgjA7mptc2ETQqXoYC3/zJvkU7K/aP44Y+z7xQuJiVnB/422P/Ak+F/AqFR7E4Wr" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/hyperscript.org@0.9.12"></script>
</head>
<body>
    <nav> 
        <ul> 
            <li><a href="../home"> 
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"/></svg>
                Home</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="leaderboard">
            <h1>Leaderboards</h1>
        </div>
        <!-- HTMX Tabs for Leaderboards -->
        <div id="leaderboard-tabs" hx-target="#leaderboard-content" role="tablist" _="on htmx:afterOnLoad set @aria-selected of <[aria-selected=true]/> to false tell the target take .selected set @aria-selected to true">
            <button role="tab" aria-controls="leaderboard-content" aria-selected="true" hx-get="leaderboard.php?theme=all-time" class=selected>All-Time</button>
            <button role="tab" aria-controls="leaderboard-content" aria-selected="false" hx-get="leaderboard.php?theme=animals">Animals</button>
            <button role="tab" aria-controls="leaderboard-content" aria-selected="false" hx-get="leaderboard.php?theme=christmas">Christmas</button>
            <button role="tab" aria-controls="leaderboard-content" aria-selected="false" hx-get="leaderboard.php?theme=halloween">Halloween</button>
            <button role="tab" aria-controls="leaderboard-content" aria-selected="false" hx-get="leaderboard.php?theme=nicki">Nicki</button>
            <button role="tab" aria-controls="leaderboard-content" aria-selected="false" hx-get="leaderboard.php?theme=valentine">Valentine's</button>
            <button role="tab" aria-controls="leaderboard-content" aria-selected="false" hx-get="leaderboard.php?theme=thanksgiving">Thanksgiving</button>
            <!-- Add more tabs as needed -->
            
        </div>
        <div class="tabsShadow"></div>
            <div class="glider"></div>
        <div class="scores-container">
            <div id="leaderboard-content" role="tabpanel" hx-get="leaderboard.php?theme=all-time" hx-trigger="load">
        <!-- Leaderboard content will be loaded here -->
        
        </div>
    </div>

        
</body>
</html>