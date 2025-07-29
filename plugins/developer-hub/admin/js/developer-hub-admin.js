(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function($) {

    // Main Tabs
    $('.devhub-tabs .tab-link').on('click', function(e) {
        e.preventDefault();
        var tab = $(this).data('tab');
        $('.devhub-tabs .tab-link').removeClass('active');
        $(this).addClass('active');
        $('.tab-content').removeClass('active');
        $('#tab-' + tab).addClass('active');
    });

    // Sub-tabs
    $('.sub-tabs .sub-tab-link').on('click', function(e) {
        e.preventDefault();
        var subtab = $(this).data('subtab');
        $('.sub-tabs .sub-tab-link').removeClass('active');
        $(this).addClass('active');
        $('.sub-tab-content').removeClass('active');
        $('#subtab-' + subtab).addClass('active');
    });

    // Save CPT form
    $('#devhub-cpt-form').on('submit', function(e) {
        e.preventDefault();
        $.post(devHub.ajaxUrl, $(this).serialize() + '&action=devhub_save_cpt', function(response) {
            alert(response.data.message);
            if(response.success) location.reload();
        });
    });

    // Save Taxonomy form
		$('#devhub-tax-form').on('submit', function(e) {
			e.preventDefault();
			$.post(devHub.ajaxUrl, $(this).serialize() + '&action=devhub_save_taxonomy', function(response) {
				alert(response.data.message);
				if(response.success) location.reload();
			});
		});

	});

	 $('input[name="cpt_filter"]').on('change', function() {
        var filter = $(this).val();
        $('#cpt-table tbody tr').each(function() {
            var type = $(this).data('type');
            if (filter === 'all' || filter === type) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Taxonomy filter
    $('input[name="tax_filter"]').on('change', function() {
        var filter = $(this).val();
        $('#tax-table tbody tr').each(function() {
            var type = $(this).data('type');
            if (filter === 'all' || filter === type) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

	// Toggle fields row
    $('.view-fields').on('click', function(e){
        e.preventDefault();
        const key = $(this).data('key');
        $('#fields-' + key).toggle();
    });

	


})( jQuery );
