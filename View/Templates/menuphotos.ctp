<?php
$this->layout = 'none';
?>

<div ng-controller="PhotosController">
    <div class="galleries clearfix" data-ng-class="{hidden: hideGalleriesMenu}">
        <div class="galleries-item clickable" data-ng-repeat="coll in collections.galleries" data-ng-class="{selected: (currCollectionIndex == $index)}">
            <span data-ng-click="CollectionLoad($index, coll.uri);">{{coll.name}}</span>
        </div>
    </div>
</div>
