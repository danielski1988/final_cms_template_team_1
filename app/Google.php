<?php
namespace App;

class Google
{    
    public function client()
    {
        $client = new \Google_Client();
        $client->setClientId("689272791357-ksptt0nos02kbn38cgpcp3upha79or6u.apps.googleusercontent.com");
        $client->setClientSecret("UhwBWEp_ehm5Nux76vFG-tm_");
        $client->setRedirectUri("http://cms.com/login");
        $client->setScopes(explode(',', "email,profile,https://www.googleapis.com/auth/calendar"));
        $client->setApprovalPrompt("auto");
        $client->setAccessType("offline");
        return $client;
    }
}