<?php
$this->layout = 'none';
?>

<?php

if ($authenticator->IsAuthorized()) {
    echo "<div>" .
         "You are logged in, here is your login info:";
         var_dump($authenticator->IsAuthorized());
    echo "</div>";
}

?>
