<?php

/**
 * Adds chpdate_widget widget.
 */

class CHPDATETIME_WIDGET extends WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'chpdate_widget', // Base ID
            'CHP NP Date Converter', // Name
            array( 'description' => __( 'Display Nepali date with or without Real Timer', 'chpdate_widget' ), ) // Args
        );
    }
 
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $type = apply_filters( 'widget_type', $instance['type'] );
 
        echo $before_widget;
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }

        if(!empty($type)){
            echo chp_real_time(false);
        }else{
            $date = chpNepaliDate::chp_convert_post_date(date('Y-m-d H:i:s'));
            echo '<span class="chp_date">'.$date;
            echo '</span>';
        }
        echo $after_widget;
    }
 
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'chpdate_widget' );
        }

        $type = __( '', 'chpdate_widget' );
        if ( isset( $instance[ 'type' ] ) ) {
            $type = $instance[ 'type' ];
            if(!empty($type))
                $type = "Checked";
        }
        ?>
<p>
    <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
        name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_name( 'type' ); ?>"><?php _e( 'With Real Time:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>"
        name="<?php echo $this->get_field_name( 'type' ); ?>" <?php echo esc_attr( $type ); ?> type="checkbox"
        value="checked" />
</p>
<?php
    }
 
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['type'] = ( !empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
 
        return $instance;
    }
}


?>