<?php

    defined('ABSPATH') or die('Jog on!');

    function sh_cd_advertise_pro() {
    
        $site_hash = sh_cd_generate_site_hash();

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.', YK_SS_SLUG ) );
        }

		// Remove existing license?
        if ( false === empty( $_GET['remove-license'] ) ) {
            yk_ss_license_remove();
        }

        ?>

        <div class="wrap ws-ls-admin-page">
            <?php
                if ( false === empty( $_POST['license-key'] ) ){

                    // First try validating and applying a new subscription license
                    $valid_license = yk_ss_license_apply( $_POST['license-key'] );

                    if ( $valid_license ) {
                        sh_cd_message_display( __('Your license has been applied!', YK_SS_SLUG ) );
                    } else {
                        sh_cd_message_display(__('There was an error applying your license. ', YK_SS_SLUG ), true);
                    }
                }

                $existing_license = ( true === yk_ss_license_is_premium() ) ? yk_ss_license() : NULL;

                if ( false === empty( $existing_license ) ) {
                    $license_decoded = yk_ss_license_decode( $existing_license );
                }

            ?>
            <div id="icon-options-general" class="icon32"></div>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">
                        <div class="meta-box-sortables ui-sortable">
                            <?php if ( true == sh_cd_is_premium() ) : ?>
                                <div class="postbox">
                                    <h3 class="postbox-header">
                                        <span>
                                            <?php echo __( 'Thank you for supporting this plugin', YK_SS_SLUG ); ?>
                                        </span>
                                    </h3>
                                    <div class="inside">
                                        <p><?php echo __( 'Purchasing a license for this WordPress plugin not only unlocks powerful premium features but also directly supports the ongoing development and maintenance of the tool. As an independent developer, every license sold helps cover the time, resources, and costs involved in keeping the plugin up-to-date, secure, and compatible with the latest WordPress standards. Your support ensures continued innovation, quick bug fixes, and responsive updates - ultimately making the plugin better for everyone in the community.', YK_SS_SLUG ); ?></p>                     
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="postbox">
                                    <h3 class="postbox-header">
                                        <span>
                                            <?php echo __( 'Purchase a Premium license', YK_SS_SLUG ); ?>
                                        </span>
                                    </h3>
                                    <div class="inside">
                                        <p><?php echo __( 'To access the Premium features of this plugin, simply purchase a license through our website:', YK_SS_SLUG ); ?></p>                     
                                    
                                        <?php sh_cd_upgrade_button(); ?>    
                                    </div>
                                </div>
                            <?php endif; ?>    
                            <div class="postbox">
                                <h3 class="postbox-header">
                                    <span>
                                        <?php echo __( 'Your Site Hash', YK_SS_SLUG ); ?>
                                    </span>
                                </h3>
                                <div class="inside">
                                        <p>
                                            <?php echo __( 'When purchasing a Premium license, you’ll need your site hash to link the license to this installation.', YK_SS_SLUG ); ?>
                                            <strong><?php echo __( 'Your Site Hash is', YK_SS_SLUG ); ?>: <?php echo esc_html( $site_hash ) ; ?></strong>
                                        </p>                        
                                </div>
                            </div>
                            <?php if ( false == sh_cd_is_premium() ) : ?>
                                <div class="postbox">
                                    <h3 class="postbox-header">
                                        <span>
                                            <?php echo __( 'Why you should upgrade', YK_SS_SLUG ); ?>
                                        </span>
                                    </h3>
                                    <div class="inside">
                                        <?php sh_cd_marketing_upgrade_page_text(); ?>                          
                                    </div>
                                </div>
                            <?php endif; ?>    
                        </div>
                    </div>

                    <div id="postbox-container-1" class="postbox-container">

                        <div class="meta-box-sortables">

                            <div class="postbox">
								<h3 class="postbox-header">
                                    <span>
                                        <?php echo __( 'Add or update license', YK_SS_SLUG ); ?>
                                    </span>
                                </h3>
                                <div class="inside">

                                    <form action="<?php echo admin_url( 'admin.php?page=sh-cd-shortcode-variables-upgrade&add-license=true' ); ?>"
                                          method="post">
                                        <p><?php echo __( 'Copy and paste the license given to you by YeKen into this box and click "Apply License".', YK_SS_SLUG ); ?></p>
                                        <textarea rows="5" style="width:100%" class="license-key" name="license-key"></textarea>
                                        <br/><br/>
                                        <input type="submit" class="button-secondary sh-cd-button large-text" value="<?php echo __( 'Apply License', YK_SS_SLUG ); ?>"/>
                                    </form>
                                </div>
                            </div>
                            <div class="postbox">
                                <h3 class="postbox-header">
                                    <span>
                                        <?php echo __( 'Your current license', YK_SS_SLUG ); ?>
                                    </span>
                                </h3>
                                <div class="inside">
                                    <table class="ws-ls-sidebar-stats">
                                        <tr>
                                            <th><?php echo __( 'Site Hash', YK_SS_SLUG ); ?></th>
                                            <td><?php echo esc_html( sh_cd_generate_site_hash() ); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo __( 'Expires', YK_SS_SLUG ); ?></th>
                                            <td class="yk-ss-license-expiry-date">
                                                <?php

                                                    if( false === empty( $license_decoded['type'] ) &&
															'sv-premium' === $license_decoded['type'] ) {

                                                        $time = strtotime( $license_decoded['expiry-date'] );
                                                        $formatted = date( 'd/m/Y', $time );

                                                        echo esc_html( $formatted );
                                                    } else {
                                                        echo __('No active license', YK_SS_SLUG);
                                                    }

                                                ?>
                                            </td>
                                        </tr>

                                        <?php if ( false === empty( $existing_license ) ): ?>
                                            <tr class="last">
                                                <th colspan="2"><?php echo __( 'Your Existing License', YK_SS_SLUG ); ?></th>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><textarea rows="5" style="width:100%" class="yk-ss-existing-license"><?php echo esc_textarea( $existing_license ); ?></textarea></td>
                                            </tr>
                                            <tr class="last">
                                                <td colspan="2"><a href="<?php echo admin_url('admin.php?page=sh-cd-shortcode-variables-upgrade&remove-license=true'); ?>" class="button-secondary delete-license sh-cd-button"><?php echo __( 'Remove License', YK_SS_SLUG ); ?></a></td>
                                            </tr>

                                        <?php endif; ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="post-body" class="metabox-holder columns-3">
                        <div id="post-body-content">
                            <div class="meta-box-sortables ui-sortable">

                            </div>
                        </div>
                        <br class="clear">
                    </div>
                </div>

            <?php
        }
?>
