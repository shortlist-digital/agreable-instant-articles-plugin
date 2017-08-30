Agreable Instant Articles Plugin
===============

### Permissions

use this link prefiling it with stylist app details. 

`https://www.facebook.com/v2.10/dialog/oauth?client_id={app_id}&redirect_uri=http://shortlist.dev/fake&scope=pages_manage_instant_articles,pages_show_list`

After redirect grab user secret (client secret) and get access token from json using this link:

`https://graph.facebook.com/v2.10/oauth/access_token?client_id={app_id}&redirect_uri=http://shortlist.dev/fake&client_secret={user_secret}`

### adding new outlets

To add another outlet you need to implement new class implementing outletinterface and then add it to `register.php`. 
