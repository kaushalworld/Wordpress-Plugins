<div class="wrap">
    <h1><?php echo $title; ?></h1>

	<?php if ( $accounts ): ?>
        <form action="<?php echo $pageLink; ?>" method="POST">
            <table class="wp-list-table widefat fixed striped posts">
                <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1"><?php _e( 'Select All', 'brizy-pro' ); ?></label>
                        <input id="cb-select-all-1" type="checkbox">
                    </td>
                    <th scope="col" id="title" class="manage-column column-title column-primary" width="25%"
                        style="padding: 10px;">
                        <span><?php _e( 'App', 'brizy-pro' ); ?></span>
                    </th>
                    <th scope="col" id="title" class="manage-column column-title column-primary"
                        style="padding: 10px;">
                        <span><?php _e( 'Details', 'brizy-pro' ); ?></span>
                    </th>
                </tr>
                </thead>

                <tbody id="the-list">
                    <?php foreach ( $accounts as $account ): ?>
                        <?php $serviceId = $account->getService(); ?>

                        <tr class="iedit level-0">
                            <th scope="row" class="check-column">
                                <label class="screen-reader-text" for="cb-select-<?php echo $account->getId(); ?>">
                                    <?php _e( 'Select Account', 'brizy-pro' ); ?>
                                </label>
                                <input id="cb-select-240" type="checkbox" name="delete-service-account[<?php echo $serviceId; ?>][]" value="<?php echo $account->getId(); ?>">
                            </th>
                            <td class="title column-title has-row-actions column-primary" data-colname="Identifier"
                                width="300">
                                <strong><?php echo ucwords( $serviceId ); ?></strong>
                                <span class="row-actions">
                                        <span class="trash">
                                            <a href="<?php echo $pageLink; ?>&delete-service-account[<?php echo $serviceId; ?>][]=<?php echo $account->getId(); ?>"
                                               class="submitdelete"
                                               onclick="return confirm('<?php _e( 'Are you sure you want to completely remove the selected accounts? All the features that use this integration will stop working!', 'brizy-pro' ); ?>')"
                                               aria-label="Move to the Trash">
                                                <?php _e( 'Delete', 'brizy-pro' ); ?>
                                            </a>
                                        </span>
                                    </span>
                                <button type="button" class="toggle-row">
                                    <span class="screen-reader-text">
                                        <?php _e( 'Show more details', 'brizy-pro' ); ?>
                                    </span>
                                </button>
                            </td>
                            <td class="title column-title has-row-actions column-primary" data-colname="Identifier">
                                <ul>
                                    <?php $data = $account->convertToAuthData(); ?>
	                                <?php foreach ( $account->convertToAuthData() as $key => $value ): ?>
	                                    <?php if ( $key != 'folders' ): ?>
                                            <li>
                                                <strong style="display: inline"><?php echo ucwords( str_replace( '_', ' ', $key ) ); ?></strong>:

                                                <i style="padding-left: 30px;"><?php echo substr( $value, 0, 8 ); ?>XXXXXXXXXXXXXXX</i>
                                            </li>
	                                    <?php endif; ?>
	                                <?php endforeach; ?>
                                </ul>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td class="manage-column column-cb check-column">
                            <label class="screen-reader-text" for="cb-select-all-2"><?php _e( 'Select All', 'brizy-pro' ); ?></label>
                            <input id="cb-select-all-2" type="checkbox">
                        </td>
                        <td scope="col" class="manage-column column-title column-primary" style="padding: 10px;">
                            <span><?php _e( 'App', 'brizy-pro' ); ?></span>
                        </td>
                        <td scope="col" class="manage-column column-data column-primary" style="padding: 10px;">
                            <span><?php _e( 'Details', 'brizy-pro' ); ?></span>
                        </td>
                    </tr>
                </tfoot>

            </table>

            <div class="tablenav bottom">
                <div class="alignleft actions bulkactions">
                    <input type="submit" id="doaction2" class="button action" value="Delete" name="delete-account"
                           onclick="return confirm('<?php _e( 'Are you sure you want to completely remove the selected account? All the features that use these integrations will stop working!', 'brizy-pro' ); ?>')">
                </div>
            </div>
        </form>
	<?php else: ?>
        <p><?php echo sprintf( __( 'Add new accounts directly in the %s builder.', 'brizy-pro' ), __bt( 'brizy', 'Brizy' ) ); ?></p>
	<?php endif; ?>
</div>