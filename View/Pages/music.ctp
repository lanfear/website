<?php
    $this->Html->css('music/music', array('inline' => false ));
?>

<div ng-controller="MusicController">

    <div ng-view></div>
        
    <player
		playlist="playlist"
		media-type="audio"
        current-playlist-index="currentTrack"
        change-source="change"
	></player>
    <span>{{currentTrack}}</span>
    <div class="playlist">
        <ul>
            <li ng-repeat="playlistItem in playlist"><a ng-click="currentTrack = playlistItem[$index]">{{playlistItem.sources[0].src}}</a></li>
        </ul>
    </div>	
    <div class="slide-viewer-wrapper">
        <div class="slide-viewer"
             slide-source="slide in slides"
             menu-class="slide-menu"
             next-arrow-class="slide-next"
             previous-arrow-class="slide-previous"
             use-keyboard=true
             index-variable="currSlideIndex">
            <div class="release-menu-play"></div>
            <div class="release-menu-download"></div>
            <div class="release-content clearfix">
                <div class="release-img">
                    <div class="release-name">{{releaseName}}</div>
                    <img data-ng-src={{slide.urltnlarge}} />
                    <div class="release-artist">{{artistName}}</div>
                </div>
                <div class="release-tracklist clearfix">
                    <div class="release-tracklist-item" data-ng-repeat="track in release.release" data-ng-click="GetFile($index)">
                        <span>{{track.tracknum}}</span>
                        <span>{{track.trackname}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <jmd-audio-player></jmd-audio-player> -->

    
</div>