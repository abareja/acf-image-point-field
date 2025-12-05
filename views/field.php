<?php
    $name = $field['name'];
    $key  = $field['key'];
    $value = wp_parse_args($field['value'], [
        'image' => 0,
        'pointX' => '',
        'pointY' => '',
    ]);
?>

<div 
    class="acf-field acf-field-image-point <?php if($value['image']) echo 'has-value'; ?>"
    style="--aspect-ratio: <?php echo $field['aspect'] ?? '16/9'; ?>;"
    data-type="image_point" 
    data-name="<?php echo esc_attr($name); ?>" 
    data-key="<?php echo esc_attr($key); ?>"
>
    <input 
        type="hidden"
        name="<?php echo "{$name}[image]"; ?>"
        class="acf-image-point-input-image"
        value="<?php echo esc_attr($value['image']); ?>"
    />

    <div class="acf-image-point-canvas">
        <?php if ($value['image']): ?>
            <img 
                class="acf-image-point-image"
                src="<?php echo esc_url(wp_get_attachment_image_url($value['image'], 'large')); ?>"
                draggable="false"
            />
        <?php else: ?>
            <div class="acf-image-point-placeholder">
                <?php _e('Brak wybranego obrazu', 'acf-image-point'); ?>
            </div>
        <?php endif; ?>

        <div class="acf-image-point-marker"></div>
    </div>

    <input type="hidden" name="<?php echo "{$name}[pointX]"; ?>" class="acf-image-point-input-x" value="<?php echo esc_attr($value['pointX']); ?>" />
    <input type="hidden" name="<?php echo "{$name}[pointY]"; ?>" class="acf-image-point-input-y" value="<?php echo esc_attr($value['pointY']); ?>" />

    <div>
        <div class="hide-if-value">
            <button type="button" class="acf-button button button-primary acf-image-point-select-image">
                <?php _e('Wybierz obraz', 'acf-image-point'); ?>
            </button>
        </div>

        <div class="show-if-value">
            <button type="button" class="acf-button button acf-image-point-remove-image">
                <?php _e('Usuń obraz', 'acf-image-point'); ?>
            </button>
        </div>
    </div>
</div>