<?php
/*
Plugin Name: wp_mail line notify
Plugin URI: http://github.com/ha1t/wordpress-line-notify
Description: send line using wp_mail()
Version: 0.0.1
Author: ha1t
*/

require_once dirname(__FILE__) . '/LineNotifyAdmin.php';

if (!function_exists('wp_mail'))
{
    function wp_mail($to, $subject, $message, $headers = '',array $attachments = [])
    {
        $line_message = $to . PHP_EOL;
        $line_message.= $subject . PHP_EOL;
        $line_message.= $message . PHP_EOL;
        $line_message.= $headers . PHP_EOL;

        $options  = get_option(LineNotifyAdmin::OPTIONS_KEY);
        $token = $options['line_notify_token'];
        exec('curl -s -X POST -H "Authorization: Bearer ' . $token . '" -F "message=' . $line_message . '" https://notify-api.line.me/api/notify');
    }

}

new LineNotifyAdmin();

