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
    public function Account_V1($region, $name, $tag, $apiKey) // Returns PUUID, TAG, GameName
    {
        $url = "https://$region.api.riotgames.com/riot/account/v1/accounts/by-riot-id/$name/$tag?api_key=$apiKey";
        return $data = json_decode($this->curl($url), true);
    }
    public function Summoner_V4($puuid, $apiKey)
    {
        $url = "https://eun1.api.riotgames.com/lol/summoner/v4/summoners/by-puuid/$puuid?api_key=$apiKey";
        return $data = json_decode($this->curl($url), true); // PUUID, TAG, GameName
    }
}