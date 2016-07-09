<?php
    $this->Html->css('music/music', array('inline' => false ));
?>

<div ng-controller="TvController">

    <!--
    <div data-ng-click="hideAlbumsMenu = !hideAlbumsMenu">ShowHide</div>
    <div class="releases clearfix" data-ng-class="{hidden: hideAlbumsMenu}">
        <div class="releases-item clickable" data-ng-repeat="img in collection.releases">
            <span class="truncate-200" title="{{img.name}}" data-ng-click="ReleaseLoad($index, img.uri, img.name)">{{img.name}}</span>
            <img data-ng-click="ReleaseLoad($index, img.uri, img.name)" data-ng-src={{img.urltn}}></span>
        </div>
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
                    <div class="release-tracklist-item" data-ng-repeat="track in release.release">
                        <span>{{track.tracknum}}</span>
                        <span>{{track.trackname}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->

    <div class="artists clearfix" data-ng-class="{hidden: hideGalleriesMenu}">
        <div class="artists-item clickable" data-ng-repeat="coll in collections.collections" data-ng-class="{selected: (currCollectionIndex == $index)}">
            <span data-ng-click="CollectionLoad($index, coll.uri);">{{coll.name}}</span>
        </div>
        <div class="artists-menuctrl clickable" data-ng-click="hideGalleriesMenu = !hideGalleriesMenu"><div class="one-line-text rotate-90"><span class="menuctrl-text">Show TV</span></div></div>
    </div>
    
</div>