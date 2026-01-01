<?php
/**
 * Backup: About section shortcode
 * Shortcode: [about_master]
 * Source: GitHub Pages
 * Author: Sumanta Biswas
 * Purpose: Load About section safely with cache & fallback
 */

function load_about_from_github_safe() {

    // Check cache
    $cache = get_transient('about_master_cache');
    if ($cache !== false) {
        return $cache;
    }

    // GitHub content URL
    $url = 'https://sumantabiswas24.github.io/shared-content/others/aboutsumanta.html';
    $response = wp_remote_get($url, array('timeout' => 8));

    // Fallback if request fails
    if (is_wp_error($response)) {
        return '<p>About information will be updated shortly.</p>';
    }

    $content = wp_remote_retrieve_body($response);

    if (empty($content)) {
        return '<p>About information will be updated shortly.</p>';
    }

    // Cache for 6 hours
    set_transient('about_master_cache', $content, 6 * HOUR_IN_SECONDS);

    return $content;
}

// Register shortcode
add_shortcode('about_master', 'load_about_from_github_safe');
