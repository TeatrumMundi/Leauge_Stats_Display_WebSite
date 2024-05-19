<?php /** @noinspection ALL */
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $summonerName = htmlspecialchars($_POST['summonerName']); // Get summoner name from the user
    list($name, $tag) = explode('#', $summonerName); // Split name and tag
    $name = rawurlencode($name);
    $tag = rawurlencode($tag);

    $apiKey = 'place-holder'; //  Riot Games API key
    $region = 'europe'; // Change this to the appropriate region

    if (empty($summonerName))
    {
        echo "Please enter a summoner name.";
        exit;
    }

    $url = "https://$region.api.riotgames.com/riot/account/v1/accounts/by-riot-id/$name/$tag?api_key=$apiKey";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    if (curl_errno($ch))
    {
        echo "Failed to fetch account information. Please try again. Error: " . curl_error($ch);
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    $data = json_decode($response, true);
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <title>League of Legends - Match History</title>
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

