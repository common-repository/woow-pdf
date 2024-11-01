jQuery(document).ready(function($) {
    if (typeof wp === 'undefined' || !wp.media) {
        return;
    }

    var file_frame;
    var wp_media_post_id = wp.media.model.settings.post.id;
    var set_to_post_id = woow_pdf_admin_media_selector.post_id;

    $('#upload_image_button').on('click', function(event) {
        event.preventDefault();
        if (file_frame) {
            file_frame.uploader.uploader.param('post_id', set_to_post_id);
            file_frame.open();
            return;
        } else {
            wp.media.model.settings.post.id = set_to_post_id;
        }

        file_frame = wp.media.frames.file_frame = wp.media({
            title: woow_pdf_admin_media_selector.title,
            library: {
                type: woow_pdf_admin_media_selector.mime_types
            },
            button: {
                text: woow_pdf_admin_media_selector.button,
            },
            multiple: false
        });

        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            $('#image-preview').attr('src', attachment.url);
            $('#woow_pdf_format_watermark_image').val(attachment.id);
            wp.media.model.settings.post.id = wp_media_post_id;
        });

        file_frame.open();
    });

    $('a.add_media').on('click', function() {
        wp.media.model.settings.post.id = wp_media_post_id;
    });
});
