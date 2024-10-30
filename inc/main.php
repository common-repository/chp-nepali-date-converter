<?php

/**
 * 
 * Trigger this file on Plugin unistall
 * 
 * @package chp-nepali-date-utility
 */

 ?>
<div class="chp_container">

    <div class="chp_title">
        <h5><?php echo esc_html( get_admin_page_title() ); ?> Settings</h5>
    </div>

    <form action="options.php" class="chp-form" method="post">
        <?php
            // output security fields for the registered setting "chpnpdate"
            settings_fields( 'chpdate_settings' );
            // output setting sections and their fields
            // (sections are registered for "chp-nepali-date-converter", each field is registered to a specific section)
            do_settings_sections( 'chp-nepali-date-converter' );
            // output save settings button
            submit_button( __( 'Save Settings') );
            ?>
    </form>

    <div class="chp_title">
        <h5>Help</h5>
    </div>

    <div class="help-section">
        <h2>Date and Time Format has following options: </h2>
        <ul>
            <li><strong>Y</strong> - Year
                <code>[Eg : <?php echo chpNepaliDate::chp_convert_unicode_number(date('Y')); ?>]</code>
            </li>
            <li><strong>M</strong> - Month
                <code>[Eg : <?php echo chpNepaliDate::chp_convert_unicode_number(date('m')); ?>]</code>
            </li>
            <li><strong>m</strong> - Full Month
                <code>[Eg : <?php echo 'बैशाख'; ?>]</code>
            </li>
            <li><strong>d</strong> - Day
                <code>[Eg : <?php echo chpNepaliDate::chp_convert_unicode_number(date('d')); ?>]</code>
            </li>
            <li><strong>l</strong> - Full Day
                <code>[Eg : <?php echo 'आइतबार'; ?>]</code>
            </li>
            <li><strong>H</strong> - Hour in 24 hour format
                <code>[Eg : <?php echo chpNepaliDate::chp_convert_unicode_number(date('H')); ?>]</code>
            </li>
            <li><strong>h</strong> - Hour in 12 hour format
                <code>[Eg : <?php echo chpNepaliDate::chp_convert_unicode_number(date('h')); ?>]</code>
            </li>
            <li><strong>i</strong> - Minutes
                <code>[Eg : <?php echo chpNepaliDate::chp_convert_unicode_number(date('i')); ?> मिनेट ]</code>
            </li>
            <li><strong>a</strong> - AM or PM
                <code>[Eg : <?php echo 'बिहान or मध्यान्ह'; ?> ]</code>
            </li>
        </ul>

        <hr>
        <h2>Shortcode</h2>
        <p>You can display Nepali date in anywhere using <code>shortcode</code>. Paste below code to get nepali date
            anywhere.</p>
        <p><code> [PHPNPDATE date="YOUR_DATE_IN_ENGLISH"] </code> </p>
        <p><code> [PHPNPDATE date="TODAY"] </code> or <code> [PHPNPDATE] </code> => Display today date in Nepali </p>
        <p><code> [PHPNPDATE date="REALTIME"] </code> => Display real timer with full date in Nepali </p>
        <p><code> [PHPNPDATE date="REALTIMEONLY"] </code> => Display real timer without date in Nepali </p>

        <hr>
        <h2>About the Plugin</h2>
        <p>
            <code>CHP Nepali Date Converter</code> plugin is developed in order to provide dates conversion
            from English to
            Nepali
            dates and Vice Versa. This plugin converts pages, posts and comments date from English to Nepali or Vice
            Versa. This plugin also supports <code>Shortcode</code> that helps you to display Nepali dates anywhere in
            your website.
        </p>
        <a href="https://wordpress.org/plugins/chp-nepali-date-converter" target="_blank">Go to plugin page</a> /
        <a href="mailto:info@codehelppro.com"> Provide Feedback</a>
    </div>


</div>