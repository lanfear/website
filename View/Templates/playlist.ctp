<?php
$this->layout = 'none';
?>

<ul>
    <li ng-repeat="playlistItem in playlist"><a ng-click="controller.setVideo(0)">{{playlistItem.sources[0].src}}</a></li>
</ul>
