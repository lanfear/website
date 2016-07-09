<?php

App::uses('AppController', 'Controller');

App::import('Vendor', 'OAuthGoogle/autoload');

class AuthController extends AppController {
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
//include_once "templates/base.php";
//require_once realpath(dirname(__FILE__) . '/../autoload.php');

/************************************************
  ATTENTION: Fill in these values! Make sure
  the redirect URI is to this page, e.g:
  http://localhost:8080/user-example.php
 ************************************************/
    public function index() {

    }
}

?>
<?php
/*    
    public function index() {
        $client = $this->createClient();
        $tokenParameters = [
            "response_type" => "code",
            "scope" => "profile",
            "client_id" => "13718315395-icdjrdg6le5nlealmmf95q388l1suivq.apps.googleusercontent.com",
            "redirect_uri" => "http://" . $_SERVER['HTTP_HOST'] . "/cake/api/auth"
        ];
        
        //?response_type=code&client_id=13718315395-icdjrdg6le5nlealmmf95q388l1suivq.apps.googleusercontent.com&scope=profile
        $requestToken = $client->getRequestToken('https://accounts.google.com/o/oauth2/auth', 'http://' . $_SERVER['HTTP_HOST'] . '/cake/api/auth', 'POST', $tokenParameters);
        
        error_log('token retrieved');
        //error_log($requestToken);
        var_dump($requestToken);
        var_dump('http://' . $_SERVER['HTTP_HOST'] . '/cake/api/auth');

        if ($requestToken) {
            $this->Session->write('google_request_token', $requestToken);
            $this->redirect('https://accounts.google.com/o/oauth2/auth?oauth_token=' . $requestToken->key);
        } else {
            // an error occured when obtaining a request token
        }
    }

    public function callback() {
        $requestToken = $this->Session->read('google_request_token');
        $client = $this->createClient();
        $accessToken = $client->getAccessToken('https://accounts.google.com/o/oauth2/auth', $requestToken);
        
        error_log("logged in!");
    }

    private function createClient() {
        return new OAuthClient('13718315395-icdjrdg6le5nlealmmf95q388l1suivq.apps.googleusercontent.com', 'N5J397slxU-NzUo1nEY7gA5i');
    }
}
*/
?>