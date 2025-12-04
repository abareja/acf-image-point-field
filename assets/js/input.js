(function ($) {
    function initImagePoint(field) {
        const $wrapper = field.$el;

        const $canvas      = $wrapper.find('.acf-image-point-canvas');
        const $img         = $canvas.find('.acf-image-point-image');
        const $marker      = $canvas.find('.acf-image-point-marker');
        const $inputImage  = $wrapper.find('.acf-image-point-input-image');
        const $inputX      = $wrapper.find('.acf-image-point-input-x');
        const $inputY      = $wrapper.find('.acf-image-point-input-y');
        const $addButton   = $wrapper.find('.acf-image-point-select-image');
        const $removeBtn   = $wrapper.find('.acf-image-point-remove-image');

        function setMarker(x, y) {
            $marker
                .css({ left: `${x}%`, top: `${y}%` })
                .addClass('active');

            $inputX.val(x.toFixed(2));
            $inputY.val(y.toFixed(2));
        }

        function restoreMarkerIfPossible() {
            const xVal = parseFloat($inputX.val());
            const yVal = parseFloat($inputY.val());

            if (!isNaN(xVal) && !isNaN(yVal) && $img.length) {
                setMarker(xVal, yVal);
            }
        }

        restoreMarkerIfPossible();

        $canvas.off('click').on('click', '.acf-image-point-image', function (e) {
            const rect = this.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;

            setMarker(x, y);
        });

        function openMediaFrame() {
            const frame = wp.media({
                title: 'Wybierz obraz',
                library: { type: 'image' },
                button: { text: 'Wybierz obraz' },
                multiple: false
            });

            frame.on('select', function () {
                const attachment = frame.state().get('selection').first().toJSON();
                let $imageEl = $canvas.find('.acf-image-point-image');

                $inputImage.val(attachment.id);

                if ($imageEl.length) {
                    $imageEl.attr('src', attachment.url);
                } else {
                    $imageEl = $(`<img class="acf-image-point-image" src="${attachment.url}" draggable="false" />`);
                    $canvas.find('.acf-image-point-placeholder').remove();
                    $canvas.append($imageEl);
                }

                $wrapper.addClass('has-value');
            });

            frame.open();
        }

        $addButton.off('click').on('click', function (e) {
            e.preventDefault();
            openMediaFrame();
        });
        
        $removeBtn.off('click').on('click', function (e) {
            if (!$inputImage.val()) return;

            e.preventDefault();

            const $imgEl = $canvas.find('.acf-image-point-image');

            $inputImage.val('');
            $inputX.val('');
            $inputY.val('');

            $marker.removeClass('active');

            $canvas.prepend(`<div class="acf-image-point-placeholder">Brak wybranego obrazu</div>`);
            $imgEl.remove();

            $wrapper.removeClass('has-value');
        });
    }

    acf.addAction('ready_field/type=image_point', initImagePoint);

})(jQuery);