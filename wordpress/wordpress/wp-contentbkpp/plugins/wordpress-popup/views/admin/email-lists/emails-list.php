<?php
// ELEMENT: Pagination (Mobile) ?>
<div class="hui-pagination hui-pagination-mobile">
	<?php $this->render(
		'admin/email-lists/pagination-mobile',
		array(
			'admin' => $admin,
			'id' => $bulk_form_id,
			'is_top' => true,
		)
	); ?>
</div>

<div class="sui-box">

	<?php
	$items = count( $admin->entries_iterator() );
	// Filter Bar
	$this->render(
		'admin/email-lists/pagination-desktop',
		array(
			'admin' => $admin,
			'id' => $bulk_form_id,
			'is_top' => true,
		)
	); ?>

	<table class="hui-table-entries sui-table sui-table-flushed<?php echo $items ? ' sui-accordion' : ''; ?>">

		<thead>

			<tr>

				<th class="hui-column-id">
					<label class="sui-checkbox sui-checkbox-sm">
						<input type="checkbox" id="hustle-check-all">
						<span aria-hidden="true"></span>
						<span><?php esc_html_e( 'Id', Opt_In::TEXT_DOMAIN ); ?></span>
					</label>
				</th>

				<?php
				$fields_mappers = $admin->get_fields_mappers();
				// Start from 1, since first one is ID.
				// Length is 3 because we only display the 4 common columns.
				$fields_headers = array_slice( $fields_mappers, 1, 3 );

				$fields_left = count( $fields_mappers ) - count( $fields_headers );

				foreach ( $fields_headers as $header ) : ?>

					<th <?php echo isset( $header['class'] ) ? ' class="' . esc_attr( $header['class'] ) . '"' : ''; ?>><?php echo esc_html( $header['label'] ); ?></th>

				<?php endforeach; ?>

				<th data-num-hidden-fields="<?php echo ( $fields_left >= 0 ? $fields_left : 0 ); // WPCS: XSS ok. ?>"></th>

			</tr>

		</thead>

		<tbody class="hustle-list">

			<?php
			if ( $items ) {

				foreach( $admin->entries_iterator() as $entry ) :

					$entry_id = $entry['id'];
					$db_entry_id = $entry['entry_id'];

					$summary = $entry['summary'];
					$summary_items = $summary['items'];

					$detail = $entry['detail'];
					$detail_items = $detail['items'];

					$addons = $entry['addons'];
					?>

					<tr class="sui-accordion-item" data-entry-id="<?php echo esc_attr( $db_entry_id ); ?>">

						<?php foreach ( $summary_items as $key => $summary_item ) : ?>

							<?php if ( 1 === $summary_item['colspan'] ) : ?>

								<td class="hui-column-id sui-accordion-item-title">

									<label class="sui-checkbox sui-checkbox-sm">
										<input
											type="checkbox"
											name="ids[]"
											value="<?php echo esc_attr( $db_entry_id ); ?>"
											id="email-entry-<?php echo esc_attr( $db_entry_id ); ?>"
											class="hustle-listing-checkbox"
											form="<?php echo esc_attr( $bulk_form_id ); ?>"
										/>
										<span aria-hidden="true"></span>
										<span><?php printf( esc_html__( '%2$sSelect entry number%3$s%1$s' ), esc_attr( $db_entry_id ), '<span class="sui-screen-reader-text">', '</span>' ); ?></span>
									</label>

								</td>

							<?php else : ?>

								<?php if ( 'hui-column-date' === $summary_item['class'] ) { ?>
									<td class="hui-column-date">
										<?php echo esc_html( $summary_item['value'] ); ?>
										<span class="sui-accordion-open-indicator" aria-hidden="true">
											<i class="sui-icon-chevron-down" aria-hidden="true"></i>
											<span class="sui-screen-reader-text"><?php esc_html_e( 'Click to open', Opt_In::TEXT_DOMAIN ); ?></span>
										</span>
									</td>
								<?php } else { ?>
									<td <?php if ( ! empty( $summary_item['class'] ) ) echo ' class="' . esc_attr( $summary_item['class'] ) . '"'; ?>><?php echo esc_html( $summary_item['value'] ); ?></td>
								<?php } ?>

							<?php endif; ?>

							<?php if ( ! $summary['num_fields_left'] && ( count( $summary_items ) - 1 ) === $key ) : ?>

								<td><span class="hui-entry-button sui-accordion-open-indicator">
									<i class="sui-icon-chevron-down"></i>
									<span class="sui-screen-reader-text"><?php esc_html_e( 'Click to open', Opt_In::TEXT_DOMAIN ); ?></span>
								</span></td>

							<?php endif; ?>

						<?php endforeach; ?>

						<?php if ( $summary['num_fields_left'] ) : ?>

							<td><?php printf( esc_html__( "+ %s other fields", Opt_In::TEXT_DOMAIN ), esc_html( $summary['num_fields_left'] ) ); ?>
							<span class="sui-accordion-open-indicator">
								<i class="sui-icon-chevron-down" aria-hidden="true"></i>
								<span class="sui-screen-reader-text"><?php esc_html_e( 'Click to open', Opt_In::TEXT_DOMAIN ); ?></span>
							</span></td>

						<?php endif; ?>

					</tr>

					<tr class="sui-accordion-item-content">

						<td colspan="<?php echo esc_attr( $detail['colspan'] ); ?>">

							<div class="sui-box">

								<div class="sui-box-body">

									<h2>#<?php echo esc_html( $db_entry_id ); ?></h2>

									<div class="sui-box-settings-row sui-flushed">

										<div class="sui-box-settings-col-2">

											<ul class="hui-list">

												<?php foreach ( $detail_items as $detail_item ) : ?>

													<li>
														<strong><?php echo esc_html( $detail_item['label'] ); ?></strong>

														<?php $sub_entries = $detail_item['sub_entries']; ?>

														<?php if ( empty( $sub_entries ) ) { ?>
															<span class="sui-list-detail"
																style="margin-top: 0;">
																<?php echo ( $detail_item['value'] ); // wpcs xss ok. html output intended ?>
															</span>
														<?php } else {
															foreach ( $sub_entries as $sub_entry ) { ?>
																<div class="sui-form-field">
																	<span class="sui-settings-label"><?php echo esc_html( $sub_entry['label'] ); ?></span>
																	<span class="sui-list-detail"><?php echo ( $sub_entry['value'] ); // wpcs xss ok. html output intended ?></span>
																</div>
															<?php }
														} ?>


													</li>

												<?php endforeach; ?>

											</ul>

										</div>

									</div>

									<?php if ( ! empty( $addons ) ) : ?>

										<div class="sui-box-settings-row">

											<div class="sui-box-settings-col-2">

												<h3><?php esc_html_e( 'Active Integrations', Opt_In::TEXT_DOMAIN ); ?></h3>

												<p><?php esc_html_e( 'You can check if the data is submitted to your active integrations and the information returned by the integrations if any.', Opt_In::TEXT_DOMAIN ); ?></p>

												<table class="sui-table sui-accordion hui-table-entries-app">

													<thead>

														<tr>

															<th class="hui-column-name"><?php esc_html_e( 'Integration Name', Opt_In::TEXT_DOMAIN ); ?></th>
															<th class="hui-column-data"><?php esc_html_e( 'Data sent to integration', Opt_In::TEXT_DOMAIN ); ?></th>

														</tr>

													</thead>

													<tbody>

														<?php
														$num = 0;
														$num_addons = count( $addons );

														foreach ( $addons as $addon ) : ?>

															<tr class="sui-accordion-item<?php echo ( ++$num === $num_addons ) ? ' sui-table-item-last' : ''; ?> <?php echo ( $addon['summary']['data_sent'] ) ? 'sui-success' : 'sui-error'; ?>">

																<td class="hui-column-name sui-accordion-item-title">

																	<img
																		src="<?php echo esc_attr( $addon['summary']['icon'] ); ?>"
																		aria-hidden="true"
																	/>

																	<span><?php echo esc_attr( $addon['summary']['name'] ); ?></span>

																</td>

																<td class="hui-column-data">

																	<div class="hui-column-data--alignment">

																		<div class="hui-column-data--left"><?php $addon['summary']['data_sent'] ? esc_html_e( 'Yes', Opt_In::TEXT_DOMAIN ) : esc_html_e( 'No', Opt_In::TEXT_DOMAIN ); ?></div>

																		<div class="hui-column-data--right">

																			<a href="<?php echo esc_url( $wizard_page ); ?>" class="sui-button sui-button-ghost sui-accordion-item-action">
																				<i class="sui-icon-wrench-tool" aria-hidden="true"></i>
																				<?php esc_html_e( 'Configure', Opt_In::TEXT_DOMAIN ); ?>
																			</a>

																			<button class="sui-button-icon sui-accordion-open-indicator">
																				<i class="sui-icon-chevron-down" aria-hidden="true"></i>
																				<span class="sui-screen-reader-text"><?php esc_html_e( 'Click to open', Opt_In::TEXT_DOMAIN ); ?></span>
																			</button>

																		</div>

																	</div>

																</td>

															</tr>

															<tr class="sui-accordion-item-content <?php echo ( $addon['summary']['data_sent'] ) ?  'sui-success' : 'sui-error'; ?>">

																<td colspan="2">

																	<div class="sui-box">

																		<div class="sui-box-body">

																			<ul class="hui-list">

																				<?php foreach ( $addon['detail'] as $item ) : ?>

																					<li>
																						<strong><?php echo $item['label']; // wpcs xss ok. html output intended ?></strong>
																						<span><?php echo $item['value']; // wpcs xss ok. html output intended ?></span>
																					</li>

																				<?php endforeach; ?>

																			</ul>

																		</div>

																		<div class="sui-box-footer hui-hidden-desktop">

																			<a href="<?php echo esc_url( $wizard_page ); ?>" class="sui-button sui-button-ghost sui-accordion-item-action">
																				<i class="sui-icon-wrench-tool" aria-hidden="true"></i>
																				<?php esc_html_e( 'Configure', Opt_In::TEXT_DOMAIN ); ?>
																			</a>

																		</div>

																	</div>

																</td>

															</tr>

														<?php endforeach; ?>

													</tbody>

												</table>

											</div>

										</div>

									<?php endif; ?>

								</div>

								<div class="sui-box-footer">

									<button class="sui-button sui-button-red sui-button-ghost hustle-delete-entry-button"
										data-id="<?php echo esc_attr( $db_entry_id ); ?>"
										data-nonce=<?php echo esc_attr( wp_create_nonce( 'hustle_entries_request' ) ); ?>>
										<i class="sui-icon-trash" aria-hidden="true"></i>
										<?php esc_html_e( 'Delete', Opt_In::TEXT_DOMAIN ); ?>
									</button>

								</div>

							</div>

						</td>

					</tr>

				<?php endforeach; ?>

			<?php } else { ?>

				<tr>
					<td class="hui-column-notice" colspan="<?php echo count( $fields_headers ) + 2; ?>">
						<div class="sui-notice sui-notice-error">
							<p><?php esc_html_e( 'No entries were found.', Opt_In::TEXT_DOMAIN ); ?></p>
						</div>
					</td>
				</tr>

			<?php } ?>

		</tbody>

	</table>

	<?php
	// Filter Bar
	$this->render(
		'admin/email-lists/pagination-desktop',
		array(
			'admin'         => $admin,
			'input_id'      => 'hustle-actions-top',
			'is_top'        => false,
			'actions_class' => 'hui-mobile-hidden',
		)
	); ?>

</div>
