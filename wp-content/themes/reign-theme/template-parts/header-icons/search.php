<?php
/**
 * Seach file
 *
 * @package reign
 */

$reign_header_layout = get_theme_mod( 'reign_header_layout', 'v1' );
?>

<div class="search-wrap rg-icon-wrap">
	<span class="rg-search-icon far fa-search"></span>
	<div class="rg-search-form-wrap">
		<span class="rg-search-close far fa-times-circle"></span>
		<?php
		if ( 'v4' === $reign_header_layout ) {
			do_action( 'reign_header_v4_middle_section_html' );
		} else {
			get_search_form();
		}
		?>
	</div>
</div>
