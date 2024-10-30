<?php

/**
 * Adds chpdate_widget_theme widget.
 */

class CHPDATETIME_WIDGET_THEME extends WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'chpdate_widget_theme', // Base ID
            'CHP NP Date Theme', // Name
            array( 'description' => __( 'Display Nepali date with or without Real Timer with beatutiful theme', 'chpdate_widget_theme' ), ) // Args
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
 
        echo $before_widget;
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }
        ?>
<div style="width:100%;" class="chpnpdate_theme">
    <div style="text-align: center;" class="chpnpdate_theme_header">
        <div style="font-size: 20px;font-weight: bold;" class="chpnpdate_theme_title">
            नेपाली पात्रो</div>
        <div style="font-size: 13px;" class="chpnpdate_theme_date">
            <?php echo date('M d, Y'); ?></div>
    </div>
    <div class="chpnpdate_theme_np_date" style="text-align: center;padding-top: 2%;font-size: 20px;">
        <?php echo chpNepaliDate::shortcode(array('date' => 'TODAY')); ?></div>
    <div class="chpnpdate_theme_timer" style="text-align: center;font-size: 35px;padding: 10px 0;">
        <?php echo chp_real_time(true); ?>
    </div>
</div>
<?php
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
            $title = __( 'नेपाली पात्रो', 'chpdate_widget_theme' );
        }
        ?>
<p>
    <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
        name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
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
 
        return $instance;
    }
}


?>