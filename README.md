# Get the Playtime of Multiple Steam Accounts in Multiple Games
It does just what the title says it does. Use it to get the total playtime of multiple people in multiple games, and returns a single number, representing everyone's total playtime in minutes. A simple script I put together for my own site, thought I would share.

### How to use
Download and place the PHP file on your site. Then, just access it like you normally would. You can run the code in either GET or POST, but formatting arrays in GET is hard, so POST is recommended. You must send three things in the payload:
1. `"key"` - Your Steam API key (you can get one from [here](https://steamcommunity.com/dev/apikey))
2. `"users"` - Array of users' Steam IDs you want to check (you can find their IDs [here](https://steamid.io/lookup))
3.  `"games"` - Array of AppIDs (games) you want to check (you can find a game's ID [here](https://steamdb.info/))

Send this data through, and you should receive an `Integer` in return, representing the TOTAL playtime in minutes. If you're having trouble, reference my example.
