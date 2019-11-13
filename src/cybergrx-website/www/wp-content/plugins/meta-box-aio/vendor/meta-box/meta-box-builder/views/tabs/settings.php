<h2><?php esc_html_e( 'Location', 'meta-box-builder' ); ?></h2>
<table class="form-table">
	<?php
	$object_types = [
		'post_types' => __( 'Posts', 'meta-box-builder' ),
	];
	if ( mbb_is_extension_active( 'mb-term-meta' ) ) {
		$object_types['taxonomies'] = __( 'Taxonomies', 'meta-box-builder' );
	}
	if ( mbb_is_extension_active( 'mb-settings-page' ) ) {
		$object_types['settings_pages'] = __( 'Setting Pages', 'meta-box-builder' );
	}
	if ( mbb_is_extension_active( 'mb-user-meta' ) ) {
		$object_types['user'] = __( 'Users', 'meta-box-builder' );
	}
	if ( mbb_is_extension_active( 'mb-comment-meta' ) ) {
		$object_types['comment'] = __( 'Comments', 'meta-box-builder' );
	}
	?>
	<tr ng-show="<?= count( $object_types ) > 1 ? 'true' : 'false' ?>">
		<th><?php esc_html_e( 'Show for', 'meta-box-builder' ); ?></th>
		<td>
			<select name="forobject" ng-model="meta.for" ng-init="meta.for = meta.for || 'post_types'">
				<?php foreach ( $object_types as $type => $label ) : ?>
					<option value="<?= esc_attr( $type ) ?>"><?= esc_html( $label ) ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr ng-show="meta.for == 'post_types'">
		<th><?php esc_html_e( 'Post types', 'meta-box-builder' ); ?></th>
		<td>
			<select ng-model="meta.post_types" ng-options="post_type.slug as post_type.name for post_type in post_types" multiple class="mbb-select2" style="width: 99%"></select>
		</td>
	</tr>
	<tr ng-show="meta.for == 'post_types' && meta.post_types == 'attachment'">
		<th><?php esc_html_e( 'Show in media modal?', 'meta-box-builder' ); ?></th>
		<td><input type="checkbox" ng-model="meta.media_modal" ng-true-value="'true'"></td>
	</tr>
	<tr ng-show="meta.for == 'taxonomies'">
		<th><?php esc_html_e( 'Taxonomies', 'meta-box-builder' ); ?></th>
		<td>
			<select ng-model="meta.taxonomies" ng-options="taxonomy.slug as taxonomy.name for taxonomy in taxonomies" multiple class="mbb-select2" style="width: 99%"></select>
		</td>
	</tr>
	<tr ng-show="meta.for == 'settings_pages'">
		<th><?php esc_html_e( 'Setting Pages', 'meta-box-builder' ); ?></th>
		<td>
			<select ng-model="meta.settings_pages" ng-options="setting_page.id as setting_page.title for setting_page in settings_pages" multiple class="mbb-select2" style="width: 99%"></select>
		</td>
	</tr>
</table>

<?php include MBB_DIR . 'views/settings/include-exclude.php'; ?>
<?php include MBB_DIR . 'views/settings/show-hide.php'; ?>
<?php include MBB_DIR . 'views/settings/conditional-logic.php'; ?>

<h2><?php esc_html_e( 'Options', 'meta-box-builder' ); ?></h2>
<table class="form-table" ng-show="meta.for == 'post_types'">
	<tr>
		<th><?php esc_html_e( 'Position', 'meta-box-builder' ); ?></th>
		<td>
			<select name="context" ng-model="meta.context">
				<option value="normal"><?php esc_html_e( 'After content', 'meta-box-builder' ); ?></option>
				<option value="side"><?php esc_html_e( 'Side', 'meta-box-builder' ); ?></option>
				<?php if ( ! function_exists( 'register_block_type' ) ) : ?>
					<option value="form_top"><?php esc_html_e( 'Before post title', 'meta-box-builder' ); ?></option>
					<option value="after_title"><?php esc_html_e( 'After post title', 'meta-box-builder' ); ?></option>
				<?php endif; ?>
			</select>
		</td>
	</tr>
	<tr>
		<th><?php esc_html_e( 'Priority', 'meta-box-builder' ); ?></th>
		<td>
			<label><input type="radio" ng-model="meta.priority" name="priority" value="high"> <?php esc_html_e( 'High', 'meta-box-builder' ); ?></label>
			<label><input type="radio" ng-model="meta.priority" name="priority" value="low"> <?php esc_html_e('Low', 'meta-box-builder'); ?></label>
		</td>
	</tr>
	<tr>
		<th><?php esc_html_e( 'Style', 'meta-box-builder' ); ?></th>
		<td>
			<select name="style" ng-model="meta.style">
				<option value=""><?php esc_html_e( 'Standard (WordPress meta box)', 'meta-box-builder' ); ?></option>
				<option value="seamless"><?php esc_html_e( 'Seamless (no meta box)', 'meta-box-builder' ); ?></option>
			</select>
		</td>
	</tr>

	<?php if ( ! function_exists( 'register_block_type' ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Hidden by default.', 'meta-box-builder' ); ?></th>
			<td>
				<label>
					<input type="checkbox" ng-model="meta.default_hidden" ng-true-value="'true'" ng-false-value="'false'">
					<?php esc_html_e( 'The meta box is hidden by default and requires users to select the corresponding checkbox in Screen Options to show it', 'meta-box-builder' ); ?>
				</label>
			</td>
		</tr>
	<?php endif; ?>

	<tr>
		<th><?php esc_html_e( 'Autosave', 'meta-box-builder' ); ?></th>
		<td><input ng-true-value="'true'" ng-false-value="'false'" type="checkbox" ng-model="meta.autosave"></td>
	</tr>
</table>

<?php include MBB_DIR . 'views/settings/custom-attributes.php'; ?>
<?php include MBB_DIR . 'views/settings/custom-table.php'; ?>

<h2 ng-show="tabExists"><?php esc_html_e( 'Tabs', 'meta-box-builder' ); ?></h2>
<table class="form-table" ng-show="tabExists">
	<tr>
		<th><?php esc_html_e( 'Tabs style', 'meta-box-builder' ); ?></th>
		<td>
			<select ng-model="meta.tab_style">
				<option value="default"><?php esc_html_e( 'Default', 'meta-box-builder' ); ?></option>
				<option value="box"><?php esc_html_e( 'Box', 'meta-box-builder' ); ?></option>
				<option value="left"><?php esc_html_e( 'Left', 'meta-box-builder' ); ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<th><?php esc_html_e( 'Show meta box wrapper', 'meta-box-builder' ); ?></th>
		<td><input type="checkbox" ng-model="meta.tab_wrapper" ng-true-value="'true'" ng-false-value="'false'"></td>
	</tr>
</table>

<?php submit_button( __( 'Save Changes', 'meta-box-builder' ) ); ?>
