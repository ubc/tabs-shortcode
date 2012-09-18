jQuery(document).ready(function($) {
	
	$.each(tabs_shortcode, function(id, attr) {
		$("#" + id).tabs( attr );
	});
	if ( location.hash ) {
		$('a[href="'+location.hash+'"]').trigger('click');
	}
});