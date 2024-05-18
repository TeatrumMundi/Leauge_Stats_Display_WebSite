document.getElementById('search-form').addEventListener('submit', function(event)
{
    event.preventDefault();
    let summonerName = document.getElementById('search-input').value;
    fetchSummonerData(summonerName);
});

async function fetchSummonerData(summonerName)
{
    const apiKey = 'RGAPI-0cc8a946-ba54-4a2e-bb75-043e9c8c5c3e';
    const summonerUrl = `https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/${summonerName}?api_key=${apiKey}`;

    try
    {
        let response = await fetch(summonerUrl);
        if (!response.ok)
        {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        let data = await response.json();
        displaySummonerData(data);
    } catch (error)
    {
        console.error('Fetch error: ', error);
    }
}

function displaySummonerData(data)
{
    // Display the summoner data on the page
    console.log(data);
    // For example, you can add the summoner's name and level to the page
    let container = document.querySelector('.container');
    let summonerInfo = document.createElement('div');
    summonerInfo.innerHTML = `<h2>Summoner Name: ${data.name}</h2><p>Level: ${data.summonerLevel}</p>`;
    container.appendChild(summonerInfo);
}