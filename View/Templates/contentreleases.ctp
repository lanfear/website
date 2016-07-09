<?php
$this->layout = 'none';
?>

<div data-ng-controller="MusicController">
    <div data-ng-click="hideAlbumsMenu = !hideAlbumsMenu">ShowHide</div>
    <div class="releases clearfix" data-ng-class="{hidden: hideAlbumsMenu}">
        <div class="releases-item clickable" data-ng-repeat="img in collection.releases">
            <span class="truncate-200" title="{{img.name}}" data-ng-click="ReleaseLoad($index, img.uri, img.name)">{{img.name}}</span>
            <img data-ng-click="ReleaseLoad($index, img.uri, img.name)" data-ng-src={{img.urltn}}></span>
        </div>
    </div>
</div>
