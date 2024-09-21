jQuery( document ).ready(function( $ ) {
	
	$( '.reign_load_more').hide();
	if ( jQuery(".reign_load_more").length > 0 ) {
		var $container = $('.wb-post-listing').infiniteScroll({
		  path: '.reign_load_more a',
		  append: 'article.post',
		  button:'.infinite-scroll-request',
		  status: '.page-load-status',
		});
	}
	
	var notification_queue = [];
	$( document ).on( "click", ".header-notifications-dropdown-menu .action-unread", function ( e ) {
		var data = {
			'action': 'reign_theme_unread_notification',
			'notification_id': $( this ).data( 'notification-id' )
		};
		if ( notification_queue.indexOf( $( this ).data( 'notification-id' ) ) !== -1 ) {
			return false;
		}
		notification_queue.push( $( this ).data( 'notification-id' ) );
		var notifs = $( '.bb-icon-bell-small' );
		var notif_icons = $( notifs ).parent().children( '.count' );
		if ( notif_icons.length > 0 ) {
			if ( $( this ).data( 'notification-id' ) !== 'all' ) {
				notif_icons.html( parseInt( notif_icons.html() ) - 1 );
			} else {
				if ( parseInt( $( 'header-notifications-dropdown-menu .dropdown-item-wrapper .dropdown-item' ).length ) < 10 ) {
					notif_icons.fadeOut();
				} else {
					notif_icons.html( parseInt( notif_icons.html() ) - parseInt( $( '.header-notifications-dropdown-menu .dropdown-item-wrapper .dropdown-item' ).length ) );
				}
			}
		}
		if ( $( '.header-notifications-dropdown-menu .dropdown-item-wrapper .dropdown-item' ).length !== 'undefined' && $( '.header-notifications-dropdown-menu .dropdown-item-wrapper .dropdown-item' ).length == 1 || $( this ).data( 'notification-id' ) === 'all' ) {
			$( '.header-notifications-dropdown-menu .dropdown-item-wrapper' ).html( '<p class="reign-header-loader"><i class="fa fa-spinner-third"></i></p>' );
		}
		if ( $( this ).data( 'notification-id' ) !== 'all' ) {
			$( this ).parent().parent().fadeOut();
			$( this ).parent().parent().remove();
		}
		$.post(
			wp_main_js_obj .ajaxurl,
			data,
			function ( response ) {
				var notifs = $( '.header-notifications-dropdown-toggle .far.fa-bell' );
				var notif_icons = $( notifs ).parent().children( '.rg-count' );
				if ( notification_queue.length === 1 && response.success && typeof response.data !== 'undefined' && typeof response.data.contents !== 'undefined' && $( '.header-notifications-dropdown-menu .dropdown-item-wrapper' ).length ) {
					$( '.header-notifications-dropdown-menu .dropdown-item-wrapper' ).html( response.data.contents );
				}
				if ( typeof response.data.total_notifications !== 'undefined' && response.data.total_notifications > 0 && notif_icons.length > 0 ) {
					$( notif_icons ).text( response.data.total_notifications );
					$( '.header-notifications-dropdown-menu .mark-read-all' ).show();
				} else {
					$( notif_icons ).text( response.data.total_notifications );
					$( '.header-notifications-dropdown-menu .mark-read-all' ).fadeOut();
				}
				var index = notification_queue.indexOf( $( this ).data( 'notification-id' ) );
				notification_queue.splice( index, 1 );
			}
		);
	});
		
});

(function ($) {
	"use strict";

	$(document).ready(function () {
		// accept/reject friend request.
		$(".reign-friendship-btn").stop().click(function (e) {
			e.preventDefault();
			var $this = $(this),
				friendshipId = $this.data("friendship-id"),
				dataAction = $this.hasClass("accept") ? "friends_accept_friendship" : "friends_reject_friendship";
			$.ajax({
				type: "POST",
				dataType: "json",
				url: ajaxurl,
				data: {
					action: "reign_ajax_addremove_friend",
					friendship_id: friendshipId,
					data_action: dataAction
				},
				success: function (data) {
					var response = data.data.feedback;
					$this.closest(".reign-friend-request").find(".response").html(response);
					if (data.success)
						$this.closest(".request-button").remove();

						console.log($this);
				}
			});
			return false;
		});
	});

}(jQuery));