<?php
$this->layout = 'none';
?>

<div ng-controller="SlideshowController">

    <div class="slide-viewer-wrapper">
        <div class="slide-viewer"
             slide-source="slide in slides"
             menu-class="slide-menu"
             next-arrow-class="slide-next"
             previous-arrow-class="slide-previous"
             info-class="slide-info"
             use-keyboard=true
             index-variable="currSlideIndex"
             get-info="GetInfo">
            <img ng-src={{slide.urltnlarge}} />
            <div class="info-panel">
                <div class="image-width" data-ng-show="(imageInfo.computed.Width != '')">{{imageInfo.computed.Width}}</div>
                <div class="image-height" data-ng-show="(imageInfo.computed.Height != '')">{{imageInfo.computed.Height}}</div>
                <div class="image-filesize" data-ng-show="(imageInfo.file.FileSize != '')">{{imageInfo.file.FileSize}}</div>
                <div class="image-filesize" data-ng-show="(imageInfo.ifd0.DateTime != '')">{{imageInfo.ifd0.DateTime}}</div>
            </div>
        </div>
    </div>
    
    <div class="gallery clearfix">
        <div class="gallery-item clickable" data-ng-repeat="img in collection.gallery">
            <span data-ng-click="ImageLoad($index, img.uri, img.name)">{{img.name}}</span>
            <img data-ng-click="ImageLoad($index, img.uri, img.name)" data-ng-src={{img.urltn}}></span>
        </div>
    </div>

</div>