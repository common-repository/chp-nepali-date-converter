<?php

/**
 * Plugin Name:       CHP Nepali Date Converter
 * Plugin URI:        https://codehelppro.com/wordpress-plugin-development/projects/chp-nepali-date-converter
 * Description:       <code>CHP Nepali Date Converter</code> plugin is developed in order to provide dates conversion from English to Nepali dates and Vice Versa. This plugin converts pages, posts and comments date from English to Nepali or Vice Versa. This plugin also supports <code>Shortcode</code> that helps you to display Nepali dates anywhere in your website.
 * Version:           1.0.2
 * Requires at least: 5.2
 * Author:            Suresh Chand
 * Author URI:        https://codehelppro.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       chp-nepali-date-converter
 * Domain Path:       /languages
 */

defined('ABSPATH') or die("Hey! You have not permission to access this page.");

if(!defined('CHPNPDATE_VERSION'))
    define('CHPNPDATE_VERSION', '1.0.1');

if(!defined('CHPNPDATE_BASENAME'))
    define('CHPNPDATE_BASENAME', plugin_basename(__FILE__));

spl_autoload_register(function ($class) {
    if(file_exists(plugin_dir_path(__FILE__).'inc/' . $class . '.class.php'))
        require_once plugin_dir_path(__FILE__).'inc/' . $class . '.class.php';
});

function register_chpdate_widget() { 
    register_widget( 'CHPDATETIME_WIDGET' );
    register_widget( 'CHPDATETIME_WIDGET_THEME' );
}

class chpNepaliDate{
    
    public static function include_action(){
        add_action('admin_enqueue_scripts', array('chpNepaliDate', 'admin_scripts_enqueue'));
        add_action( 'wp_footer', array('chpNepaliDate', 'add_footer_script') );
        add_action('admin_menu', array('chpNepaliDate', 'add_admin_menu'));

        add_action( 'widgets_init', 'register_chpdate_widget' );

        //add setting menu
        add_filter('plugin_action_links_'.CHPNPDATE_BASENAME, array('chpNepaliDate', 'settings_link'));
        /**
         * register wporg_settings_init to the admin_init action hook
         */
        add_action('admin_init', array('chpNepaliDate', 'settings_init'));

        $setting = get_option('chpdate_enable_settings');
        $comment_setting = get_option('chpdate_comment_settings');
        if(isset( $setting ) && filter_var($setting, FILTER_VALIDATE_BOOLEAN)){
            add_filter( 'get_the_date', array('chpNepaliDate', 'chp_convert_to_nepali_date_time'), 10, 1 ); //override date display
            add_filter( 'the_date', array('chpNepaliDate', 'chp_convert_to_nepali_date_time') , 10, 1 ); //override date display
            add_filter( 'get_the_time', array('chpNepaliDate', 'chp_convert_to_nepali_date_time') , 10, 1 ); //override time display
            add_filter( 'the_time', array('chpNepaliDate', 'chp_convert_to_nepali_date_time') , 10, 1 ); //override time display

            if(isset( $comment_setting ) && filter_var($comment_setting, FILTER_VALIDATE_BOOLEAN))
                add_filter( 'get_comment_date', array('chpNepaliDate', 'chp_convert_to_nepali_date_time_comment') , 10, 1 ); //override time comment date
            else
                add_filter( 'get_comment_date', array('chpNepaliDate', 'chp_convert_to_nepali_date_time') , 10, 1 ); //override time comment date


            add_filter( 'the_modified_time', array('chpNepaliDate', 'chp_convert_to_nepali_date_time_modified') , 10, 1 );
            add_filter( 'get_the_modified_time', array('chpNepaliDate', 'chp_convert_to_nepali_date_time_modified'), 10, 1  );
            add_filter( 'the_modified_date', array('chpNepaliDate', 'chp_convert_to_nepali_date_time_modified'), 10, 1  );
            add_filter( 'get_the_modified_date', array('chpNepaliDate', 'chp_convert_to_nepali_date_time_modified'), 10, 1  );

            add_shortcode( 'CHPNPDATE', array('chpNepaliDate', 'shortcode') );
        }
    }

    public static function chp_convert_to_nepali_date_time($date){
        global $post;
        $post_date = ( !empty( $post->post_date ) ) ? strtotime( $post->post_date ) : time();
        $converted_date = self::chp_convert_post_date($post_date);
        return $converted_date;  
    }

    public static function chp_convert_to_nepali_date_time_comment($date){
        $date1 = new DateTime($date);
        $date2 = new DateTime();

        $timeAgo = '';
        $count = 0;

        $date_diff = date_diff($date2, $date1);
        
        if($date_diff->y > 0){
            return self::chp_convert_to_nepali_date_time($date);
        }else{
            if($date_diff->m > 0 && $count < 2){
                $count++;
                $timeAgo .= self::chp_convert_unicode_number($date_diff->m).' महिना ';
            }

            if($date_diff->d > 0 && $count < 2){
                $count++;
                $timeAgo .= self::chp_convert_unicode_number($date_diff->d).' दिन ';
            }

            if($date_diff->h > 0 && $count < 2){
                $count++;
                $timeAgo .= self::chp_convert_unicode_number($date_diff->h).' घण्टा ';
            }

            if($date_diff->i > 0 && $count < 2){
                $count++;
                $timeAgo .= self::chp_convert_unicode_number($date_diff->i).' मिनेट ';
            }

        }
        
        if(!empty($timeAgo)){
            return $timeAgo . " पहिले";
        }else{
            return "भर्खरै";
        }
    }

    public static function chp_convert_to_nepali_date_time_modified($date){
        global $post;
        if($post->post_date != $post->post_modified){
            $post_date = ( !empty( $post->post_modified ) ) ? strtotime( $post->post_modified ) : time();
            $converted_date = self::chp_convert_post_date($post_date);
            return $converted_date;  
        }else{
            return '';
        }
    }

    public static function chp_convert_post_date($post_date, $format=''){
        $date = new nepalidate();
        $nepali_calender = $date->eng_to_nep( date( 'Y', $post_date ), date( 'm', $post_date ), date( 'd', $post_date ) );

        $nepali_year = $date->convert_to_nepali_number( $nepali_calender['year'] );
        $nepali_month = $nepali_calender['nmonth'];
        $month_count = $date->convert_to_nepali_number( $nepali_calender['month'] );
        $nepali_day = $nepali_calender['day'];
        $nepali_day_count = $date->convert_to_nepali_number( $nepali_calender['num_day'] );
        $nepali_date = $date->convert_to_nepali_number( $nepali_calender['date'] );
        $nepali_hour_Ho = $date->convert_to_nepali_number( date( 'H', $post_date ) );
        $nepali_hour_h = $date->convert_to_nepali_number( date( 'h', $post_date ) );
        $nepali_minute = $date->convert_to_nepali_number( date( 'i', $post_date ) );
        $nepali_seconds = $date->convert_to_nepali_number( date( 's', $post_date ) );
        $nepali_am_pm = date('a', $post_date ) == 'am' ? 'बिहान' : 'मध्यान्ह';

        $final_date = "$nepali_day_count $nepali_month $nepali_year, $nepali_day";

        if(!empty($format)){
            $dateFormat = $format;
        }else{
            $setting = get_option('chpdate_format_settings');
            $dateFormat = isset($setting) ? $setting : 'd m Y, l';
        }

        return str_replace(
            array('Y', 'M', 'm', 'd', 'l', 'H', 'h', 'i', 's', 'a'),
            array($nepali_year, $month_count, $nepali_month, $nepali_day_count, $nepali_day, $nepali_hour_Ho, $nepali_hour_h, $nepali_minute, $nepali_seconds, $nepali_am_pm),
            $dateFormat
        );
    }

    public static function chp_human_time_diff_nepali( $from, $to = '' ){
        if ( empty( $to ) ) {
            $to = time();
        }

        $diff = (int) abs( $to - $from );

        if ( $diff < HOUR_IN_SECONDS ) {
            $mins = round( $diff / MINUTE_IN_SECONDS );
            if ( $mins <= 1 )
                $mins = 1;
            /* translators: min=minute */
            $since = sprintf( _n( '%s मिनेट', '%s मिनेट', $mins ), $mins );
        } elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
            $hours = round( $diff / HOUR_IN_SECONDS );
            if ( $hours <= 1 )
                $hours = 1;
            $since = sprintf( _n( '%s घण्टा', '%s घण्टा', $hours ), $hours );
        } elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
            $days = round( $diff / DAY_IN_SECONDS );
            if ( $days <= 1 )
                $days = 1;
            $since = sprintf( _n( '%s दिन', '%s दिन', $days ), $days );
        } elseif ( $diff < MONTH_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
            $weeks = round( $diff / WEEK_IN_SECONDS );
            if ( $weeks <= 1 )
                $weeks = 1;
            $since = sprintf( _n( '%s हप्ता', '%s हप्ता', $weeks ), $weeks );
        } elseif ( $diff < YEAR_IN_SECONDS && $diff >= MONTH_IN_SECONDS ) {
            $months = round( $diff / MONTH_IN_SECONDS );
            if ( $months <= 1 )
                $months = 1;
            $since = sprintf( _n( '%s महिना', '%s महिना', $months ), $months );
        } elseif ( $diff >= YEAR_IN_SECONDS ) {
            $years = round( $diff / YEAR_IN_SECONDS );
            if ( $years <= 1 )
                $years = 1;
            $since = sprintf( _n( '%s वर्ष', '%s वर्ष', $years ), $years );
        }

        return apply_filters( 'chp_human_time_diff_nepali', $since, $diff, $from, $to );
    }

    public static function chp_convert_unicode_number($unicode = null){
        $conversionNumber = array('1'=>'१' ,'2'=>'२' ,'3'=> '३' , '4'=>'४' , '5'=>'५' , '6'=>'६', '7'=>'७' , '8'=>'८' , '9'=>'९', '0'=>'०');
        foreach ($conversionNumber as $key => $number) {
            $unicode = str_replace($key, $number, $unicode);
        }
        return $unicode;
    }

    public static function settings_link($links){
        $settings_link = '<a href="options-general.php?page=chp-nepali-date-utility">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }

    public static function admin_scripts_enqueue(){
        //enqueue all scripts in admin dashboard
        wp_enqueue_style('chpnpdate-admin-css', plugins_url('/assets/css/chp-np-date-utilities-admin.css', __FILE__));
        wp_enqueue_script('chpnpdate-admin-js', plugins_url('/assets/js/chp-np-date-utilities-admin.js', __FILE__), 'jQuery', '1.0.1', true);
    }

    public static function add_footer_script(){
        echo '<script>function chpnpdate_convert_to_nepali(e){for(var t={0:"०",1:"१",2:"२",3:"३",4:"४",5:"५",6:"६",7:"७",8:"८",9:"९",":":":"},n="",c=0;c<e.length;c++)n+=t[e.charAt(c)];var a,p=document.querySelectorAll(".chp_datetime_realtime");for(a=0;a<p.length;a++)p[a].innerHTML=" "+n}function chpnpdate_startTime(){var e=new Date,t=e.getHours(),n=e.getMinutes(),c=e.getSeconds();chpnpdate_convert_to_nepali((t=chpnpdate_checkTime(t))+":"+(n=chpnpdate_checkTime(n))+":"+(c=chpnpdate_checkTime(c))),setTimeout(chpnpdate_startTime,500)}function chpnpdate_checkTime(e){return e<10&&(e="0"+e),e}window.onload=function(){chpnpdate_startTime()};</script>';
    }

    public static function add_admin_menu(){
        add_options_page(
            'CHP Nepali Date Converter',
            'CHP Nepali Date Converter',
            'manage_options',
            'chp-nepali-date-converter',
            array('chpNepaliDate', 'option_page_html')
        );
    }

    public static function option_page_html(){
        // check user capabilities
        if ( ! is_admin( ) ) {
            return;
        }

        require_once plugin_dir_path(__FILE__)."inc/main.php";
    }

    /**
     * REGISTER SETTINGS
     */
    public static function settings_init() {
        // register a new setting for "enable_or_disable" page
        register_setting('chpdate_settings', 'chpdate_enable_settings');
        register_setting('chpdate_settings', 'chpdate_format_settings');
        register_setting('chpdate_settings', 'chpdate_comment_settings');
    
        // register a new section in the "chpdate_settings" page
        add_settings_section(
            'chpdate_settings_section',
            '',
            array('chpNepaliDate', 'chp_settings_section_callback'),
            'chp-nepali-date-converter'
        );
    
        // register a new field in the "chp_settings_section" section, inside the "settings" page
        add_settings_field(
            'chpdate_enable_field',
            "",
            array('chpNepaliDate', 'chp_enable_field_callback'),
            'chp-nepali-date-converter',
            'chpdate_settings_section'
        );
        
        add_settings_field(
            'chpdate_format_field',
            "",
            array('chpNepaliDate', 'chp_format_field_callback'),
            'chp-nepali-date-converter',
            'chpdate_settings_section'
        );

        // register a new field in the "chp_settings_section" section, inside the "settings" page
        add_settings_field(
            'chpdate_comment_field',
            "",
            array('chpNepaliDate', 'chp_comment_field_callback'),
            'chp-nepali-date-converter',
            'chpdate_settings_section'
        );
    }

    public static function chp_settings_section_callback() {
        
    }

    // field content for comments
    public static function chp_comment_field_callback() {
        // get the value of the setting we've registered with register_setting()
        $setting = get_option('chpdate_comment_settings');

        $customValue = filter_var($setting, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '';

        echo '<div class="form-group chp_shadow">
            <label class="chp-label"> Ago format on Comments </label>
            <div class="onoffswitch">
                <input type="checkbox" name="chpdate_comment_settings" '.$customValue.' class="onoffswitch-checkbox" id="commentSwitch" tabindex="0">
                <label class="onoffswitch-label" for="commentSwitch">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
            <p style="margin-top:15px;">Switch comments date as like : <code> ३ दिन पहिले </code></p>
        </div>';
    }


    // field content cb
    public static function chp_enable_field_callback() {
        // get the value of the setting we've registered with register_setting()
        $setting = get_option('chpdate_enable_settings');

        $customValue = filter_var($setting, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '';

        echo '<div class="form-group chp_shadow">
            <label class="chp-label"> Enable or Disable </label>
            <div class="onoffswitch">
                <input type="checkbox" name="chpdate_enable_settings" '.$customValue.' class="onoffswitch-checkbox" id="myonoffswitch" tabindex="0">
                <label class="onoffswitch-label" for="myonoffswitch">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
        </div>';
    }


    // field content cb
    public static function chp_format_field_callback() {
        // get the value of the setting we've registered with register_setting()
        $setting = get_option('chpdate_format_settings');
        
        $customValue = isset( $setting ) ? esc_attr( $setting ) : '';

        echo '<div class="form-group chp_shadow">
                <label class="chp-label"> Date and Time Format </label>
                <p style="padding-bottom:7px;">We suggest you to provide <code>d m Y, l</code></p>
                <input type="text" class="chp-css-input" id="chp_date_format_2" placeholder="Custom Date Format" value="'.$customValue.'" />
                <input type="hidden" id="chp_date_format_1" name="chpdate_format_settings" value="'.$customValue.'" />
                <p style="margin-top:15px;">Date shown in this format : <code> '.self::chp_convert_post_date(time()).' </code></p>
            </div>';
    }

    /**
     * Adding shortcode
     */
    public static function shortcode( $atts ) {

        // Attributes
        $atts = shortcode_atts(
            array(
                'date' => '',
            ),
            $atts
        );

        if(!isset($atts['date'])){
            $date_str = time();
        }else if($atts['date'] == 'TODAY'){
            $date_str = time();
        }else{
            $date_str = strtotime($atts['date']);
        }

        if($atts['date'] == 'REALTIMEONLY'){
            return '<span style="padding-left:10px;font-family:auto;" class="chp_datetime_realtime">--:--:--</span>';
        }

        $date = self::chp_convert_post_date($date_str);
        $return = '<span class="chp_date">'.$date;
        if($atts['date'] == 'REALTIME'){
            $return .= '<span style="padding-left:10px;font-family:auto;" class="chp_datetime_realtime">--:--:--</span>';
        }
        $return .= '</span>';

        return $return;
    }

}


if( class_exists( 'chpNepaliDate' ) ){

    /**
     * Check if class exist or not
     */
    chpNepaliDate::include_action();
}

if( !function_exists( 'chp_real_time' )){

    /**
     * Display Real Time Function
     * 
     */

    function chp_real_time($timeOnly = false){
        if(filter_var($timeOnly, FILTER_VALIDATE_BOOLEAN)){
            return '<span style="padding-left:10px;font-family:auto;" class="chp_datetime_realtime">--:--:--</span>';
        }
        $date = chpNepaliDate::chp_convert_post_date($date_str);
        $return = '<span class="chp_date">'.$date;
        $return .= '<span style="padding-left:10px;font-family:auto;" class="chp_datetime_realtime">--:--:--</span>';
        $return .= '</span>';

        return $return;
    }
}


if(!function_exists('chp_np_to_en')){

    /**
     * Converts dates from nepali to english
     * 
     * @param date
     * @return date
     * 
     */
    
    function chp_np_to_en($date=''){

        $date = empty($date) ? date('Y-m-d H:i:s') : $date;
        return chpNepaliDate
        ::chp_convert_post_date($date);

    }
}


if( !function_exists( 'chp_np_date' )){

    /**
     * Display Real Time Function
     * 
     */

    function chp_np_date($date='', $format='', $timer=false){
        
        $date = empty($date) ? date('Y-m-d H:i:s') : $date;
        $output = chpNepaliDate::chp_convert_post_date($date, $format);
        $output .= chp_real_time(!$timer);

        echo $output;

    }
}