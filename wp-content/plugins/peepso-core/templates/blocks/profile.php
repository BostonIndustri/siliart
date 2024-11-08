<?php

// Get block settings.
[
    'title' => $title,
    'guest_behavior' => $guest_behavior,
    'show_notifications' => $show_notifications,
    'show_community_links' => $show_community_links,
    'show_cover' => $show_cover,
    'show_in_profile' => $show_in_profile,
] = $attributes;

$PeepSoProfile = PeepSoProfile::get_instance();
$PeepSoUser = $PeepSoProfile->user;

$login_with_email = 2 === (int) PeepSo::get_option('login_with_email', 0);

?><div class="psw-profile <?php echo isset($show_cover) && 1 == intval($show_cover) ? 'psw-profile--cover' : '' ?> ps-js-widget-me">
    <?php if ($user_id > 0) { ?>

        <?php
            if ($user_id == get_current_user_id()) {
                $user->profile_fields->load_fields();
                $stats = $user->profile_fields->profile_fields_stats;
            }
        ?>
        <div class="psw-profile__header">
            <div class="psw-profile__avatar">
                <?php if (isset($show_cover) && 1 == intval($show_cover)) { ?>
                <div class="psw-profile__cover ps-js-widget-me-cover" style="background-image:url(<?php echo esc_url($user->get_cover(750)); ?>);"></div>
                <?php } ?>
                <a class="ps-avatar psw-avatar--profile" href="<?php echo esc_url($user->get_profileurl()); ?>">
                    <img class="ps-js-widget-me-avatar" src="<?php echo esc_url($user->get_avatar()); ?>" title="<?php echo esc_url($user->get_profileurl()); ?>"
                        alt="<?php printf(esc_attr__('%s avatar', 'peepso-core'), esc_attr($user->get_fullname())); ?>" />
                </a>
            </div>
            <div class="psw-profile__meta">
                <div class="psw-profile__title" data-hover-card="<?php echo esc_attr($user->get_id()) ?>">
                    <a href="<?php echo esc_url($user->get_profileurl());?>">
                    <?php
                        do_action('peepso_action_render_user_name_before', $user->get_id());
                        echo esc_attr($user->get_fullname());
                        do_action('peepso_action_render_user_name_after', $user->get_id());
                    ?>
                    </a>
                </div>
                <?php if($show_notifications) { ?>
                <div class="ps-notifs psw-notifs--profile ps-js-widget-me-notifications">
                    <?php echo $toolbar; ?>
                </div>
                <?php } ?>
            </div>

            <!-- Profile Completeness -->
            <?php

            $hide_progress = TRUE;
            if (isset($stats) && $stats['fields_all'] > 0) {
                if ($stats['completeness'] < 100) {
                    $hide_progress = FALSE;
                }

                if(PeepSo::get_option_new('profile_completeness_hide_no_required_missing') && $stats['missing_required'] <= 0) {
                    $hide_progress = TRUE;
                }
            }

            ?>
            <div class="psw-profile__progress ps-js-widget-me-completeness" <?php if ($hide_progress) echo 'style="display:none"'; ?>>
                <div class="psw-profile__progress-message ps-js-status"><?php
                    echo wp_kses_post($stats['completeness_message']);
                    do_action('peepso_action_render_profile_completeness_message_after', $stats);
                ?></div>
                <div class="psw-profile__progress-bar ps-js-progressbar"><span style="width:<?php echo esc_attr($stats['completeness']);?>%"></span></div>
            </div>

        </div>
        <?php do_action('peepso_action_widget_profile_name_after', $user_id); ?>
        <div class="psw-profile__menu-title">
            <?php echo esc_attr__('My Profile', 'peepso-core'); ?>
        </div>
        <div class="psw-profile__menu"><?php

            // Profile Submenu extra links
            if(apply_filters('peepso_filter_navigation_preferences', TRUE)) {
                $links['peepso-core-preferences'] = array(
                    'href' => $user->get_profileurl() . 'about/preferences/',
                    'icon' => 'gcis gci-cog',
                    'label' => __('Preferences', 'peepso-core'),
                );
            }

            if(apply_filters('peepso_filter_navigation_log_out', TRUE)) {
                $links['peepso-core-logout'] = array(
                    'href' => PeepSo::get_page('logout'),
                    'icon' => 'gcis gci-power-off',
                    'label' => __('Log Out', 'peepso-core'),
                    'widget' => TRUE,
                );
            }
            if (isset($show_community_links) && 1 == intval($show_community_links)) {
                $community_links['peepso-core-logout'] = $links['peepso-core-logout'];
                unset($links['peepso-core-logout']);
            }

            foreach($links as $id => $link) {
                if (!isset($link['label']) || !isset($link['href']) || !isset($link['icon'])) {
                    var_dump($link);
                }

                $class = isset($link['class']) ? $link['class'] : '' ;
                $href = $user->get_profileurl(). $link['href'];
                if ('http' == substr(strtolower($link['href']), 0,4)) {
                    $href = $link['href'];
                }

                echo '<a href="' . esc_url($href) . '" class="psw-profile__menu-item ' . esc_attr($class) . '"><i class="' . esc_attr($link['icon']) . '"></i> ' . esc_attr($link['label']) . '</a>';
            }

        ?></div>

        <?php if (isset($show_community_links) && 1 == intval($show_community_links)) { ?>
        <div class="psw-profile__menu-title">
            <?php echo esc_attr__('Community', 'peepso-core'); ?>
        </div>
        <div class="psw-profile__menu"><?php
            foreach ($community_links as $link) {
                if (FALSE == $link['widget'] ) {
                    continue;
                }

                $class = isset($link['class']) ? $link['class'] : '' ;
                echo '<a href="' . esc_url($link['href']) . '" class="psw-profile__menu-item ' . esc_attr($class) . ' ps-js-widget-community-link"><i class="' . esc_attr($link['icon']) . '"></i> ' . esc_attr($link['label']) . '</a>';
            }
        ?></div>
        <?php } ?>

    <?php } else { ?>

        <div class="psf-login">
            <form class="ps-form ps-form--login ps-js-form-me-widget" action="" onsubmit="return false;" method="post" name="login" id="ps-form-login-me">
                <!-- Login -->
                <div class="ps-form__row ps-js-username-field">
                    <div class="ps-form__field ps-form__field--icon">
                        <div class="ps-input__wrapper--icon">
                            <input class="ps-input ps-input--sm ps-input--icon" type="text" name="username" placeholder="<?php echo esc_attr(PeepSoGeneral::get_login_input_label()); ?>" mouseev="true"
                                autocomplete="off" keyev="true" clickev="true" />
                            <?php if ($login_with_email) { ?>
                            <i class="gcis gci-envelope"></i>
                            <?php } else { ?>
                            <i class="gcis gci-user"></i>
                            <?php } ?>
                        </div>
                        <?php if ($login_with_email) { ?>
                        <div class="ps-form__field-notice ps-form__field-notice--important ps-js-email-notice" style="display:none"><?php echo esc_attr__('Please use a valid email address.', 'peepso-core'); ?></div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Password -->
                <div class="ps-form__row ps-js-password-field">
                    <div class="ps-form__field ps-form__field--icon">
                        <input class="ps-input ps-input--sm ps-input--icon <?php echo esc_attr(PeepSo::get_option_new('password_preview_enable') ? 'ps-js-password-preview' : '') ?>"
                                type="password" name="password" placeholder="<?php echo esc_attr__('Password', 'peepso-core'); ?>" mouseev="true"
                                autocomplete="off" keyev="true" clickev="true" />
                        <i class="gcis gci-key"></i>
                    </div>
                </div>

                <?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
                <?php if( PeepSo::two_factor_plugin_enabled() /* is_plugin_active('two-factor-authentication/two-factor-login.php') */ ) { ?>
                    <!-- Two Factor authentication -->
                    <div class="ps-form__row ps-js-password-field">
                        <div class="ps-form__field ps-form__field--icon ps-js-tfa-field" style="display:none">
                            <input class="ps-input ps-input--sm ps-input--icon" type="password" name="two_factor_code" placeholder="<?php echo esc_attr__('TFA code', 'peepso-core'); ?>" mouseev="true"
                                    autocomplete="off" keyev="true" clickev="true" data-ps-extra="1" />
                            <i class="gcis gci-fingerprint"></i>
                        </div>
                    </div>
                <?php } ?>

                <!-- Remember password -->
                <div class="ps-form__row ps-js-password-field">
                    <div class="ps-form__field ps-form__field--checkbox">
                        <div class="ps-checkbox ps-checkbox--login">
                            <input class="ps-checkbox__input" type="checkbox" alt="<?php echo esc_attr__('Remember Me', 'peepso-core'); ?>" value="yes" name="remember" id="ps-form-login-me-remember" <?php echo PeepSo::get_option('site_frontpage_rememberme_default', 0) ? ' checked':'';?>>
                            <label class="ps-checkbox__label" for="ps-form-login-me-remember"><?php echo esc_attr__('Remember Me', 'peepso-core'); ?></label>
                        </div>
                    </div>
                </div>

                <!-- Submit form -->
                <div class="ps-form__row ps-js-password-field">
                    <div class="ps-form__field ps-form__field--submit">
                        <?php $recaptchaEnabled = PeepSo::get_option('recaptcha_login_enable', 0); ?>
                        <button type="submit"
                            class="ps-btn ps-btn--sm ps-btn--action ps-btn--login ps-btn--loading <?php echo $recaptchaEnabled ? 'ps-js-recaptcha' : ''; ?>"
                            <?php echo $recaptchaEnabled ? 'disabled="disabled"' : '' ?>>
                            <span><?php echo esc_attr__('Login', 'peepso-core'); ?></span>
                            <img src="<?php echo esc_url(PeepSo::get_asset('images/ajax-loader.gif')); ?>">
                        </button>
                    </div>
                </div>

                <input type="hidden" name="option" value="ps_users">
                <input type="hidden" name="task" value="-user-login">
                <input type="hidden" name="redirect_to" value="<?php echo esc_url(PeepSo::get_page('redirectlogin')); ?>" />
                <?php
                // Remove ID attribute from nonce field.
                $nonce = wp_nonce_field('ajax-login-nonce', 'security', true, false);
                $nonce = preg_replace( '/\sid="[^"]+"/', '', $nonce );
                echo $nonce;
                ?>

                <?php do_action('peepso_action_render_login_form_after'); ?>
            </form>

            <?php do_action('peepso_after_login_form'); ?>

            <div class="psf-login__links">
                <?php
                $disable_registration = intval(PeepSo::get_option('site_registration_disabled', 0));

                // PeepSo/peepso#2906 hide "resend activation" until really necessary
                $hide_resend_activation = TRUE;
                ?>

                <?php if(0 === $disable_registration) { ?>
                    <a class="psf-login__link psf-login__link--register" href="<?php echo esc_url(PeepSo::get_page('register')); ?>"><?php echo esc_attr__('Register', 'peepso-core'); ?></a>
                <?php } ?>

                <a class="psf-login__link psf-login__link--recover" href="<?php echo esc_url(PeepSo::get_page('recover')); ?>"><?php echo esc_attr__('Forgot Password', 'peepso-core'); ?></a>

                <?php if(0 === $disable_registration) { ?>
                    <a class="psf-login__link psf-login__link--activation ps-js-register-activation" href="<?php echo esc_url(PeepSo::get_page('register')); ?>?resend"><?php echo esc_attr__('Resend activation code', 'peepso-core'); ?></a>
                <?php } ?>
            </div>
        </div>

        <script>
            (function() {
                // naively check if jQuery exist to prevent error
                var timer = setInterval(function() {
                    if ( window.jQuery && window.peepso ) {
                        clearInterval( timer );
                        peepso.login.initForm( jQuery('.ps-js-form-me-widget') );
                    }
                }, 1000 );
            })();
        </script>

    <?php } ?>
</div>
