<?php /** @noinspection ALL */
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $config = parse_ini_file('config.ini');
    $game_version = $config['gameVersion'];
    $apiKey = $config['apiKey']; //  Riot Games API key
    $summoner_Nick = htmlspecialchars($_POST['summonerName'], ENT_QUOTES, 'UTF-8'); // Get player nick
    $tag = htmlspecialchars($_POST['summonerTag'], ENT_QUOTES, 'UTF-8');
    $server = htmlspecialchars($_POST['region'], ENT_QUOTES, 'UTF-8');

    require_once 'API_Calls.php';
    $API_Connection = new API_Calls();

    $region = $API_Connection->Region_Select($server);
    $data = $API_Connection->Account_V1($region, $summoner_Nick, $tag, $apiKey);
    if ($data)
    {
        $puuid = $data['puuid'];
        $data_summoner_v4 = $API_Connection->Summoner_V4($puuid, $apiKey, $server);
        $top_champion_ids = $API_Connection->CHAMPION_MASTERY_V4_TOP($puuid, 20, $apiKey, $server);

        $top_acc_mastery_names = array_map(function($champion) use ($API_Connection, $game_version)
        {
            return $API_Connection->getChampionNameById($champion['championId'], $game_version);
        }, $top_champion_ids);
        $random_bg_number = $API_Connection->getChampionSkinCount($top_acc_mastery_names[0], $game_version);
        $match_history_IDs = $API_Connection->MATCH_V5_BY_PUUID($puuid, $apiKey, $region, 20);
        $match_details = $API_Connection->MATCH_V5_BY_ID($puuid, $apiKey, $region, $match_history_IDs[0]);

        $random_bg = sprintf('../dragontail-%s/img/champion/splash/%s_%d.jpg',
            $game_version,
            $top_acc_mastery_names[0],
            $random_bg_number
        );
    } else {echo "Failed to load data.";}}?>
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
<div class='main-container' ID="bg_box">
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
        <div class='info-container'>
            <div class='info-box'>
                <div class='info-box-icon'>
                    <img class='info-summoner-icon' src='dragontail-{$game_version}/{$game_version}/img/profileicon/{$data_summoner_v4['profileIconId']}.png' alt='summoner profile image'>
                    <div class='info-summoner-lvl'>{$data_summoner_v4['summonerLevel']}</div>
                </div>
                <div class='info-summoner-main'>
                    <p>{$data['gameName']}#{$data['tagLine']}</p>
                </div>
                <div class='info-rank-solo-duo'>
                </div>
            </div>
            <div class='info-box'>
        
            </div>
        </div>
    ";
    ?>
</div>
<div class="footer">© Designed by <a href="https://github.com/TeatrumMundi" class="footer-link">TeatrumMundi</a></div>
<script src="JS/select_color.js"></script>
<script>
    window.onload = function ()
    {
        const container = document.querySelector('#bg_box');
        container.style.backgroundImage = 'linear-gradient(rgba(9, 0, 77, 0.65), rgba(9, 0, 77, 0.65)), url("<?php echo $random_bg; ?>")';
    };
</script>
</body>

