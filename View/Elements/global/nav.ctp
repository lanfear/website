<ul id="mainmenu">
    <li class="item">
        <?php
          if (!$authenticator->IsAuthorized()) {
            echo "<a class='login' href='" . $authenticator->GetAuthUrl() . "'>Login</a>";
          } else {
            echo "<a class='logout' href='" . $authenticator->GetLogoutUrl() . "'>Logout</a>";
          }
        ?>
    </li>
    <main-menu-item name="login" value="<?php echo (!$authenticator->IsAuthorized()) ? 'Login' : 'Logout' ?>"></main-menu-item>
    <main-menu-item name="photos" value="Photos"></main-menu-item>
    <main-menu-item name="music" value="Music"></main-menu-item>
    <main-menu-item name="tv" value="TV"></main-menu-item>
    <main-menu-item name="movies" value="Movies"></main-menu-item>
    <main-menu-item name="player" value="Player"></main-menu-item>
    <main-menu-item name="playlist" value="Playlist"></main-menu-item>
    <menu-item-content name="login"></menu-item-content>
    <menu-item-content name="photos"></menu-item-content>
    <menu-item-content name="music"></menu-item-content>
    <menu-item-content name="tv"></menu-item-content>
    <menu-item-content name="movies"></menu-item-content>
</ul>
