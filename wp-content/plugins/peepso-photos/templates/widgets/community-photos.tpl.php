<?php /*NWJjbDNsYng1QmhMczU4UHdsd3hjSnBMcEwzOTUwOVZsdnJlNGVsVmxTdDZOZ0tCa2xYVldVVXlvUGtZaEJVNG15TXRLZlVxWlh1c0V3V0htcGlrVGFWRHkwTjlxeXRlK1JjQlVySXU3dEpGdmkyV2RYcnMrK1BmL2lzTVdzVytJdTVjUmt0eFpJVUJvMCtFbjl2UGtRU002YVVuOEhHdi9MZ0xMUEVKRnJTYmQwcDA0eEEwMjBWRUVaZkFVM1pmbzVPNE45UGZ4NzhmTDMydjdQVTVpdz09*/
    echo $args['before_widget'];
?>

<div class="ps-widget__wrapper<?php echo $instance['class_suffix'];?> ps-widget<?php echo $instance['class_suffix'];?>">
    <div class="ps-widget__header<?php echo $instance['class_suffix'];?>">
        <?php
            if ( ! empty( $instance['title'] ) ) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
            }
        ?>
    </div>
    <div class="ps-widget__body<?php echo $instance['class_suffix'];?>">
        <div class="psw-photos">
        <?php
            if(count($instance['list']))
            {
        ?>
            <?php
                foreach ($instance['list'] as $photo)
                {
                    PeepSoTemplate::exec_template('photos', 'photo-item-widget', (array)$photo);
                }
            ?>
            <?php
                }
                else
                {
                    echo "<div class='psw-photos__info'>".__('No photos', 'picso')."</div>";
                }
            ?>
        </div>
    </div>
</div>

<?php

echo $args['after_widget'];

// EOF
