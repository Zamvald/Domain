/*
 * SAMPLE JQUERY AJAX TO REQUEST DOMAIN CHECKER
 */

 // give function($) _> as inside avoid crash when call use Dollars on javascript
(function($) {
	$(document).on('submit', 'form.formdomain', function(e) {
		e.preventDefault();

		/* for bootstraps modal */
		//request.abort();
		$('#domainresults').modal({
			show:true
		});

		var $form        = $(e.currentTarget);
		var $target      = $('#showdomain');
 		var $loading     = $('#loadingdomain');
 		var $progressbar = $('.progress-bar');
 		$target.html(''); // remove the content of targets
 		$loading.show(); // show or set display block to loading sections
 		$progressbar.addClass('progress-animate');

		$.ajax({
			type: $form.attr('method'), // get the method
			url: $form.attr('action'), // get the url actions
			data: $form.serializeArray(), // serialize the input to send on forms
			mimeType:"multipart/form-data", // this is myme type
			cache: false, // cache
 			
 			// if success
			success: function(data, status) {
				$target.html(data);
				$loading.slideUp('slow'); // hide the loading with slide UP jquery effects , I like slow becoz is smooth
				$progressbar.removeClass('progress-animate');
				//$loading.hide('slow'); // hide the loading buth hide is too fast if not define the timing : slow, fast , normal or define seconds
				//$loading.fadeOut(); // I dont like the fade effect
				
				//console.log('data'); // ignore this just being console
			},
			error: function(resource) {
				console.log('error object see below\n');
				console.log(resource);
				$target.html('<div class="alert alert-danger">connection error</div>');
				$loading.slideUp('slow'); // hide the loading with slide UP jquery effects , I like slow becoz is smooth
				$progressbar.removeClass('progress-animate');
			}
		});
		e.preventDefault(); // prevent return  or as return false
	});

	// use selector avoid unexecute tooltip
	$('body').tooltip({
	    selector: '[data-toggle=tooltip]'
	});
	/* cllback the bootstrap tabs */

	$('#myTab a').click( function (e) {
 		e.preventDefault()
 			$(this).tab('show')
	});

})(window.jQuery);