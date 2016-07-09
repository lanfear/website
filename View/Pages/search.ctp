<div ng-controller="SearchController">
	
    <player	playlist="playlist"></player>
	<div class="search-container">Search <input type="text" data-ng-model="searchKeyword" /><button data-ng-click="searchWorkflow()">Search</button></div>
	<div class="search-results-container">
		<div class="search-result" data-ng-repeat="item in searchResults | orderBy:'path'">
			<span>{{item.extension}}</span>
			<span>Dir [{{item.isdir}}]</span>
			<span>Size [{{item.size}}]</span>
			<span>{{item.filename}}</span>
		</div>
	</div>
    
</div>