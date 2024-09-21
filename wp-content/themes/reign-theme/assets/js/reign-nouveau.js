jQuery(document).ready(function() {

    /** rtMedia fix :: End **/

    //rtmedia-activity-text
    jQuery(document).ajaxComplete(function(event, xhr, options) {
        jQuery('.rtmedia-activity-text > span').each(function() {
            jQuery(this).filter(function() {
                return jQuery.trim(jQuery(this).text()) === '' && jQuery(this).children().length === 0
            }).remove();
        });
    });

    //Show video full width
    jQuery(document).ajaxComplete(function(event, xhr, options) {
        // LearnDash Player fix
        if ( jQuery( '.ld-video iframe' ).length > 0 ) {
            jQuery( '.ld-video iframe' ).addClass( 'fitvidsignore' );
        }

        // Tutor Player fix
        if ( jQuery( '.tutor-video-player iframe' ).length > 0 ) {
            jQuery( '.tutor-video-player iframe' ).addClass( 'fitvidsignore' );
        }

        jQuery("body.buddypress").fitVids();
    });

});

jQuery(window).load(function() {
    jQuery('.rg-nouveau-sidebar-menu.reign-nav-more .main-navs:not(.vertical) ul').each(function() {
        jQuery('body').addClass('rg-more-loaded');
    });
});

/** Members And Groups Directory Layout Four Action Button Tooltip Effect **/
function reign_nouveau_deParams(str) {
    return (str || document.location.search).replace(/(^\?)/, '').split("&").map(function(n) {
        return n = n.split("="), this[n[0]] = n[1], this
    }.bind({}))[0];
}

jQuery(document).ready(function() {

    setTimeout(function() {
        jQuery('.wbtm-member-directory-type-4 .action .generic-button').find('a').contents().wrap('<span/>');
        jQuery('.wbtm-member-directory-type-4 .action .generic-button').find('button').contents().wrap('<span/>');
        jQuery('.wbtm-group-directory-type-4 .action .generic-button').find('a').contents().wrap('<span/>');
        jQuery('.wbtm-group-directory-type-4 .action .generic-button').find('button').contents().wrap('<span/>');
    });

    jQuery('.reign-members-grid-widget li.friendship-button > .friendship-button, .reign-groups-grid-widget .generic-button .group-button').on('click', function() {
        var redirect_url = jQuery(this).attr('data-bp-nonce');
        window.location.href = redirect_url;
    });

    jQuery(document).ajaxComplete(function(event, xhr, settings) {
        var formdata = reign_nouveau_deParams(settings.data);
        var action = formdata['action'];
        var btn_id = formdata['item_id'];
        if ('members_filter' == action || 'groups_filter' == action) {
            setTimeout(function() {
                jQuery('.wbtm-member-directory-type-4 .action .generic-button').find('a').contents().wrap('<span/>');
                jQuery('.wbtm-member-directory-type-4 .action .generic-button').find('button').contents().wrap('<span/>');
                jQuery('.wbtm-group-directory-type-4 .action .generic-button').find('a').contents().wrap('<span/>');
                jQuery('.wbtm-group-directory-type-4 .action .generic-button').find('button').contents().wrap('<span/>');
            }, 2000);
        } else if ('friends_add_friend' == action || 'friends_withdraw_friendship' == action || 'friends_remove_friend' == action) {
            setTimeout(function() {
                jQuery('.wbtm-member-directory-type-4 #friend-' + btn_id).contents().wrap('<span/>');
            }, 2000);
        } else if ('groups_leave_group' == action || 'groups_join_group' == action) {
            setTimeout(function() {
                jQuery('.wbtm-group-directory-type-4 #groupbutton-' + btn_id + ' .group-button').contents().wrap('<span/>');
            }, 2000);
        }
    });

    if (jQuery('#buddypress').hasClass('bp-single-vert-nav')) {
        jQuery('.rg-nouveau-sidebar-menu').removeClass('reign-nav-swipe');
        jQuery('.rg-nouveau-sidebar-menu').removeClass('reign-nav-more');
    }

});

// BP Better Messages
jQuery(document).ready(function() {
    jQuery('.bp-better-messages-mini').insertAfter('.bp-better-messages-list');
});