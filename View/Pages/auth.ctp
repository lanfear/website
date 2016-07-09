<?php

if (isset($_REQUEST['logout'])) {
  $authenticator->LogOut();
}

$authenticator->Authenticate();

$authenticator->CheckLogin();

?>
<?php

if ($authenticator->IsAuthorized()) {
    echo "<div>" .
         "You are logged in, here is your login info:";
         var_dump($authenticator->IsAuthorized());
    echo "</div>";
}

?>
<a href="search">Home Page</a>