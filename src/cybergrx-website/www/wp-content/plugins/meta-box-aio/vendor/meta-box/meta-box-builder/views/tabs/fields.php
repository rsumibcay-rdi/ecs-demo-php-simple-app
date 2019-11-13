<?php
require __DIR__ . '/nav.php';
$active = filter_input( INPUT_GET, 'active' );
$active = $active ?: 'fields';

$menu = mbb_get_builder_menu();
?>

<div id="builder-gui" class="builder-gui nav-menus-php" ng-app="Builder">

	<div id="nav-menus-frame" ng-controller="BuilderController" ng-init="init()">
		<input type="hidden" name="excerpt" value="{{meta}}">

		<div class="builder-code-tab builder-code-tab--fields content-field <?php if ( 'fields' === $active ) echo 'metabox-tab-show'; ?>">
			<div id="menu-settings-column" class="metabox-holder">
				<input type="search" ng-model="searchKeyword" class="mbb-search-fields-input" placeholder="<?php esc_attr_e( 'Enter field type here', 'meta-box-builder' ); ?>">

				<div id="side-sortables" class="accordion-container" ng-show="searchKeyword.length <= 0">
					<ul class="outer-border">
						<?php $i = 0; ?>
						<?php foreach ( $menu as $block => $fields ) : ?>
							<?php $open = 0 === $i++ ? 'open' : ''; ?>
							<li class="control-section accordion-section <?= esc_attr( $open ) ?>">
								<h3 class="accordion-section-title hndle" tabindex="0"><?= esc_html( $block ) ?></h3>
								<div class="accordion-section-content">
									<div class="inside mbb-two">
										<?php foreach ( $fields as $type => $label ): ?>
											<button type="button" class="button" ng-click="addField('<?= esc_attr( $type ) ?>');"><?= esc_html( $label ) ?></button>
										<?php endforeach; ?>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="mbb-two" ng-show="searchKeyword.length > 0">
					<?php foreach ( $menu as $fields ) : ?>
						<?php foreach ( $fields as $type => $label ) : ?>
							<button type="button" class="button" ng-click="addField('<?= esc_attr( $type ) ?>');" ng-show="'<?= esc_attr( $label ) ?>'.toLowerCase().indexOf(searchKeyword.toLowerCase()) >= 0"><?= esc_html( $label ) ?></button>
						<?php endforeach; ?>
					<?php endforeach; ?>
				</div>
			</div>

			<div id="menu-management-liquid">
				<div id="menu-management">
					<div class="menu-edit">
						<div id="nav-menu-header">
							<div class="major-publishing-actions">
								<div class="pull-menu-name">
									<label class="menu-name-label howto open-label" for="menu-name"><?php esc_html_e( 'Title', 'meta-box-builder' ); ?></label>
									<input name="post_title" ng-change="onchangetitle('{{meta.slug}}')" ng-model="meta.title" id="menu-name" type="text" class="menu-name regular-text menu-item-textbox" placeholder="<?php esc_attr_e( 'Enter name here', 'meta-box-builder' ); ?>">
								</div>
								<div class="pull-menu-slug">
									<label class="menu-name-label howto open-label" for="menu-name-slug"><?php esc_html_e( 'ID', 'meta-box-builder' ); ?></label>
									<input name="post_slug" ng-model="meta.id" id="menu-name-slug" type="text" class="menu-name-slug regular-text menu-item-textbox" ng-change="meta.is_id_modified = true">
								</div>
								<div class="publishing-action ">
									<?php $status = get_post_status( get_the_ID() ); ?>
									<?php if ( 'publish' === $status ) : ?>
										<button class="components-button button-save-draft button-link button button-large" ng-click="meta.status = 'draft'"><?php esc_html_e( 'Switch to Draft', 'meta-box-builder' ); ?></button>
										<button class="button button-primary menu-save" ng-click="meta.status = 'publish'"><?php esc_html_e( 'Update', 'meta-box-builder' ); ?></button>
									<?php else : ?>
										<button class="components-button button-save-draft button-link button button-large" ng-click="meta.status = 'draft'"> <?php esc_html_e( 'Save Draft', 'meta-box-builder' ); ?></button>
										<button class="button button-primary menu-save" ng-click="meta.status = 'publish'"><?php esc_html_e( 'Publish', 'meta-box-builder' ); ?></button>
									<?php endif; ?>
								</div><!-- .publishing-action -->
							</div><!-- .major-publishing-actions -->
						</div>

						<div id="post-body">
							<div id="post-body-content">

								<h3><?php esc_html_e( 'Fields', 'meta-box-builder' ); ?></h3>
								<p ng-show="meta.fields.length == 0">
									<?php esc_html_e( 'No fields. Select fields on the left to add them to this field group.', 'meta-box-builder' ); ?>
								</p>
								<p ng-show="meta.fields.length > 0">
									<?php esc_html_e( 'Drag and drop fields to reorder. Click the title bar to reveal field settings.', 'meta-box-builder' ); ?>
								</p>

								<tg-dynamic-directive ng-model="meta" tg-dynamic-directive-view="getView"></tg-dynamic-directive>

								<script type="text/ng-template" id="nestable_item.html">
									<section ng-if="ngModelItem.type">
										<dl class="menu-item-bar menu-item-{{ngModelItem.type}}">
											<dt class="menu-item-handle" ng-click="toggleEdit(ngModelItem, $event)">
												<span class="item-title">
													<span class="menu-item-title" ng-show="ngModelItem.type != 'tab'">{{ngModelItem.name || ngModelItem.group_title}}</span>
													<span class="menu-item-title" ng-show="ngModelItem.type == 'tab'">
														<i class="wp-menu-image dashicons-before {{ngModelItem.icon}}"></i> {{ngModelItem.label}}
													</span>
												</span>
												<span class="item-controls">
													<span class="item-type">{{ngModelItem.type}}</span>
													<span class="mbb-item-actions">
														<a href="#" role="button" class="mbb-delete" ng-click="removeField(ngModelItem, $event)"><span class="dashicons dashicons-trash"></span></a>
														<a href="#" role="button" ng-show="ngModelItem.type != 'tab' && ngModelItem.type != 'group'" ng-click="cloneField(ngModelItem, $event)"><span class="dashicons dashicons-admin-page"></span></a>
													</span>
													<a class="item-edit" href="#"></a>
												</span>
											</dt>
										</dl>

										<div class="menu-item-settings" uib-collapse="field.id != active.id">
											<div class="field-edit-content" ng-include src="ngModelItem.type + '.edit.html'" role="tabpanel"></div>
										</div>
									</section>

									<ul class="apps-container menu ui-sortable" ui-sortable="sortableOptions" ng-model="ngModelItem.fields">
										<li class="mbb-group-container" ng-if="field.type=='group' && ngModelItem.fields.length < 1"><?php esc_html_e( 'Drag and drop child fields here.', 'meta-box-builder' ); ?></li>
										<li class="mbb-sub-fields menu-item builder-field builder-field-{{field.type}} {{field.id==active.id}}" ng-repeat="field in ngModelItem.fields track by field.id+$index">
											<tg-dynamic-directive ng-model="field" tg-dynamic-directive-view="getView">
											</tg-dynamic-directive>
										</li>
									</ul>
								</script>

							</div><!--#post-body-content-->
						</div><!--#post-body-->

						<div id="nav-menu-footer">
							<div class="major-publishing-actions">
								<span class="delete-action">
									<a class="submitdelete deletion menu-delete" href="<?= esc_url( get_delete_post_link() ); ?> "><?php esc_html_e( 'Move to Trash', 'meta-box-builder' ); ?></a>
								</span>
								<div class="publishing-action">
									<?php $status = get_post_status( get_the_ID() ); ?>
									<?php if ( 'publish' === $status ) : ?>
										<button class="components-button button-save-draft button-link button button-large" ng-click="meta.status = 'draft'"><?php esc_html_e( 'Switch to Draft', 'meta-box-builder' ); ?></button>
										<button class="button button-primary menu-save" ng-click="meta.status = 'publish'"><?php esc_html_e( 'Update', 'meta-box-builder' ); ?></button>
									<?php else : ?>
										<button class="components-button button-save-draft button-link button button-large" ng-click="meta.status = 'draft'"> <?php esc_html_e( 'Save Draft', 'meta-box-builder' ); ?></button>
										<button class="button button-primary menu-save" ng-click="meta.status = 'publish'"><?php esc_html_e( 'Publish', 'meta-box-builder' ); ?></button>
									<?php endif; ?>
								</div><!-- .publishing-action -->
							</div><!-- .major-publishing-actions -->
						</div><!--#nav-menu-footer-->

					</div>
				</div>
			</div>

			<?php
			// Generate script content for each template
			foreach ( $menu as $block => $fields ):
				foreach ( $fields as $k => $v ) : ?>

					<script type="text/ng-template" id="<?= $k ?>.edit.html">
						<?php mbb_get_field_edit_content( $k ); ?>
					</script>

				<?php endforeach; endforeach; ?>

			<datalist id="available_fields">
				<option ng-repeat="field in available_fields track by $index" value="{{field}}">
			</datalist>
		</div> <!-- -->

		<div class="builder-code-tab builder-code-tab--setting content-setting <?php if ( 'settings' === $active ) echo 'metabox-tab-show'; ?>">
			<?php require __DIR__ . '/settings.php'; ?>
		</div>

    </div>

</div>
