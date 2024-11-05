( function ( $ ) {

    "use strict";

    window.ReignBuddyPress = {

        init: function () {
            this.Slider();
            this.toggleMoreOption();
            this.rtmediaText();
            this.buddupressMenu();
            this.showActivity();
            this.profileButtons();
            this.setCounters();
            this.UpdateNotification();
            this.groupsMobile();
            this.profileMenuToggle();
            this.directoryLayout();
            this.imageResize();
            this.bpTabMenu();
            if (wp_main_js_obj.bp_subnav_view_style == 'swipe') {
                this.bpSubnavSlider();
            }
            if (wp_main_js_obj.bp_subnav_view_style == 'more') {
                this.bpSubnavMore();
            }
            this.checkPassStrength();
        },

        Slider: function() {
            if (wp_main_js_obj.reign_rtl) {
                var rt = true;
            } else {
                var rt = false;
            }

            $('aside #members-carousel-list, aside #members-carousel-list-widget, aside #groups-carousel-list, aside #groups-carousel-list-widget, .youzify-sidebar #members-carousel-list, .youzify-sidebar #members-carousel-list-widget, .youzify-sidebar #groups-carousel-list, .youzify-sidebar #groups-carousel-list-widget').not('.slick-initialized').slick({
                slidesToShow: 1
            });

            $('#members-carousel-list, #members-carousel-list-widget, #groups-carousel-list, #groups-carousel-list-widget').not('.slick-initialized').slick({
                dots: false,
                slidesToShow: 4,
                slidesToScroll: 4,
                rtl: rt,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 543,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        },
        toggleMoreOption: function() {            
            
            $(document).on(
                'click',
                '.bp-activity-more-options-wrap .bp-activity-more-options-action',
                function(e) {
                    e.preventDefault();
                    var current = $(this).closest('.bp-activity-more-options-wrap');
                    current.siblings('.selected').removeClass('selected');
                    current.toggleClass('selected');
                }
            );

            $('body').mouseup(
                function(e) {
                    var container = $('.bp-activity-more-options-wrap *');
                    if (!container.is(e.target)) {
                        $('.bp-activity-more-options-wrap').removeClass('selected');
                    }
                }
            );
        },
        rtmediaText: function() {
            // rtmedia-activity-text
            $('.rtmedia-activity-text > span').each(function() {
                $(this).filter(function() {
                    return $.trim($(this).text()) === '' && $(this).children().length === 0
                }).remove();
            });
        },
        buddupressMenu: function() {
            $('.wbcom-nav-menu-toggle').click(function() {
                $(this).toggleClass('open');

            });

            // Filters
            var active = $('.rg-select-filter :selected').text();
            $('.rg-select-filter option').each(function() {
                var current = $(this).text();
                var activeClass = (current === active) ? 'current' : '';
                $('.rg-filters-wrap').append('<li class="' + activeClass + '"><a href="' + $(this).attr('value') + '">' + $(this).html() + '</a></li>');
            });

            $('.rg-filters-wrap').on('click', 'li a', function(e) {
                e.preventDefault();
                var value = $(this).attr('href');
                $('.rg-select-filter').val(value).change();
                $('.rg-filters-wrap li').removeClass('current');
                $('.rg-filters-wrap li').removeClass('selected');
                $(this).parent().addClass('current');
                return false;
            });

            // Member & Group front page widgets
            $(".member-front-page .bp-widget-area h4.widget-title").wrapInner('<span/>');
            $(".group-front-page .bp-widget-area h4.widget-title").wrapInner('<span/>');
        },
        showActivity: function() {
            $(document).on('click', '.widget_bp_reign_activity_widget div.pagination-links a', function(e) {
                e.preventDefault();
                var parent = $(this).parents('.widget_bp_reign_activity_widget').get(0);
                parent = $(parent); //cast as jquery object
                var page = get_var_in_url($(this).attr('href'), 'acpage');
                var scope = $('#reign_scope').val();
                fetch_and_show_activity(page, scope, parent);
            });

            function get_var_in_url(url, name) {
                var urla = url.split('?');
                var qvars = urla[1].split('&'); //so we have an arry of name=val,name=val
                for (var i = 0; i < qvars.length; i++) {
                    var qv = qvars[i].split('=');
                    if (qv[0] === name)
                        return qv[1];
                }
            }

            function fetch_and_show_activity(page, scope, local_scope) {
                local_scope = $(local_scope);
                var per_page = $("#reign_per_page", local_scope).val();
                var max_items = $("#reign_max_items", local_scope).val();
                var included_components = $("#reign_included_components", local_scope).val();
                var excluded_components = $("#reign_excluded_components", local_scope).val();
                var show_avatar = $("#reign_show_avatar", local_scope).val();
                var show_content = $("#reign_show_content", local_scope).val();
                var show_filters = $("#reign_show_filters", local_scope).val();
                var is_personal = $("#reign_is_personal", local_scope).val();
                var is_blog_admin_activity = $("#reign_is_blog_admin_activity", local_scope).val();
                var show_post_form = $("#reign_show_post_form", local_scope).val();
                var activity_words_count = $("#reign-activity-words-count", local_scope).val();
                $.post(wp_main_js_obj.ajaxurl, {
                        action: 'reign_fetch_content',
                        cookie: encodeURIComponent(document.cookie),
                        page: page,
                        scope: scope,
                        max: max_items,
                        per_page: per_page,
                        show_avatar: show_avatar,
                        show_content: show_content,
                        show_filters: show_filters,
                        is_personal: is_personal,
                        is_blog_admin_activity: is_blog_admin_activity,
                        included_components: included_components,
                        excluded_components: excluded_components,
                        show_post_form: show_post_form,
                        original_scope: $('#reign-original-scope').val(),
                        activity_words_count: activity_words_count,
                        allow_comment: $('#reign-activity-allow-comment').val()
                    },
                    function(response) {
                        $(".reign-wrap", local_scope).replaceWith(response);
                        $('form.reign-ac-form').hide();
                        $("#activity-filter-links li#afilter-" + scope, local_scope).addClass("selected");
                    });
            }

            //for filters
            $(document).on('click', '.widget_bp_reign_activity_widget #activity-filter-links li a', function() {
                var parent = $(this).parents('.widget_bp_reign_activity_widget').get(0);
                parent = $(parent);
                var page = 1;
                var scope = '';
                if ($(this).parent().attr('id') === 'afilter-clear') {
                    scope = $('#reign-original-scope', parent).val();
                } else {
                    scope = get_var_in_url($(this).attr('href'), 'afilter');
                }

                //update the dom scope
                $('#reign-scope').val(scope);
                fetch_and_show_activity(page, scope, parent);
                //make the current filter selected
                return false;
            });
        },
        profileButtons: function() {
            $('.rg-item-buttons').on("click", function(event) {
                event.stopPropagation();
                $(this).toggleClass('active');
            });

            $("body").on("click", function(event) {
                $('.rg-item-buttons').removeClass('active'); // or something...
            });
        },
        setCounters: function() {
            $('#wp-admin-bar-my-account-buddypress').find('li').each(function() {
                var $this = $(this),
                    $count = $this.children('a').children('.count'),
                    id,
                    $target;
                if ($count.length != 0) {
                    id = $this.attr('id');
                    $target = $('.bp-menu.bp-' + id.replace(/wp-admin-bar-my-account-/, '') + '-nav');
                    if ($target.find('.count').length == 0) {
                        $target.find('a').append('<span class="count">' + $count.html() + '</span>');
                    }
                }
            });
        },
        UpdateNotification: function() {

            //Notifications related updates
            $(document).on('heartbeat-tick.reign_notification_count', function(event, data) {

                if (data.hasOwnProperty('reign_notification_count')) {
                    data = data['reign_notification_count'];
                    /********notification type**********/
                    if (data.notification > 0) { //has count
                        jQuery("#ab-pending-notifications").text(data.notification).removeClass("no-alert");
                        jQuery("#ab-pending-notifications-mobile").text(data.notification).removeClass("no-alert");
                        jQuery("#wp-admin-bar-my-account-notifications .ab-item[href*='/notifications/']").each(function() {
                            jQuery(this).append("<span class='count'>" + data.notification + "</span>");
                            if (jQuery(this).find(".count").length > 1) {
                                jQuery(this).find(".count").first().remove(); //remove the old one.
                            }
                        });
                    } else {
                        jQuery("#ab-pending-notifications").text(data.notification).addClass("no-alert");
                        jQuery("#ab-pending-notifications-mobile").text(data.notification).addClass("no-alert");
                        jQuery("#wp-admin-bar-my-account-notifications .ab-item[href*='/notifications/']").each(function() {
                            jQuery(this).find(".count").remove();
                        });
                    }
                    //remove from read ..
                    jQuery(".mobile #wp-admin-bar-my-account-notifications-read, #adminbar-links #wp-admin-bar-my-account-notifications-read").each(function() {
                        $(this).find("a").find(".count").remove();
                    });
                    /**********messages type************/
                    if (data.unread_message > 0) { //has count
                        jQuery("#user-messages").find("span").text(data.unread_message);
                        jQuery(".ab-item[href*='/messages/']").each(function() {
                            jQuery(this).append("<span class='count'>" + data.unread_message + "</span>");
                            if (jQuery(this).find(".count").length > 1) {
                                jQuery(this).find(".count").first().remove(); //remove the old one.
                            }
                        });
                    } else {
                        jQuery("#user-messages").find("span").text(data.unread_message);
                        jQuery(".ab-item[href*='/messages/']").each(function() {
                            jQuery(this).find(".count").remove();
                        });
                    }
                    //remove from unwanted place ..
                    jQuery(".mobile #wp-admin-bar-my-account-messages-default, #adminbar-links #wp-admin-bar-my-account-messages-default").find("li:not('#wp-admin-bar-my-account-messages-inbox')").each(function() {
                        jQuery(this).find("span").remove();
                    });
                    /**********messages type************/
                    if (data.friend_request > 0) { //has count
                        jQuery(".ab-item[href*='/friends/']").each(function() {
                            jQuery(this).append("<span class='count'>" + data.friend_request + "</span>");
                            if (jQuery(this).find(".count").length > 1) {
                                jQuery(this).find(".count").first().remove(); //remove the old one.
                            }
                        });
                    } else {
                        jQuery(".ab-item[href*='/friends/']").each(function() {
                            jQuery(this).find(".count").remove();
                        });
                    }
                    //remove from unwanted place ..
                    jQuery(".mobile #wp-admin-bar-my-account-friends-default, #adminbar-links #wp-admin-bar-my-account-friends-default").find("li:not('#wp-admin-bar-my-account-friends-requests')").each(function() {
                        jQuery(this).find("span").remove();
                    });

                    //notification content
                    //jQuery( ".user-notifications .rg-notify li" ).html( data.notification_content );
                    jQuery(".user-notifications .rg-count").html(data.notification);
                    if (data) {
                        jQuery('#wp-admin-bar-bp-notifications-default').empty();
                        jQuery('.user-notifications #rg-notify').empty();

                        jQuery.each(data.notification_content, function(i, value) {
                            jQuery('#wp-admin-bar-bp-notifications-default').append('<li>' + value + '</li>');
                            jQuery("#wp-admin-bar-bp-notifications-default a").each(function() {
                                jQuery(this).addClass('ab-item');
                            });
                        });

                        //jQuery('.user-notifications .rg-notify li:not(.rg-view-all)').remove();
                        jQuery.each(data.notification_content, function(i, value) {
                            jQuery('.user-notifications #rg-notify').append('<li>' + value + '</li>');
                        });
                    }

                }
            });
        },
        groupsMobile: function() {
            var win = $(window);
            var groupElem = $('.widget-groups-by, .widget-groups-orderby, .widget-groups-groupby');
            var activityElem = $('.widget-activity-nav, .widget-activity-subnav');
            var membersElem = $('.widget-members-nav, .widget-members-subnav');

            if (win.width() < 544) {
                if ($("#mobile-view-aside").length == 0) {
                    $('<aside id="mobile-view-aside"></aside>').insertBefore('.groups.dir-list');
                }

                if (win.width() < 544) {
                    groupElem.prependTo('#mobile-view-aside');
                    activityElem.insertAfter('.activity-content-area .entry-header');
                    membersElem.insertAfter('.members-content-area .entry-header');

                } else {
                    groupElem.prependTo('#left');
                    activityElem.prependTo('#left');
                    membersElem.prependTo('#left');
                }
            }

            $(window).on('resize', function() {
                var win = $(window); //this = window

                if (win.width() < 544) {
                    groupElem.prependTo('#mobile-view-aside');
                    activityElem.insertAfter('.activity-content-area .entry-header');
                    membersElem.insertAfter('.members-content-area .entry-header');

                } else {
                    groupElem.prependTo('#left');
                    activityElem.prependTo('#left');
                    membersElem.prependTo('#left');
                }
            });
        },
        profileMenuToggle: function() {
            // Dropdown toggle
            $('div.wbtm-show-item-buttons').click(function() {
                $(this).next('#item-buttons').toggle();
            });

            $(document).click(function(e) {
                var target = e.target;
                if (!$(target).is('div.wbtm-show-item-buttons') && !$(target).parents().is('div.wbtm-show-item-buttons')) {
                    $('.bp-legacy #item-buttons').hide();
                }
            });
        },
        directoryLayout: function() {
            $('.bp-legacy .wbtm-member-directory-type-4 .action .generic-button').find('a').contents().wrap('<span/>');
            $('.bp-legacy.manage-members .wbtm-member-directory-type-4 .action > div').find('a.button').contents().wrap('<span/>');
            $('.bp-legacy .wbtm-group-directory-type-4 .action .generic-button').find('a').contents().wrap('<span/>');
        },
        imageResize: function() {

            var photoContainer = $(".grid .aspect-ratio .img-card");

            photoContainer.each(function() {
                var wrapperWidth = $(this).width();
                var wrapperHeight = $(this).height();
                var wrapperRatio = wrapperWidth / wrapperHeight;

                var imageWidth = $(this).find("img").width();
                var imageHeight = $(this).find("img").height();
                var imageRatio = imageWidth / imageHeight;

                /*if (wrapperWidth === 0 || wrapperHeight === 0) {
                 return false;
                 }*/

                if (imageRatio <= wrapperRatio) {
                    var newImageHeight = wrapperWidth / imageRatio;
                    var newImageWidth = wrapperWidth;
                    var semiImageHeight = newImageHeight / 2;

                    $(this).find("img").css({
                        width: newImageWidth + 1,
                        height: newImageHeight + 1,
                        marginTop: -semiImageHeight,
                        marginLeft: 0,
                        top: "50%",
                        left: "0"
                    });

                } else {
                    var newImageHeight = wrapperHeight;
                    var newImageWidth = wrapperHeight * imageRatio;
                    var semiImageWidth = newImageWidth / 2;

                    $(this).find("img").css({
                        width: newImageWidth + 1,
                        height: newImageHeight + 1,
                        marginTop: 0,
                        marginLeft: -semiImageWidth,
                        top: "0",
                        left: "50%"
                    });
                }

                $(this).css("opacity", "1");

            });
        },
        bpTabMenu: function() {

            if (wp_main_js_obj.reign_rtl) {
                var rt = true;
            } else {
                var rt = false;
            }

            $('.rg-nouveau-sidebar-menu.reign-nav-more .main-navs:not(.vertical) ul').BuddyPressMenu(35);

            var slickGoTo = $('.rg-nouveau-sidebar-menu.reign-nav-swipe .main-navs:not(.vertical) ul li.selected').index();

            $('.rg-nouveau-sidebar-menu.reign-nav-swipe .main-navs:not(.vertical) ul').slick({
                slidesToScroll: 1,
                nextArrow: '<button class="slick-next slick-arrow reign-nav-swipe-arrow"><i class="far fa-angle-right"></i></button>',
                prevArrow: '<button class="slick-prev slick-arrow reign-nav-swipe-arrow"><i class="far fa-angle-left"></i></button>',
                infinite: false,
                swipeToSlide: true,
                variableWidth: true,
                rtl: rt,
                dots: false,
                touchMove: true,
            });
            if (slickGoTo !== 0) {
                slickGoTo = slickGoTo - 0;
            }
            $('.rg-nouveau-sidebar-menu.reign-nav-swipe .main-navs:not(.vertical) ul').slick('slickGoTo', slickGoTo);
            

            $(document).on('click', '.rg-nouveau-sidebar-menu .more-button', function(e) {
                e.preventDefault();
                $(this).toggleClass('active').next().toggleClass('active');
            });

            $(document).on('click', '.rg-nouveau-sidebar-menu .hideshow .sub-menu a', function(e) {
                //e.preventDefault();
                $('body').trigger('click');

                // add 'current' and 'selected' class
                var currentLI = $(this).parent();
                currentLI.parent('.rg-nouveau-sidebar-menu .sub-menu').find('li').removeClass('current selected');
                currentLI.addClass('current selected');
            });

            $(document).click(function(e) {
                var container = $('.rg-nouveau-sidebar-menu .more-button, .rg-nouveau-sidebar-menu .sub-menu');
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $('.rg-nouveau-sidebar-menu .more-button').removeClass('active').next().removeClass('active');
                }
            });

        },
        bpSubnavSlider: function() {
            $(document).ready(function() {
                var rt = wp_main_js_obj.reign_rtl ? true : false; // Determine RTL setting

                // Function to initialize the slick slider
                function initializeSlick() {
                    $('.item-body-inner-wrapper > .bp-subnavs .subnav').not('.slick-initialized').slick({
                        dots: false,
                        nextArrow: '<button class="slick-next slick-arrow reign-nav-swipe-arrow"><i class="far fa-angle-right"></i></button>',
                        prevArrow: '<button class="slick-prev slick-arrow reign-nav-swipe-arrow"><i class="far fa-angle-left"></i></button>',
                        infinite: false,
                        swipeToSlide: true,
                        variableWidth: true,
                        rtl: rt,
                    });
                }

                // Function to unslick the slider
                function unslickSlider() {
                    $('.item-body-inner-wrapper > .bp-subnavs .subnav.slick-initialized').slick('unslick');
                }

                // Initialize slick slider based on window width
                if (window.innerWidth < 748.8) {
                    initializeSlick();
                }

                // Scroll function to check window width on scroll
                $(window).scroll(function() {
                    // Check window width again when the user scrolls
                    if (window.innerWidth < 748.8) {
                        if (!$('.item-body-inner-wrapper > .bp-subnavs .subnav').hasClass('slick-initialized')) {
                            initializeSlick();
                        }
                    } else {
                        unslickSlider();
                    }
                });
            });
        },
        bpSubnavMore: function() {
            // Function to handle BuddyPressMenu initialization based on window width
            function handleBuddyPressMenu() {
                if (window.innerWidth < 748.8) {
                    $('.item-body-inner-wrapper > .bp-subnavs ul.subnav').addClass('more');
                    $('.item-body-inner-wrapper > .bp-subnavs ul.subnav.more').BuddyPressMenu(35);
                } else {
                    $('.item-body-inner-wrapper > .bp-subnavs ul.subnav').removeClass('more');
                    $('.item-body-inner-wrapper > .bp-subnavs ul.subnav.more').off('.BuddyPressMenu'); // Unbind BuddyPressMenu events
                }
            }

            // Initial execution on document ready
            $(document).ready(function() {
                handleBuddyPressMenu(); // Call the function initially
            });

            // Resize event handling
            $(window).resize(function() {
                // Execute the function whenever the window is resized
                handleBuddyPressMenu();
            });

            $(document).on('click', '.item-body-inner-wrapper .bp-subnavs ul.subnav .more-button', function(e) {
                e.preventDefault();
                $(this).toggleClass('active').next().toggleClass('active');
            });

            $(document).on('click', '.item-body-inner-wrapper .bp-subnavs ul.subnav .hideshow .sub-menu a', function(e) {
                //e.preventDefault();
                $('body').trigger('click');

                // add 'current' and 'selected' class
                var currentLI = $(this).parent();
                currentLI.parent('.item-body-inner-wrapper .bp-subnavs ul.subnav .sub-menu').find('li').removeClass('current selected');
                currentLI.addClass('current selected');
            });

            $(document).click(function(e) {
                var container = $('.item-body-inner-wrapper .bp-subnavs ul.subnav .more-button, .item-body-inner-wrapper .bp-subnavs ul.subnav .sub-menu');
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $('.item-body-inner-wrapper .bp-subnavs ul.subnav .more-button').removeClass('active').next().removeClass('active');
                }
            });
        },
        checkPassStrength: function() {
            function check_pass_strength() {
                var pass1 = $( '.password-entry' ).val(),
                    pass2 = $( '.password-entry-confirm' ).val(),
                    strength;
        
                // Reset classes and result text
                $( '#pass-strength-result' ).removeClass( 'short bad good strong' );
                if ( ! pass1 ) {
                    $( '#pass-strength-result' ).html( pwsL10n.empty );
                    return;
                }
        
                strength = wp.passwordStrength.meter( pass1, wp.passwordStrength.userInputBlacklist(), pass2 );
        
                switch ( strength ) {
                    case 2:
                        $( '#pass-strength-result' ).addClass( 'bad' ).html( pwsL10n.bad );
                        break;
                    case 3:
                        $( '#pass-strength-result' ).addClass( 'good' ).html( pwsL10n.good );
                        break;
                    case 4:
                        $( '#pass-strength-result' ).addClass( 'strong' ).html( pwsL10n.strong );
                        break;
                    case 5:
                        $( '#pass-strength-result' ).addClass( 'short' ).html( pwsL10n.mismatch );
                        break;
                    default:
                        $( '#pass-strength-result' ).addClass( 'short' ).html( pwsL10n['short'] );
                        break;
                }
            }
        
            // Bind check_pass_strength to keyup events in the password fields
            $( document ).ready( function() {
                $( '.password-entry' ).val( '' ).keyup( check_pass_strength );
                $( '.password-entry-confirm' ).val( '' ).keyup( check_pass_strength );
            });
        },
    };

    $( document ).on( 'ready', function () {
        ReignBuddyPress.init();
    } );

} )( jQuery );


/* compatibilty with BP Create Type Plugin */
jQuery(document).ready(function() {
    jQuery('.wb-group-type-filters-wrap').on('click', 'li a', function(e) {
        e.preventDefault();
        var value = jQuery(this).attr('data-group-slug');
        jQuery('.wb-group-type-filters-wrap li').removeClass('current');
        jQuery(this).parent().addClass('current');

        var object = 'groups';
        bp_filter_request(
            object,
            jq.cookie('bp-' + object + '-filter'),
            jq.cookie('bp-' + object + '-scope'),
            'div.' + object,
            jQuery('#' + object + '_search').val(), //( '#bpgt-groups-search-text' ).val(),
            1,
            'group_type=' + value,
            '',
            ''
        );

        return false;
    });
});

/**
 * Managing action buttons of profile header for groups and memebers.
 */
jQuery(document).ready(function() {
    if (!(jQuery('.bp-legacy .wbtm-item-buttons-wrapper #item-buttons > div').length)) {
        jQuery('.bp-legacy .wbtm-item-buttons-wrapper').hide();
        jQuery('.bp-legacy .wbtm-cover-header-type-3 .wbtm-cover-extra-info-section').css("padding-bottom", 0);
    }
});