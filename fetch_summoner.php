<?php /** @noinspection ALL */
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $game_version = '14.10.1';
    $random_bg_number = rand(0,1);

    $name = htmlspecialchars($_POST['summonerName']); // Get player nick
    $tag = htmlspecialchars($_POST['summonerTag']); // Get player tag
    $server = htmlspecialchars($_POST['region']); // Get player region
    $apiKey = 'RGAPI-bf199cbf-7e78-4883-aeee-44eb01b256b7'; //  Riot Games API key

    require_once 'API_Calls.php';
    $API_Connection = new API_Calls();
    $region = $API_Connection->Region_Select($server); // return region based on server
    $data = $API_Connection->Account_V1($region, $name, $tag, $apiKey); // return values puuid, gameName,tagLine
    $data_summoner_v4 = $API_Connection->Summoner_V4($data['puuid'], $apiKey, $server); // return values profileIconId, revisionDate, summonerLevel, profileIconId
    $top_champion_id = $API_Connection->CHAMPION_MASTERY_V4_TOP($data['puuid'], $apiKey, $server);
    $top_champion_name = $API_Connection->getChampionNameById($top_champion_id[0]['championId'], $game_version);

    $random_bg = 'dragontail-' . $game_version . '\\img\\champion\\splash\\' . $top_champion_name . '_' . $random_bg_number . '.jpg';
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $data['gameName'] . " - Profile"; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/style-info.css">
    <link rel="stylesheet" href="CSS/style_info_search_box.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

</head>


<body>
<div class='container'>
    <form id="search-form" action="fetch_summoner.php" method="POST">
        <div class="search">
            <span class="search-icon material-symbols-outlined">search</span>
            <label>
                <input class="search-input" autocomplete="off" spellcheck="false" type="text" placeholder="Game name" id="name-input" name="summonerName" required>
            </label>
            <span class="divider">|</span>
            <label>
                <input class="search-input" autocomplete="off" spellcheck="false" type="text" placeholder="#TAG" id="tag-input" name="summonerTag" required>
            </label>
            <span class="divider">|</span>
            <label>
                <select class="search-select" name="region" id="region-select" required>
                    <option value="" disabled selected>Select Region</option>
                    <option value="NA1">North America</option>
                    <option value="EUW1">Europe West</option>
                    <option value="EUN1">Europe Nordic & East</option>
                    <option value="OC1">Oceania</option>
                    <option value="KR">Korea</option>
                    <option value="JP1">Japan</option>
                    <option value="BR1">Brazil</option>
                    <option value="LA2">LAS</option>
                    <option value="LA1">LAN</option>
                    <option value="RU">Russia</option>
                    <option value="TR1">Turkey</option>
                    <option value="SG2">Singapore</option>
                    <option value="PH2">Philippines</option>
                    <option value="TW2">Taiwan</option>
                    <option value="VN2">Vietnam</option>
                    <option value="TH2">Thailand</option>
                </select>
            </label>
            <span class="divider">|</span>
            <input class="search-button" type="submit" value="Search" />
        </div>
    </form>
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

<script src="select_color.js"></script>
</body>

