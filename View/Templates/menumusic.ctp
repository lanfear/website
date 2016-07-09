<?php
$this->layout = 'none';
?>

<div class="artists clearfix" data-ng-controller="MusicController">
    <div class="artists-item clickable" data-ng-repeat="coll in collections.artists" data-ng-class="{selected: (currCollectionIndex == $index)}">
        <span data-ng-click="CollectionLoad($index, coll.uri);">{{coll.name}}</span>
    </div>
</div>
