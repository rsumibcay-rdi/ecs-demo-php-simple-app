<label for="{{field.id}}_image_size">
	<?php esc_html_e( 'Image size', 'meta-box-builder' ); ?>
	<?= mbb_tooltip( __( 'Image size that displays in the edit page', 'meta-box-builder' ) ) ?>
</label>
<select ng-model="field.image_size" id="{{field.id}}_image_size" class="widefat">
	<?php  $image_thumb  = get_intermediate_image_sizes(); ?>
	<?php foreach ( $image_thumb as $size_name ) : ?>
		<option value="<?php esc_attr( $size_name ) ?>"><?php esc_html( $size_name ) ?></option>
	<?php endforeach ?>
</select>