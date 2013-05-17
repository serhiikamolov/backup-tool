//<script>
    
elgg.provide('elgg.backuptool');

elgg.backuptool.init = function() {
    
	$('#backups-checkall').click(function() {
		var checked = $(this).attr('checked') == 'checked';
		$('#backups-form').find('input[type=checkbox]').attr('checked', checked);
	});
/*
	$('.uservalidationbyemail-submit').click(function(event) {
		var $form = $('#uservalidationbyemail-form');
		event.preventDefault();

		// check if there are selected users
		if ($('#uservalidationbyemail-form .elgg-body').find('input[type=checkbox]:checked').length < 1) {
			return false;
		}

		// confirmation
		if (!confirm($(this).attr('title'))) {
			return false;
		}

		$form.attr('action', $(this).attr('href')).submit();
	});
        */
};

elgg.register_hook_handler('init', 'system', elgg.backuptool.init);
