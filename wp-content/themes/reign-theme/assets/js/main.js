/* global wc_add_to_cart_params, wp_main_js_obj, $reign_topbar_height */

(function($) {
    "use strict";
    window.Reign = {
        init: function() {
            this.stickyHeader();
            this.mobileMenu();
            this.panelMenu();
            this.iconsToggle();
            this.responsiveMenu();
            this.headerSearch();
            if (wp_main_js_obj.enable_masonry == 'masonry-view' ) {
                this.postMasonry();
            }
            this.fitVids();
            this.stickyKit();
            this.pageLoader();
            this.customMblDropdown();
            this.addHeaderClass();
            this.addPageHeaderClass();
            this.randomPostCatClass();
            this.galleryPostSlider();
            this.passwordEyeInit();
            this.singinPopupInit();
            this.registerPopupInit();
            this.singinTabInit();
            this.closePopupInit();
            this.LoginFormSubmit();
            this.RegisterFormSubmit();
            this.scrollUp();
            this.mediaPress();
            this.postSocialShare();
        },
        stickyHeader: function() {

            var $body = $('body');
            const site_header = $('.reign-fallback-header');

            if ($('.reign-header-top').length) {
                var reign_topbar_height = $('.reign-header-top').outerHeight();
                var reign_sticky_topbar_height = $('.reign-sticky-topbar .reign-header-top').outerHeight();
            }

            if ($('#wbcom-header-topbar').length) {
                var reign_ele_topbar_height = $('#wbcom-header-topbar').outerHeight();
            }

            // Fixed top
            if (site_header.hasClass('fixed-top')) {
                var $lastScrollTop = 0;
                $(window).on('scroll resize', function() {
                    if (window.innerWidth >= 960) {
                        if ($(this).scrollTop() > 0) {
                            site_header.addClass('nav-scrolling');
                            if ($(this).scrollTop() > $lastScrollTop) {
                                site_header.addClass('to-bottom');
                                site_header.removeClass('to-top');
                            } else {
                                site_header.addClass('to-top');
                                site_header.removeClass('to-bottom');
                            }
                            $lastScrollTop = $(this).scrollTop();
                        } else {
                            site_header.removeClass('nav-scrolling');
                        }
                    } else {
                        if ($(this).scrollTop() > 50) {
                            site_header.addClass('nav-scrolling');
                            if ($(this).scrollTop() > $lastScrollTop) {
                                site_header.addClass('to-bottom');
                                site_header.removeClass('to-top');
                            } else {
                                site_header.addClass('to-top');
                                site_header.removeClass('to-bottom');
                            }
                            $lastScrollTop = $(this).scrollTop();
                        } else {
                            site_header.removeClass('nav-scrolling');
                        }
                    }
                });
            }

            // Fixed top scrolling
            if (site_header.hasClass('fixed-top')) {
                $(window).on('scroll resize', function() {
                    if (site_header.hasClass('nav-scrolling') && site_header.hasClass('to-bottom')) {
                        if ($body.hasClass('admin-bar')) {
                            site_header.css({ top: ($('#wpadminbar').outerHeight() - $('.reign-nav-top-bar').outerHeight()) });

                            site_header.css("marginTop", 0 + "px");
                        } else {
                            site_header.css({ top: $('.reign-nav-top-bar').outerHeight() * -1 });

                            site_header.css("marginTop", 0 + "px");
                        }
                    } else {
                        site_header.removeAttr('style');

                        site_header.css("marginTop", reign_topbar_height + "px");

                        site_header.css("marginTop", reign_ele_topbar_height + "px");
                    }
                });
            }
        
            if (site_header.hasClass('fixed-top')) {
                $(window).on('load resize', function() {
                    if ($('.reign-fallback-header:not(.nav-scrolling)')) {
                        site_header.css("marginTop", reign_topbar_height + "px");
                        site_header.css("marginTop", reign_ele_topbar_height + "px");
                    }
                });
            }

        },
        mobileMenu: function() {

            $(document).ready(function() {
                // Admin bar fixed
                $('#wpadminbar').css('position', 'fixed');

                // Menu toggle.
                // open the lateral panel
                $('.reign-toggler-left').on('click', function (event) {
                    event.preventDefault();
                    $('.reign-navbar-mobile .navbar-menu-container').addClass('is-visible');
                    $('body').addClass('mobile-panel-open');
                });
                // clode the lateral panel
                $('.reign-navbar-mobile .navbar-menu-container').on('click', function (event) {
                    if ($(event.target).is('.reign-navbar-mobile .navbar-menu-container') || $(event.target).is('.reign-panel-close') || $(event.target).is('.reign-panel-close i')) {
                        $('.reign-navbar-mobile .navbar-menu-container').removeClass('is-visible');
                        event.preventDefault();
                        $('body').removeClass('mobile-panel-open');
                    }
                });

                // open the lateral panel
                $('.reign-user-toggler .user-link, .reign-user-toggler .ps-avatar').on('click', function (event) {
                    event.preventDefault();
                    $('.reign-user-toggler .user-profile-menu-wrapper').addClass('is-visible');
                    $('body').addClass('mobile-panel-open');
                });
                // clode the lateral panel
                $('.reign-user-toggler .user-profile-menu-wrapper').on('click', function (event) {
                    if ($(event.target).is('.reign-user-toggler .user-profile-menu-wrapper') || $(event.target).is('.reign-panel-close') || $(event.target).is('.reign-panel-close i')) {
                        $('.reign-user-toggler .user-profile-menu-wrapper').removeClass('is-visible');
                        event.preventDefault();
                        $('body').removeClass('mobile-panel-open');
                    }
                });

                // Submenu toggle
                $('.reign-navbar-mobile .primary-menu .sub-menu, .reign-navbar-mobile .navbar-reign-panel .sub-menu').hide();

                $('.reign-navbar-mobile .primary-menu .menu-item-has-children, .reign-navbar-mobile .navbar-reign-panel .menu-item-has-children').each(function() {
                    $(this).prepend('<i class="far submenu-btn fa-plus"></i>');
                });

                $('body').on('click', '.reign-navbar-mobile .primary-menu .submenu-btn, .reign-navbar-mobile .navbar-reign-panel .submenu-btn', function(e) {
                    e.preventDefault();
                    $("body").addClass('menu-active');
                    $(this).toggleClass('fa-minus').parent().children('.sub-menu').slideToggle();
                    $(this).toggleClass('fa-plus');
                });

                $('.reign-navbar-mobile .primary-menu li:has(ul), .reign-navbar-mobile .navbar-reign-panel li:has(ul)').doubleTapToGo();

            });

        },
        panelMenu: function() {
            // Check if panel should be open by default
            if ($('.reign-menu-panel').hasClass('reign-panel-open')) {
                setCookie('reignpanel', 'open', 30, '/');
            }

            // Panel toggle
            $('.reign-menu-panel .reign-toggler').on('click', function(e) {
                e.preventDefault();

                $('.reign-menu-panel').toggleClass('reign-panel-open');

                // Save panel state to the cookie
                var panelStatus = $('.reign-menu-panel').hasClass('reign-panel-open') ? 'open' : 'closed';
                setCookie('reignpanel', panelStatus, 30, '/');
            });

            $('.reign-menu-panel-inner.reign-scrollbar').mCustomScrollbar({
                theme: 'minimal-dark',
                mouseWheel: { preventDefault: true },
            });

            $('.reign-menu-panel .sub-menu').each(function() {
                $(this).closest('li.menu-item-has-children').find('a:first').append('<i class="far fa-angle-down rg-submenu-toggle"></i>');
            });

            $(document).on('click', '.rg-submenu-toggle', function(e) {
                e.preventDefault();
                $(this).toggleClass('rg-submenu-open').closest('a').next('.sub-menu').toggleClass('submenu-open');
            });

            function setCookie(key, value, expires, path, domain) {
                var cookie = key + '=' + escape(value) + ';';

                if (expires) {
                    if (expires instanceof Date) {
                        if (isNaN(expires.getTime())) {
                            expires = new Date();
                        }
                    } else {
                        expires = new Date(new Date().getTime() + parseInt(expires) * 1000 * 60 * 60 * 24);
                    }
                    cookie += 'expires=' + expires.toUTCString() + ';';
                }

                if (path) {
                    cookie += 'path=' + path + ';';
                }
                if (domain) {
                    cookie += 'domain=' + domain + ';';
                }

                document.cookie = cookie;
            }
        },
        iconsToggle: function() {
            $(document).on(
                'click',
                '.header-notifications-dropdown-toggle a.dropdown-toggle',
                function(e) {
                    e.preventDefault();
                    var current = $(this).closest('.header-notifications-dropdown-toggle');
                    current.siblings('.selected').removeClass('selected');
                    current.toggleClass('selected');
                }
            );

            $('body').mouseup(
                function(e) {
                    var container = $('.header-notifications-dropdown-toggle *');
                    if (!container.is(e.target)) {
                        $('.header-notifications-dropdown-toggle').removeClass('selected');
                    }
                }
            );
        },
        responsiveMenu: function() {

            // More Menu
            if (wp_main_js_obj.reign_more_menu_enable) {
                $('.reign-fallback-header.version-one .primary-menu, .reign-fallback-header.version-two .primary-menu, .reign-fallback-header.version-three .primary-menu, #wbcom-ele-masthead .primary-menu').ReignMore(60);
            }

            if (wp_main_js_obj.reign_more_menu_enable) {
                $('.reign-fallback-header.version-four .primary-menu').ReignMore(30);
            }

            $(document).on(
                'click',
                '.header-more-dropdown-toggle a.dropdown-toggle',
                function(e) {
                    e.preventDefault();
                    var current = $(this).closest('.header-more-dropdown-toggle');
                    current.siblings('.selected').removeClass('selected');
                    current.toggleClass('selected');
                }
            );

            $('body').mouseup(
                function(e) {
                    var container = $('.header-more-dropdown-toggle *');
                    if (!container.is(e.target)) {
                        $('.header-more-dropdown-toggle').removeClass('selected');
                    }
                }
            );

            $('.main-navigation>ul').each(function() {
                $('body').addClass('nav-more-loaded');
            });

        },
        
        headerSearch: function() {
            $(document).on('click', '.search-wrap .rg-search-icon', function(e) {
                var searchParent = $(this).parent('.search-wrap');
                e.preventDefault();
                searchParent.toggleClass('search-active');
                searchParent.find('.search-field').focus();
            });
            $(document).on('click', '.search-wrap .rg-search-close', function(e) {
                var container = $(".search-wrap");
                container.removeClass('search-active');
            });

            $('body').mouseup(
                function(e) {
                    var container = $('.search-wrap *');
                    if (!container.is(e.target)) {
                        $('.search-wrap').removeClass('search-active');
                    }
                }
            );
        },
        postMasonry: function() {
            $(document).ready(function() {
                $('.masonry.wb-post-listing').masonry({
                    itemSelector: '.masonry-view',
                    columnWidth: '.reign-grid-sizer',
                });
            });
        },
        fitVids: function() {
            $(document).ready(function() {
                // LearnDash Player fix
                if ( $( '.ld-video iframe' ).length > 0 ) {
                    $( '.ld-video iframe' ).addClass( 'fitvidsignore' );
                }

                // Tutor Player fix
                if ( $( '.tutor-video-player iframe' ).length > 0 ) {
                    $( '.tutor-video-player iframe' ).addClass( 'fitvidsignore' );
                }

                // Target your .container, .wrapper, .post, etc.
                $("body").fitVids();
            });
        },
        stickyKit: function() {
            var rgHeaderHeight = $('#masthead .reign-fallback-header').outerHeight();
            var offsetTop = 40;
        
            if ($('body').hasClass('reign-sticky-header') && $('body').hasClass('admin-bar')) {
                offsetTop = rgHeaderHeight + 72;
            } else if ($('body').hasClass('reign-sticky-header')) {
                offsetTop = rgHeaderHeight + 40;
            } else if ($('body').hasClass('admin-bar')) {
                offsetTop = 72;
            }

            if (window.innerWidth > 991) {
                $('body.reign-sticky-sidebar aside.widget-area').theiaStickySidebar({
                    additionalMarginTop: offsetTop,
                });
            }

            $(window).resize(function() {
                if (window.innerWidth > 991) {
                    $('body.reign-sticky-sidebar aside.widget-area').theiaStickySidebar({
                        additionalMarginTop: offsetTop
                    });
                }
            });
        },
        pageLoader: function() {
            $(window).load(function() {
                $('body').addClass('rg-page-loaded rg-remove-loader');
            });

            setTimeout(function() {
                if (!($('body').hasClass('rg-remove-loader'))) {
                    $('body').addClass('rg-remove-loader');
                }
            }, 3000);
        },
        customMblDropdown: function() {
            $(document).on('click', '.rg-custom-mbl-menu h2', function() {
                $(this).parent('.rg-custom-mbl-menu').toggleClass('active');
            });
        },
        addHeaderClass: function() {
            //header icon wrap remove spacing
            $('.rg-mobile-header-icon-wrap').each(function() {
                $(this).filter(function() {
                    return $.trim($(this).text()) === '' && $(this).children().length === 0
                }).remove();
            });
        },
        addPageHeaderClass: function() {
            if ($(".lm-site-header-section").length != 0) {
                $('body').addClass('lm-site-header-section-enabled');
            }
        },
        randomPostCatClass: function() {
            if (wp_main_js_obj.rg_blog_category_color == 'cat_color_random') {
                var classes = ['cat-green', 'cat-emerald', 'cat-blue', 'cat-violet', 'cat-salmon', 'cat-magenta', 'cat-sky', 'cat-sapphire', 'cat-brown', 'cat-red'];
                $('.cat-links a').addClass('cat');
                $('.cat-links a').each(function() {
                    if (classes.length === 0)
                        return false; // break jQuery each

                    var index = Math.floor(Math.random() * classes.length);
                    var className = classes[index];

                    $(this).addClass(className);
                });
            }
        },
        galleryPostSlider: function() {

            $('.archive-rg-gallery-post .gallery').each(function() {
                var obj_rtl;
                if ($('body').hasClass("rtl")) {
                    obj_rtl = true;
                } else {
                    obj_rtl = false;
                }

                $('.post_format-post-format-gallery:not(.thumbnail-view) .archive-rg-gallery-post .gallery').slick({
                    infinite: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    nextArrow: '<button class="slick-next slick-arrow"><i class="far fa-angle-right"></i></button>',
                    prevArrow: '<button class="slick-prev slick-arrow"><i class="far fa-angle-left"></i></button>',
                    rtl: obj_rtl,
                    responsive: [{
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
                });
            });

            $('.thumbnail-view .archive-rg-gallery-post .gallery').each(function() {
                var obj_rtl;
                if ($('body').hasClass("rtl")) {
                    obj_rtl = true;
                } else {
                    obj_rtl = false;
                }

                $('.thumbnail-view .archive-rg-gallery-post .gallery').slick({
                    infinite: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    nextArrow: '<button class="slick-next slick-arrow"><i class="far fa-angle-right"></i></button>',
                    prevArrow: '<button class="slick-prev slick-arrow"><i class="far fa-angle-left"></i></button>',
                    rtl: obj_rtl
                });
            });
        },
        passwordEyeInit: function() {
            var $eye = $('.password-eye');

            $eye.on('click', function(event) {
                event.preventDefault();
                var $self = jQuery(this);

                var $input = $self.next('input');

                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');

                    $self.addClass('fa-eye-slash');
                    $self.removeClass('fa-eye');
                } else {
                    $input.attr('type', 'password');
                    $self.removeClass('fa-eye-slash');
                    $self.addClass('fa-eye');
                }

            });

        },
        singinPopupInit: function() {
            $('.rg-login-btn-wrap .btn-login').on('click', function(event) {
                if (jQuery(this).attr('href') == '#') {
                    event.preventDefault();
                    $('#registration-login-form-popup').addClass('reign-window-popup-open');
                    $('#registration-login-form-popup .nav-tabs a.nav-link').removeClass('active');
                    $('#registration-login-form-popup .tab-content .tab-pane').removeClass('active');
                    $('#registration-login-form-popup .nav-tabs .nav-login-link').addClass('active');
                    var login_pannel = $('#registration-login-form-popup .nav-tabs .nav-login-link').attr('href');
                    if (typeof login_pannel !== 'undefined') {
                        $(login_pannel).addClass('active');
                    } else {
                        $('.tab-content .tab-pane').addClass('active');
                    }
                    $('.reign-overflow-x-wrapper').show();
                    $('body').addClass('modal-active');

                }
            });
        },
        registerPopupInit: function() {
            $('.rg-register-btn-wrap .btn-register').on('click', function(event) {
                if (jQuery(this).attr('href') == '#') {
                    event.preventDefault();
                    $('#registration-login-form-popup').addClass('reign-window-popup-open');

                    $('#registration-login-form-popup .nav-tabs a.nav-link').removeClass('active');
                    $('#registration-login-form-popup .tab-content .tab-pane').removeClass('active');
                    $('#registration-login-form-popup .nav-tabs .nav-register-link').addClass('active');
                    var login_pannel = $('#registration-login-form-popup .nav-tabs .nav-register-link').attr('href');
                    if (typeof login_pannel !== 'undefined') {
                        $(login_pannel).addClass('active');
                    } else {
                        $('.tab-content .tab-pane').addClass('active');
                    }

                    $('.reign-overflow-x-wrapper').show();
                    $('body').addClass('modal-active');

                }
            });
        },
        singinTabInit: function() {
            $('#registration-login-form-popup .nav-tabs a.nav-link').on('click', function(event) {
                event.preventDefault();
                $('#registration-login-form-popup .nav-tabs a.nav-link').removeClass('active');
                $('#registration-login-form-popup .tab-content .tab-pane').removeClass('active');
                $(this).addClass('active');
                var login_pannel = $(this).attr('href');
                $(login_pannel).addClass('active');
            });
        },
        closePopupInit: function() {
            $('.reign-close-popup').on('click', function(event) {

                var id = $(event.target).data('id');
                if (id == 'registration-login-form-popup') {
                    event.preventDefault();
                    $('#' + id).removeClass('reign-window-popup-open');
                    $('.reign-overflow-x-wrapper').hide();
                    $('body').removeClass('modal-active');
                }
            });
        },
        LoginFormSubmit: function() {
            jQuery('.reign-sign-form-login.reign-sign-form').on('submit', function(event) {
                event.preventDefault();

                var _this = this;
                var $form = jQuery(this);

                var handler = $form.data('handler');
                var $messages = $form.find('.reign-sign-form-messages');

                if (!handler) {
                    return;
                }

                var prepared = {
                    action: handler
                };

                var data = $form.serializeArray();

                jQuery.each(data, function(i, field) {
                    if (Array.isArray(prepared[field.name])) {
                        prepared[field.name].push(field.value);
                    } else if (typeof prepared[field.name] !== 'undefined') {
                        var val = prepared[field.name];
                        prepared[field.name] = new Array();
                        prepared[field.name].push(val);
                        prepared[field.name].push(field.value);
                    } else {
                        prepared[field.name] = field.value;
                    }
                });

                jQuery.ajax({
                    url: wp_main_js_obj.ajaxurl,
                    dataType: 'json',
                    type: 'POST',
                    data: prepared,

                    beforeSend: function() {
                        $form.addClass('loading');

                        //Clear old errors
                        $messages.empty();
                        $form.find('.invalid-feedback').remove();
                        $form.find('.is-invalid, .has-errors').removeClass('is-invalid has-errors');
                    },
                    success: function(response) {

                        $form.removeClass('loading');
                        if (response.success) {
                            //Prevent double form submit during redirect							
                            if (response.data.redirect_to) {
                                location.replace(response.data.redirect_to);
                                return;
                            }

                            if (response.data.email_sent) {
                                $form.find('.reign-sign-form-register-fields').css('display', 'none');
                                $form.closest('.registration-login-form').css('min-height', '360px');
                                $form.closest('.registration-login-form').css('padding-left', '0');
                                $form.closest('.tab-pane').find('.title').css('display', 'none');
                                $form.closest('.tab-pane').find('.title').css('display', 'none');
                                $form.closest('.registration-login-form').find('.nav-tabs').css('display', 'none');
                                jQuery('html, body').animate({
                                    scrollTop: $form.offset().top - 140
                                }, 1000);
                                return;
                            }

                            location.reload();
                            return;
                        }

                        if (response.data.message) {
                            var $msg = jQuery('<li class="error" />');
                            $msg.html(response.data.message);
                            $msg.appendTo($messages);
                            return;
                        }

                        if (response.data.errors) {

                            var errors = response.data.errors;
                            $form.find('.invalid-feedback').remove();
                            $form.find('.is-invalid, .has-errors').removeClass('is-invalid has-errors');

                            for (var key in errors) {
                                var $field = jQuery('[name="' + key + '"]', $form);
                                var $group = $field.closest('.form-group');
                                var $error = jQuery('<div class="invalid-feedback" />').appendTo($field.parent());

                                $error.text(errors[key]);
                                $field.addClass('is-invalid');
                                $group.addClass('has-errors');
                            }
                        }

                    },
                    error: function(jqXHR, textStatus) {
                        $form.removeClass('loading');
                        alert(textStatus);
                    }
                });

            });
        },
        RegisterFormSubmit: function() {
            jQuery('.reign-sign-form-register.reign-sign-form').on('submit', function(event) {
                event.preventDefault();

                var _this = this;
                var $form = jQuery(this);

                var handler = $form.data('handler');
                var $messages = $form.find('.reign-sign-form-messages');

                if (!handler) {
                    return;
                }

                var prepared = {
                    action: handler
                };

                var data = $form.serializeArray();

                jQuery.each(data, function(i, field) {
                    if (Array.isArray(prepared[field.name])) {
                        prepared[field.name].push(field.value);
                    } else if (typeof prepared[field.name] !== 'undefined') {
                        var val = prepared[field.name];
                        prepared[field.name] = new Array();
                        prepared[field.name].push(val);
                        prepared[field.name].push(field.value);
                    } else {
                        prepared[field.name] = field.value;
                    }
                });

                jQuery.ajax({
                    url: wp_main_js_obj.ajaxurl,
                    dataType: 'json',
                    type: 'POST',
                    data: prepared,

                    beforeSend: function() {
                        $form.addClass('loading');

                        //Clear old errors
                        $messages.empty();
                        $form.find('.invalid-feedback').remove();
                        $form.find('.is-invalid, .has-errors').removeClass('is-invalid has-errors');
                    },
                    success: function(response) {

                        $form.removeClass('loading');
                        if (response.success) {
                            //Prevent double form submit during redirect							
                            if (response.data.redirect_to) {
                                location.replace(response.data.redirect_to);
                                return;
                            }

                            if (response.data.email_sent) {
                                $form.find('.reign-sign-form-register-fields').css('display', 'none');
                                $form.closest('.registration-login-form').css('min-height', '360px');
                                $form.closest('.registration-login-form').css('padding-left', '0');
                                $form.closest('.tab-pane').find('.title').css('display', 'none');
                                $form.closest('.tab-pane').find('.title').css('display', 'none');
                                $form.closest('.registration-login-form').find('.nav-tabs').css('display', 'none');
                                jQuery('html, body').animate({
                                    scrollTop: $form.offset().top - 140
                                }, 1000);
                                return;
                            }

                            location.reload();
                            return;
                        }

                        if (response.data.message) {
                            var $msg = jQuery('<li class="error" />');
                            $msg.html(response.data.message);
                            $msg.appendTo($messages);
                            return;
                        }

                        if (response.data.errors) {

                            var errors = response.data.errors;
                            $form.find('.invalid-feedback').remove();
                            $form.find('.is-invalid, .has-errors').removeClass('is-invalid has-errors');

                            for (var key in errors) {
                                var $field = jQuery('[name="' + key + '"]', $form);
                                var $group = $field.closest('.form-group');
                                var $error = jQuery('<div class="invalid-feedback" />').appendTo($field.parent());

                                $error.text(errors[key]);
                                $field.addClass('is-invalid');
                                $group.addClass('has-errors');
                            }
                        }

                    },
                    error: function(jqXHR, textStatus) {
                        $form.removeClass('loading');
                        alert(textStatus);
                    }
                });

            });
        },
        scrollUp: function() {
            if (wp_main_js_obj.reign_enable_scrollup == true && wp_main_js_obj.reign_scrollup_style == 'style1') {
                $.scrollUp({
                    scrollName: 'scrollUp', // Element ID
                    scrollDistance: 300, // Distance from top/bottom before showing element (px)
                    scrollFrom: 'top', // 'top' or 'bottom'
                    scrollSpeed: 300, // Speed back to top (ms)
                    easingType: 'linear', // Scroll to top easing (see http://easings.net/)
                    animation: 'fade', // Fade, slide, none
                    animationInSpeed: 200, // Animation in speed (ms)
                    animationOutSpeed: 200, // Animation out speed (ms)
                    scrollText: '<svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102"><path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/></svg>', // Text for element, can contain HTML
                    scrollTitle: false, // Set a custom <a> title if required. Defaults to scrollText
                    scrollImg: false, // Set true to use image
                    activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
                    zIndex: 2147483647 // hahaha, that is some z index. Not required to have this value but nothing wrong to have it Z-Index for the overlay
                });

                // Scroll back to top animation.
                var progressPath = document.querySelector('#scrollUp path');
                var pathLength = progressPath.getTotalLength();
                progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
                progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
                progressPath.style.strokeDashoffset = pathLength;
                progressPath.getBoundingClientRect();
                progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';		
                var updateProgress = function () {
                    var scroll = $(window).scrollTop();
                    var height = $(document).height() - $(window).height();
                    var progress = pathLength - (scroll * pathLength / height);
                    progressPath.style.strokeDashoffset = progress;
                }
                updateProgress();
                $(window).scroll(updateProgress);
                var offset = 50;
                var duration = 550;
                $(window).on('scroll', function() {
                    if ($(this).scrollTop() > offset) {
                        $('#scrollUp').addClass('active-progress');
                    } else {
                        $('#scrollUp').removeClass('active-progress');
                    }
                });	
            }

            if (wp_main_js_obj.reign_enable_scrollup == true && wp_main_js_obj.reign_scrollup_style == 'style2') {
                $.scrollUp({
                    scrollName: 'scrollUp2', // Element ID
                    scrollDistance: 300, // Distance from top/bottom before showing element (px)
                    scrollFrom: 'top', // 'top' or 'bottom'
                    scrollSpeed: 300, // Speed back to top (ms)
                    easingType: 'linear', // Scroll to top easing (see http://easings.net/)
                    animation: 'fade', // Fade, slide, none
                    animationInSpeed: 200, // Animation in speed (ms)
                    animationOutSpeed: 200, // Animation out speed (ms)
                    scrollText: '<div class="scroll-top-bar-wrapper"><span class="scroll-text">Scroll to top</span><div class="scroll-top-bar"><div class="loading"></div></div></div>', // Text for element, can contain HTML
                    scrollTitle: false, // Set a custom <a> title if required. Defaults to scrollText
                    scrollImg: false, // Set true to use image
                    activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
                    zIndex: 2147483647 // hahaha, that is some z index. Not required to have this value but nothing wrong to have it Z-Index for the overlay
                });

                var offset = 0;
                $(document).scroll(function(){
                    offset = Math.floor($(window).scrollTop() / ($(document).height() - $(window).height())* 100) ;
                    $('.loading').css('height',offset + '%');
                });

            }
        },
        mediaPress: function() {
            /**
             * Activity upload Form handling
             * Prepend the upload buttons to Activity form
             */
            if (wp_main_js_obj.theme_package_id === 'nouveau') {
                $('.activity-update-form #whats-new-form').append($('#mpp-activity-upload-buttons'));
            }
        },
        postSocialShare: function() {
            var headerHeight = $( '#masthead' ).height();
			var headerHeightExt = headerHeight + 55;

			if ( $( window ).width() > 768 ) {
				$( '.content-wrapper > .reign-social-box-wrap' ).stick_in_parent( { offset_top: headerHeightExt, spacer: false } );
			} else {
                $( '.content-wrapper > .reign-social-box-wrap' ).trigger( "sticky_kit:detach" );
            }

            $( window ).resize( function () {
				if ( $( window ).width() > 768 ) {
                    $( '.content-wrapper > .reign-social-box-wrap' ).stick_in_parent( { offset_top: headerHeightExt, spacer: false } );
                } else {
                    $( '.content-wrapper > .reign-social-box-wrap' ).trigger( "sticky_kit:detach" );
                }
			} );
              
        },
    };

    $(document).on('ready', function() {
        Reign.init();
    });

})(jQuery);

/* topbar first time render fix */
jQuery(document).ready(function() {
    if (jQuery('div#wbcom-header-topbar').length) {
        var topbar_height = jQuery('div#wbcom-header-topbar').height();
        var headerHeight = topbar_height + 32;

        var header_height = jQuery('.rg-sticky-menu #masthead.sticky-header').height();
        var body_padding_top = topbar_height + header_height;

        jQuery('.rg-header-top-bar #wbcom-header-topbar').show();
        jQuery('.rg-header-top-bar.rg-sticky-menu #masthead.sticky-header').css("top", topbar_height + "px");
        jQuery('.admin-bar.rg-header-top-bar.rg-sticky-menu #masthead.sticky-header').css("top", headerHeight + "px");
        jQuery('.rg-sticky-menu').css("padding-top", header_height + "px");
        jQuery('.rg-header-top-bar.rg-sticky-menu').css("padding-top", body_padding_top + "px");
    }
});

// Reign Sticky Topbar
jQuery(document).ready(function() {
    if (jQuery('.reign-header-top').length) {
        var admin_bar_height = 32;
        var reign_topbar_height = jQuery('.reign-header-top').height();

        jQuery('body.admin-bar.reign-sticky-topbar .reign-header-top').css("top", admin_bar_height + "px");
        jQuery('.reign-sticky-topbar #masthead').css("top", reign_topbar_height + 10 + "px");
    }
});

jQuery(window).on('resize', function() {
    if (jQuery('.reign-header-top').length) {
        var admin_bar_height = 32;
        var reign_topbar_height = jQuery('.reign-header-top').height();

        jQuery('body.admin-bar.reign-sticky-topbar .reign-header-top').css("top", admin_bar_height + "px");
        jQuery('.reign-sticky-topbar #masthead').css("top", reign_topbar_height + 10 + "px");
    }
});


// Reign Mobile Header Resize
jQuery(window).on('resize', function() {

    var body = jQuery('body');
    site_mobile_header = jQuery('.reign-fallback-header.header-mobile');
    if (jQuery('.reign-header-top').length) {
        var reign_topbar_height = jQuery('.reign-header-top').outerHeight();
    }

    if (jQuery('#wbcom-header-topbar').length) {
        var reign_ele_topbar_height = jQuery('#wbcom-header-topbar').outerHeight();
    }

    if (window.innerWidth < 960) {

        // Fixed top
        if (site_mobile_header.hasClass('fixed-top')) {
            var lastScrollTop = 0;
            jQuery(window).on('scroll', function() {
                if (jQuery(this).scrollTop() > 50) {
                    site_mobile_header.addClass('nav-scrolling');
                    if (jQuery(this).scrollTop() > lastScrollTop) {
                        site_mobile_header.addClass('to-bottom');
                        site_mobile_header.removeClass('to-top');
                    } else {
                        site_mobile_header.addClass('to-top');
                        site_mobile_header.removeClass('to-bottom');
                    }
                    lastScrollTop = jQuery(this).scrollTop();
                } else {
                    site_mobile_header.removeClass('nav-scrolling');
                }
            });
        }

        // Fixed top scrolling
        if (site_mobile_header.hasClass('fixed-top')) {

            if (site_mobile_header.hasClass('nav-scrolling') && site_mobile_header.hasClass('to-bottom')) {
                if (body.hasClass('admin-bar')) {
                    site_mobile_header.css({ top: (jQuery('#wpadminbar').outerHeight() - jQuery('.reign-nav-top-bar').outerHeight()) });

                    site_mobile_header.css("marginTop", 0 + "px");
                } else {
                    site_mobile_header.css({ top: jQuery('.reign-nav-top-bar').outerHeight() * -1 });

                    site_mobile_header.css("marginTop", 0 + "px");
                }
            } else {
                site_mobile_header.removeAttr('style');

                site_mobile_header.css("marginTop", reign_topbar_height + "px");

                site_mobile_header.css("marginTop", reign_ele_topbar_height + "px");
            }

            jQuery(window).on('scroll', function() {
                if (site_mobile_header.hasClass('nav-scrolling') && site_mobile_header.hasClass('to-bottom')) {
                    if (body.hasClass('admin-bar')) {
                        site_mobile_header.css({ top: (jQuery('#wpadminbar').outerHeight() - jQuery('.reign-nav-top-bar').outerHeight()) });

                        site_mobile_header.css("marginTop", 0 + "px");
                    } else {
                        site_mobile_header.css({ top: jQuery('.reign-nav-top-bar').outerHeight() * -1 });

                        site_mobile_header.css("marginTop", 0 + "px");
                    }
                } else {
                    site_mobile_header.removeAttr('style');

                    site_mobile_header.css("marginTop", reign_topbar_height + "px");

                    site_mobile_header.css("marginTop", reign_ele_topbar_height + "px");
                }
            });
        }
    }

});
