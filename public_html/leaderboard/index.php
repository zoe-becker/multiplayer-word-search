<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://unpkg.com/htmx.org@1.9.8" integrity="sha384-rgjA7mptc2ETQqXoYC3/zJvkU7K/aP44Y+z7xQuJiVnB/422P/Ak+F/AqFR7E4Wr" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/hyperscript.org@0.9.12"></script>
</head>
<body>
    <nav> 
        <ul> 
            <li><a href="../home"><i class="fa fa-home"></i>Home</a></li>
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