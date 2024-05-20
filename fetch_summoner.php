<?php /** @noinspection ALL */
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = htmlspecialchars($_POST['summonerName']); // Get summoner name from the user
    $tag = htmlspecialchars($_POST['summonerTag']); // Get tag from the user
    $apiKey = 'RGAPI-2795daa5-09f9-4e82-a6e3-f68be8b03ef6'; //  Riot Games API key
    $region = 'europe'; // Change this to the appropriate region

    require_once 'API_Calls.php';
    $API_Connection = new API_Calls();
    $data = $API_Connection->Account_V1($region, $name, $tag, $apiKey); // return values puuid, gameName,tagLine
    $data_summoner_v4 = $API_Connection->Summoner_V4($data['puuid'], $apiKey); // return values profileIconId, revisionDate, summonerLevel, profileIconId
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $data['gameName'] . " - Profile"; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style-info.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>

<body>

<div class="container">
    <?php
    echo
    "
        <div class='top-right-container'>
            <div class='summoner-icon-container'>
                <img class='summoner-icon' src='profileicon/{$data_summoner_v4['profileIconId']}.png' alt='summoner profile image'>
                <div class='summoner-lvl'>{$data_summoner_v4['summonerLevel']}</div>
            </div>
            <div class='summoner-name-container'>{$data['gameName']}#{$data['tagLine']}</div>
        </div>
    ";
    ?>
</div>

<div class="footer">© Designed by <a href="https://github.com/TeatrumMundi" class="footer-link">TeatrumMundi</a></div>
</body>

