/**
 * Project   : Yugen WordPress Theme
 * Purpose   : Custom Admin Script
 * Author    : precisethemes
 * Theme URI : https://precisethemes.com/
 *
 * File admin-script.js.
 * @package yugen
 */

( function( $ ) {

    "use strict";

    // Welcome Page Menu Tab
    $('ul.about-theme-tab-nav li').click(function () {
        var tab_id = $(this).attr('data-tab');

        $('ul.about-theme-tab-nav li').removeClass('active');
        $('.about-theme-tab').removeClass('active');

        $(this).addClass('active');
        $("#" + tab_id).addClass('active');
    });

    // Add Active class with anchor actions click.
    $('.about-theme-tab .actions').click(function () {
        var status_id = $(this).attr('href').split('#');
        $('ul.about-theme-tab-nav li').removeClass('active');
        $('.about-theme-tab').removeClass('active');
        $('ul.about-theme-tab-nav li[data-tab="'+status_id[1]+'"]').addClass('active');
        $("#" + status_id[1]).addClass('active');
    });

    // Meta-box Tabs Settings
    $('ul.metabox-tab-nav li').click(function () {
        var tab_id = $(this).attr('data-tab');

        $('ul.metabox-tab-nav li').removeClass('active');
        $('.setting-tab').removeClass('active');

        $(this).addClass('active');
        $("#" + tab_id).addClass('active');
    });

    // Add Active class with anchor actions click.
    $('.setting-tab .actions').click(function () {
        var status_id = $(this).attr('href').split('#');
        $('ul.metabox-tab-nav li').removeClass('active');
        $('.setting-tab').removeClass('active');
        $('ul.metabox-tab-nav li[data-tab="'+status_id[1]+'"]').addClass('active');
        $("#" + status_id[1]).addClass('active');
    });
    
} ) ( jQuery );  