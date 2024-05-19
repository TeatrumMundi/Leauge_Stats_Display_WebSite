<!DOCTYPE html>
<html lang="pl">
<head>
    <title>League of Legends - Match History</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>

<body>

<div class="container">
    <form id="search-form" action="fetch_summoner.php" method="POST">
        <img src="IMG/logo.png" alt="Logo" class="logo">
        <div class="search">
            <span class="search-icon material-symbols-outlined">search</span>
            <label>
                <input class="search-input" type="search" placeholder="Game name + #TAG" id="search-input" name="summonerName">
            </label>
        </div>
    </form>
</div>
<div class="footer">© Designed by <a href="https://github.com/TeatrumMundi" class="footer-link">TeatrumMundi</a></div>

</body>
</html>
