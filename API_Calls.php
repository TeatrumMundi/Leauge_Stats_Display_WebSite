<?php

class API_Calls
{
    function curl($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Sets a cURL option to return the result of curl_exec as a string
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); // request body is in JSON format

        if (curl_errno($ch))
        {
            echo "Failed to fetch account information. Please try again. Error: " . curl_error($ch);
            curl_close($ch);
            exit;
        }
        else
        {
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }

    }
    public function Region_Select($server)
    {
        if ($server == 'NA1' || $server == 'BR1' || $server == 'LA1' || $server == 'LA2')
        {
            return "Americas";
        } elseif ($server == 'KR' || $server == 'JP1' || $server == 'SG2' || $server == 'PH2' || $server == 'TW2' || $server == 'VN2' || $server == 'TH2' || $server == 'OC1')
        {
            return "Asia";
        } elseif ($server == 'EUW1' || $server == 'EUN1' || $server == 'RU' || $server == 'TR1')
        {
            return "Europe";
        } else
        {
           return "Unknown";
        }

    }
    public function Account_V1($region, $name, $tag, $apiKey) // Returns PUUID, TAG, GameName
    {
        $name = trim($name); // Delete whit signs
        $name = str_replace(' ', '%20', $name); // Replace space with %20
        $tag = str_replace('#', '', $tag);
        $url = "https://$region.api.riotgames.com/riot/account/v1/accounts/by-riot-id/$name/$tag?api_key=$apiKey";
        return json_decode($this->curl($url), true);
    }
    public function Summoner_V4($puuid, $apiKey, $server)
    {
        $url = "https://$server.api.riotgames.com/lol/summoner/v4/summoners/by-puuid/$puuid?api_key=$apiKey";
        return json_decode($this->curl($url), true); // PUUID, TAG, GameName
    }
    public function CHAMPION_MASTERY_V4_TOP($puuid,$number, $apiKey, $server)
    {
        $url = "https://$server.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-puuid/$puuid/top?count=$number&api_key=$apiKey";
        return json_decode($this->curl($url), true); // PUUID, TAG, GameName
    }
    public function getChampionNameById($championId, $game_version)
    {
        $filePath = str_replace("version", $game_version, 'dragontail-version\version\data\en_US\champion.json');
        //Check if file exist
        if (!file_exists($filePath)) {
            die("File $filePath do not exist.");
        }
        // Loading and decoding JSON file
        $json = file_get_contents($filePath);
        $championsData = json_decode($json, true);
        // Checking decoding success
        if ($championsData === null) {
            die("Failed to decode $filePath.");
        }
        // Creating ID map to champion ID
        $championIdToName = [];
        foreach ($championsData['data'] as $value) {
            $championIdToName[intval($value['key'])] = $value['name'];
        }
        // Return champion id
        return isset($championIdToName[$championId]) ? $championIdToName[$championId] : "Unknown championId";
    }
    public function getChampionSkinCount($championName, $game_version)
    {
        $filePath = str_replace("version", $game_version, 'dragontail-version\version\data\en_US\championFull.json');
        if (!file_exists($filePath))
        {
            die("File $filePath does not exist.");
        }
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            die("Failed to decode JSON: " . json_last_error_msg());
        }
        if (!isset($data['data']) || !is_array($data['data'])) {
            die("Invalid data structure in JSON file.");
        }
        foreach ($data['data'] as $champion) {
            if (strtolower($champion['name']) === strtolower($championName)) {
                if (!isset($champion['skins']) || !is_array($champion['skins'])) {
                    die("Skins data missing or invalid for champion: " . $championName);
                }
                $skins = $champion['skins'];
                $randomSkin = $skins[array_rand($skins)];
                return $randomSkin['num'];
            }
        }
        return 0;
    }
}