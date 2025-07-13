<?php
namespace WPCoreBoot\Functions;

function debug_log($data) {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log(print_r($data, true));
    }
}