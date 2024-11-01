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
	
	// ==========>>> If compress pdf option is checked <<<==========
	function toggleTRsCompress() {
        if ($('#woow_pdf_compress_active').is(':checked')) {
            $('#woow-pdf-compress-box table tbody tr').slice(-2).show(); // Show last 2 <tr>
        } else {
            $('#woow-pdf-compress-box table tbody tr').slice(-2).hide(); // Hide last 2 <tr>
        }
    }
	
	// Initial check on page load
    toggleTRsCompress();
	
	// Check/uncheck event
    $('#woow_pdf_compress_active').change(function() {
        toggleTRsCompress();
    });
	
	// ==========>>> If watermark option is checked <<<==========
	function toggleTRsWatermark() {
        if ($('#woow_pdf_watermark_active').is(':checked')) {
            $('#woow-pdf-watermark-first-box table tbody tr').slice(-1).show(); // Show last 1 <tr>
        } else {
            $('#woow-pdf-watermark-first-box table tbody tr').slice(-1).hide(); // Hide last 1 <tr>
        }
    }
	
	// Initial check on page load
    toggleTRsWatermark();
	
	// Check/uncheck event
    $('#woow_pdf_watermark_active').change(function() {
        toggleTRsWatermark();
    });

	// ==========>>> Add Color Picker to all inputs that have 'color-field' class <<<==========
	$(
		function () {
			jQuery('.color-field').wpColorPicker();
		}
	);

	// ==========>>> Watermark Format Mode <<<==========
	$("input[name$='woow_pdf_display_settings_format_watermark[woow_pdf_format_watermark_mode]']").on(
		'change',
		function () {
			var test = $(this).val();

			$("div.watermark-mode").hide();
			$("#div-mode" + test).show();
		}
	);

	// ==========>>> Function to check the input field and disable/enable the radio button <<<==========
    function checkWatermarkText() {
		var watermarkTextEmpty = $('#woow_pdf_format_watermark_text').val() === '';
		var watermarkColorEmpty = $('#woow_pdf_format_watermark_text_color').val() === '';
		var watermarkSizeEmpty = $('#woow_pdf_format_watermark_text_size').val() === '';
		var watermarkOpacityEmpty = $('#woow_pdf_format_watermark_opacity').val() === '';
		var watermarkRotationEmpty = $('#woow_pdf_format_watermark_rotation').val() === '';
	
		// Disable/enable radio button based on watermark text presence
		if (watermarkTextEmpty || watermarkColorEmpty || watermarkSizeEmpty || watermarkOpacityEmpty || watermarkRotationEmpty) {
			$('#woow_pdf_format_watermark_mode_image').prop('disabled', true);
			$('#watermark-settings-main-box #submit').prop('disabled', true);
		} else {
			$('#woow_pdf_format_watermark_mode_image').prop('disabled', false);
			$('#watermark-settings-main-box #submit').prop('disabled', false);
		}
	
		// Show/hide required message spans based on input field values
		$("#woowpdf-text-required").toggle(watermarkTextEmpty);
		$("#woowpdf-color-required").toggle(watermarkColorEmpty);
		$("#woowpdf-size-required").toggle(watermarkSizeEmpty);
		$("#woowpdf-opacity-required").toggle(watermarkOpacityEmpty);
		$("#woowpdf-rotation-required").toggle(watermarkRotationEmpty);
	}
	
	// Initial check when the page loads
	checkWatermarkText();
	
	// Check again when any of the input field values change
	$('#woow_pdf_format_watermark_text, #woow_pdf_format_watermark_text_color, #woow_pdf_format_watermark_text_size, #woow_pdf_format_watermark_opacity, #woow_pdf_format_watermark_rotation').on('input', checkWatermarkText);

})( jQuery );
