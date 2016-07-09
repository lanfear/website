<?php
App::import('Vendor', 'OAuthGoogle/autoload');

class AuthService {
    
    const CLIENT_ID = '13718315395-icdjrdg6le5nlealmmf95q388l1suivq.apps.googleusercontent.com';
    const CLIENT_SECRET = 'N5J397slxU-NzUo1nEY7gA5i';
    private $redirect_uri;
    private $client;
    private $logout_uri;
    
    public $authInfo = null;

    function __construct() {
        $this->redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/cake/api/pages/auth';
        $this->logout_uri = "{$this->redirect_uri}?logout";
        $this->client = new Google_Client();
        $this->client->setClientId(self::CLIENT_ID);
        $this->client->setClientSecret(self::CLIENT_SECRET);
        $this->client->setRedirectUri($this->redirect_uri);
        $this->client->setScopes('profile');
    }

    public function Logout() {
        /************************************************
          If we're logging out we just need to clear our
          local access token in this case
         ************************************************/
        unset($_SESSION['access_token']);
    }
    
    public function Authenticate() {
        /************************************************
          If we have a code back from the OAuth 2.0 flow,
          we need to exchange that with the authenticate()
          function. We store the resultant access token
          bundle in the session, and redirect to ourself.
         ************************************************/
        if (isset($_GET['code'])) {
          $this->client->authenticate($_GET['code']);
          $_SESSION['access_token'] = $this->client->getAccessToken();
          $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
          header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }
    }
    
    public function CheckLogin() {
        /************************************************
          If we have an access token, we can make
          requests, else we generate an authentication URL.
         ************************************************/
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            
            /************************************************
              If we're signed in we can go ahead and retrieve
              the ID token, which is part of the bundle of
              data that is exchange in the authenticate step
              - we only need to do a network call if we have
              to retrieve the Google certificate to verify it,
              and that can be cached.
             ************************************************/
            if ($_SESSION['access_token'] = $this->client->getAccessToken()) {
                $this->authInfo = $this->client->verifyIdToken()->getAttributes();
                return true;
            }
        }
        
        return false;
    }
    
    public function IsAuthorized() {
        if ($this->client->getAccessToken() && $this->authInfo === null) {
            if ($this->client->isAccessTokenExpired()) {
                var_dump('REFRESHING TOKEN!!');
                $this->client->refreshToken($this->client->getRefreshToken());
            }
            $this->authInfo = $this->client->verifyIdToken()->getAttributes();
        }
        return $this->authInfo;
    }
    
    public function GetAuthUrl() {
        return $this->client->createAuthUrl();        
    }
    
    public function GetLogoutUrl() {
        return $this->logout_uri;
    }
    
    private function RenewToken() {
        
    }
    
}

