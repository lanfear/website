<?php
$this->layout = 'none';
?>

<div class="videogular-container" ng-class="{audio: mediaType == 'audio', hidden: playlist.length === 0}">
    <videogular vg-player-ready="onPlayerReady($API)" vg-change-source="tempSource($source)" vg-complete="onCompleteVideo()" vg-theme="config.theme.url">
        <vg-media vg-src="config.sources"
                  vg-tracks="config.tracks">
        </vg-media>

        <vg-controls>
            <vg-play-pause-button></vg-play-pause-button>
            <vg-time-display>{{ currentTime | date:'mm:ss' }}</vg-time-display>
            <vg-scrub-bar>
                <vg-scrub-bar-current-time></vg-scrub-bar-current-time>
            </vg-scrub-bar>
            <vg-time-display>{{ timeLeft | date:'mm:ss' }}</vg-time-display>
            <vg-volume>
                <vg-mute-button></vg-mute-button>
                <vg-volume-bar></vg-volume-bar>
            </vg-volume>
            <vg-fullscreen-button></vg-fullscreen-button>
        </vg-controls>

        <vg-overlay-play></vg-overlay-play>
        <vg-buffering></vg-buffering>
        <vg-poster vg-url='config.plugins.poster'></vg-poster>
    </videogular>
</div>
