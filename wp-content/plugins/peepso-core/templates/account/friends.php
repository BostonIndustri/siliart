	<h2><?php echo esc_attr__('Friends', 'peepso-core');?></h2>
	<?php
	if (count($friends) > 0) {
	?>
		<ul>
	<?php
        foreach ($friends as $friend) {
            $friend = PeepSoUser::get_instance($friend);
	?>
			<li><?php echo $friend->get_fullname();?> ( <?php echo $friend->get_email(); ?>)</li>
	<?php
        }
    ?>
    	</ul>
    <?php
    } else {
    	echo esc_attr__('You have no friends yet', 'peepso-core');
	}
	?>


	<h2><?php echo esc_attr__('Friends Request', 'peepso-core');?></h2>
	<?php
	if (count($list_requests) > 0) {
	?>
		<ul>
	<?php
		foreach ($list_requests as $req) {
			$freq = PeepSoUser::get_instance($req['freq_user_id']);
			?>
			<li><?php echo $freq->get_fullname();?> ( <?php echo $freq->get_email(); ?>)</li>
			<?php
		}
	?>
		</ul>
	<?php
	} else {
		echo esc_attr__('You currently have no friend requests', 'peepso-core');
	}
	?>


	<h2><?php echo esc_attr__('Blocked Members', 'peepso-core')?></h2>
	<?php
		if (count($list_blocked->results) > 0) {

            ?>

        <ul>
	<?php
		foreach ($list_blocked->results as $blocked) {
			$block = PeepSoUser::get_instance($blocked);
			?>
			<li><?php echo $block->get_fullname();?> ( <?php echo $block->get_email(); ?>)</li>
			<?php
		}
	?>
		</ul>

            <?php

        } else {
            echo esc_attr__('No blocked members found.', 'peepso-core');
        }
	?>