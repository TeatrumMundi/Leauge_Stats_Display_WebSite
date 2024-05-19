<?php /** @noinspection ALL */
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $summonerName = htmlspecialchars($_POST['summonerName']); // Get summoner name from the user
    list($name, $tag) = explode('#', $summonerName); // Split name and tag
    $name = rawurlencode($name);
    $tag = rawurlencode($tag);

    $apiKey = 'RGAPI-0cc8a946-ba54-4a2e-bb75-043e9c8c5c3e'; //  Riot Games API key
    $region = 'europe'; // Change this to the appropriate region

    require_once 'API_Calls.php';
    $API_Connection = new API_Calls();
    $data = $API_Connection->Account_V1($region, $name, $tag, $apiKey);
    $data_summoner_v4 = $API_Connection->Summoner_V4($data['puuid'], $apiKey);

    echo
    "
        <h2>Account Information</h2>
        <p>Summoner PUUID: {$data_summoner_v4['profileIconId']}</p>
        <p>Summoner Name: {$data_summoner_v4['revisionDate']}</p>
        <p>Summoner TagLine: {$data_summoner_v4['summonerLevel']}</p>
        <img src='profileicon/{$data_summoner_v4['profileIconId']}.png' alt='Obrazek' />
    ";
}
?>
<!DOCTYPE html>
<html lang="pl">
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
        <h2>Account Information</h2>
        <p>Summoner PUUID: {$data['puuid']}</p>
        <p>Summoner Name: {$data['gameName']}</p>
        <p>Summoner TagLine: {$data['tagLine']}</p>
    ";
    ?>
</div>
<div class="footer">© Designed by <a href="https://github.com/TeatrumMundi" class="footer-link">TeatrumMundi</a></div>



</body>

