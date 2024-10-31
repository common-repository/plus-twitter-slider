jQuery(document).ready(function($){
	//open the lateral panel
	$('.cd-btn-tw').on('click', function(event){
		event.preventDefault();
		$('.cd-panel-tw').addClass('is-visible');
	});
	//clode the lateral panel
	$('.cd-panel-tw').on('click', function(event){
		if( $(event.target).is('.cd-panel-tw') || $(event.target).is('.cd-panel-close-tw') ) { 
			$('.cd-panel-tw').removeClass('is-visible');
			event.preventDefault();
		}
	});
});