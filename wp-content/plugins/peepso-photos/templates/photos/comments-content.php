<?php /*NWJjbDNsYng1QmhMczU4UHdsd3hjSnBMcEwzOTUwOVZsdnJlNGVsVmxTc1RVa1NqcFFzdGErZWhuMTJaWHdvSUdWUDZ0amk1NG1SNkU2WXJJQW5Bb2QvZm5PZVZpSGdwTHlaZXFuMFVQcDZ6dWRjelhpc04xbTRDMm8zYWV0VTZvcmduRjdFcFBuNDA3TzFkbHBtV2VWUVR2UyttMDM0U2x1TnYvVEd3SXBtWmNmTXVwVmpCYWpLd1d4WDV2RWROQWtBeDBubEtYeU1oS21vRlFCc3VDQT09*/
$PeepSoPhotos = PeepSoPhotos::get_instance();
?>
<div class="ps-media__attachment ps-media__attachment--photos cstream-attachment ps-media-photos photo-container photo-container-placeholder ps-clearfix ps-js-photos">
	<?php $PeepSoPhotos->show_photo_comments($photo); ?>
	<div class="ps-loading ps-media-loading ps-js-loading">
		<div class="ps-spinner">
			<div class="ps-spinner-bounce1"></div>
			<div class="ps-spinner-bounce2"></div>
			<div class="ps-spinner-bounce3"></div>
		</div>
	</div>
</div>
