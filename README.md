Agreable Instant Articles Plugin
===============

### Permissions

use this link prefiling it with stylist app details. 

`https://www.facebook.com/v2.10/dialog/oauth?client_id=197508346942509&redirect_uri=http://local.shortlist.com/fake&scope=pages_manage_instant_articles,pages_show_list`

After redirect grab user secret (client secret) and get access token from json using this link:

`https://graph.facebook.com/v2.10/oauth/access_token?client_id=197508346942509&redirect_uri=http://shortlist.dev/fake&client_secret={user_secret}`

Generate long lived access token

`https://graph.facebook.com/v2.8/oauth/access_token?grant_type=fb_exchange_token&client_id=197508346942509&client_secret={app_secret}&fb_exchange_token={short_lived_token}`

### adding new outlets

To add another outlet you need to implement new class implementing outletinterface and then add it to `register.php`. 
