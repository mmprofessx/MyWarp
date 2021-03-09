<?php
    // Make sure we can't access this file directly from the browser.
    if(!defined('IN_MYBB'))
        die('This file cannot be accessed directly.');

    /**
     * Link the parser to the hooks.
     * add_hook accepts four params (hook_name, function_name, priority, included_once_file)
     * but only the first two are required.
     */
    $plugins->add_hook("postbit_announcement", "mywrap_run");
	$plugins->add_hook("postbit_prev", "mywrap_run");
	$plugins->add_hook("parse_message", "mywrap_run");

    function mywrap_info() {
        /**
         * Array of information about the plugin.
         * name:          The name of the plugin
         * description:   Description of what the plugin does
         * website:       The website the plugin is maintained at (Optional)
         * author:        The name of the author of the plugin
         * authorsite:    The URL to the website of the author (Optional)
         * version:       The version number of the plugin
         * compatibility: A CSV list of MyBB versions supported. Ex, '121,123', '12*'. Wildcards supported.
         * codename:      An unique code name to be used by updated from the official MyBB Mods community.
         */
        return array(
            "name"				=> "MyWrap [wrap]",
            "description"		=> 'A plugin that allows you to add wrappers to your messages.',
            "website"			=> "http://www.mybb.com",
            "author"			=> "Thibmo",
            "authorsite"		=> "https://delphigamedevs.org/",
            "version"			=> "1.0.0",
            "compatibility"		=> "18*",
            "codename"			=> "mywrap"
        );
    }

    function mywrap_activate() {
        global $db, $mybb;

        $queryTId = $db->write_query("SELECT tid FROM " . TABLE_PREFIX . "themes WHERE def='1'");
        $themeTId = $db->fetch_array($queryTId);
        $newStyle = [
            'name'         => 'mywrap.css',
            'tid'          => $themeTId['tid'],
            'attachedto'   => 'showthread.php|newthread.php|newreply.php|editpost.php|private.php|announcements.php',
            'lastmodified' => TIME_NOW,
            'stylesheet'   => '/* resetting the box model to something more sane makes life a whole lot easier */
            .plugin_wrap {
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                margin: 10px;
            }
            /* emulate a headline */
            .plugin_wrap.wrap__emuhead em strong {
                font-size: 130%;
                font-weight: bold;
                font-style: normal;
                display: block;
            }
            /* emulate a bigger headline with a bottom border */
            .plugin_wrap.wrap__emuhead em strong em.u {
                font-size: 115%;
                border-bottom: 1px solid #6c6c6c;
                font-style: normal;
                text-decoration: none;
                display: block;
            }
            /* different bigger headline for safety notes */
            .wrap_danger.wrap__emuhead em strong em.u,
            .wrap_warning.wrap__emuhead em strong em.u,
            .wrap_caution.wrap__emuhead em strong em.u,
            .wrap_notice.wrap__emuhead em strong em.u,
            .wrap_safety.wrap__emuhead em strong em.u {
                text-transform: uppercase;
                border-bottom-width: 0;
            }
            /* change border colour of emulated headlines inside boxes to something more neutral (to match all the different background colours) */
            .wrap_box.wrap__emuhead em strong em.u,
            .wrap_info.wrap__emuhead em strong em.u,
            .wrap_important.wrap__emuhead em strong em.u,
            .wrap_alert.wrap__emuhead em strong em.u,
            .wrap_tip.wrap__emuhead em strong em.u,
            .wrap_help.wrap__emuhead em strong em.u,
            .wrap_todo.wrap__emuhead em strong em.u,
            .wrap_download.wrap__emuhead em strong em.u {
                border-bottom-color: #999;
            }
            /* real headlines should not be indented inside a wrap */
            .plugin_wrap h1,
            .plugin_wrap h2,
            .plugin_wrap h3,
            .plugin_wrap h4,
            .plugin_wrap h5 {
                margin-left: 0;
                margin-right: 0;
            }
            /* columns
            ********************************************************************/
            .wrap_left,
            .wrap_column {
                float: left;
                margin-right: 1.5em;
            }
            [dir=rtl] .wrap_column {
                float: right;
                margin-left: 1.5em;
                margin-right: 0;
            }
            .wrap_right {
                float: right;
                margin-left: 1.5em;
            }
            .wrap_center {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
            /*____________ CSS3 columns  ____________*/
            .wrap_col2, .wrap_col3, .wrap_col4, .wrap_col5,
            .wrap_colsmall, .wrap_colmedium, .wrap_collarge {
                -moz-column-gap: 1.5em;
                -webkit-column-gap: 1.5em;
                column-gap: 1.5em;
                -moz-column-rule: 1px dotted #666;
                -webkit-column-rule: 1px dotted #666;
                column-rule: 1px dotted #666;
            }
            .wrap_col2 {
                -moz-column-count: 2;
                -webkit-column-count: 2;
                column-count: 2;
            }
            .wrap_col3 {
                -moz-column-count: 3;
                -webkit-column-count: 3;
                column-count: 3;
            }
            .wrap_col4 {
                -moz-column-count: 4;
                -webkit-column-count: 4;
                column-count: 4;
            }
            .wrap_col5 {
                -moz-column-count: 5;
                -webkit-column-count: 5;
                column-count: 5;
            }
            .wrap_colsmall {
                -moz-column-width: 10em;
                -webkit-column-width: 10em;
                column-width: 10em;
            }
            .wrap_colmedium {
                -moz-column-width: 20em;
                -webkit-column-width: 20em;
                column-width: 20em;
            }
            .wrap_collarge {
                -moz-column-width: 30em;
                -webkit-column-width: 30em;
                column-width: 30em;
            }
            /* widths
            ********************************************************************/
            .wrap_twothirds {
                width: 65%;
                margin-right: 5%;
            }
            .wrap_half {
                width: 48%;
                margin-right: 4%;
            }
            .wrap_third {
                width: 30%;
                margin-right: 5%;
            }
            .wrap_quarter {
                width: 22%;
                margin-right: 4%;
            }
            [dir=rtl] .wrap_half,
            [dir=rtl] .wrap_quarter {
                margin-right: 0;
                margin-left: 4%;
            }
            [dir=rtl] .wrap_twothirds,
            [dir=rtl] .wrap_third {
                margin-right: 0;
                margin-left: 5%;
            }
            /* this does not always work when third and twothirds are mixed across rows
               but can be fixed by adding any div (e.g. [wrap style="clear"][/wrap]) after a row */
            .wrap_half + .wrap_half,
            .wrap_third + .wrap_twothirds,
            .wrap_twothirds + .wrap_third,
            .wrap_third + .wrap_third + .wrap_third,
            .wrap_quarter + .wrap_quarter + .wrap_quarter + .wrap_quarter {
                margin-right: 0;
                [dir=rtl] & {
                    margin-left: 0;
                }
                + * {
                    clear: left;
                    [dir=rtl] & {
                        clear: right;
                    }
                }
            }
            /* show 2 instead 4 columns on medium sized screens (mobile, etc) */
            @media only screen and (max-width: 950px) {
                .wrap_quarter {
                    width: 48%;
                }
                .wrap_quarter:nth-of-type(2n) {
                    margin-right: 0;
                }
                [dir=rtl] .wrap_quarter:nth-of-type(2n) {
                    margin-left: 0;
                }
                .wrap_quarter:nth-of-type(2n+1) {
                    clear: left;
                }
                [dir=rtl] .wrap_quarter:nth-of-type(2n) {
                    clear: right;
                }
            } /* /@media */
            /* show full width on smaller screens (mobile, etc) */
            @media only screen and (max-width: 600px) {
                .wrap_twothirds,
                .wrap_half,
                .wrap_third,
                .wrap_quarter {
                    width: auto;
                    margin-right: 0;
                    margin-left: 0;
                    float: none;
                }
            } /* /@media */
            /* alignments
            ********************************************************************/
            .wrap_leftalign {
                text-align: left;
            }
            .wrap_centeralign {
                text-align: center;
            }
            .wrap_rightalign {
                text-align: right;
            }
            .wrap_justify {
                text-align: justify;
            }
            /* box
            ********************************************************************/
            /*____________ rounded corners ____________*/
            /* (only for modern browsers) */
            div.wrap_round {
                border-radius: 1.4em;
            }
            .wrap_box {
                background: #fcfcfc;
                color: #000;
            }
            div.wrap_box,
            div.wrap_danger,
            div.wrap_warning,
            div.wrap_caution,
            div.wrap_notice,
            div.wrap_safety {
                padding: 1em 1em .5em;
                margin-bottom: 1.5em;
                overflow: hidden;
            }
            /*____________ notes with icons ____________*/
            /* general styles for all note divs */
            div.wrap_info,
            div.wrap_important,
            div.wrap_alert,
            div.wrap_tip,
            div.wrap_help,
            div.wrap_todo,
            div.wrap_download {
                padding: 1em 1em .5em 70px;
                margin-bottom: 1.5em;
                min-height: 68px;
                background-position: 10px 50%;
                background-repeat: no-repeat;
                color: inherit;
                overflow: hidden;
            }
            [dir=rtl] div.wrap_info,
            [dir=rtl] div.wrap_important,
            [dir=rtl] div.wrap_alert,
            [dir=rtl] div.wrap_tip,
            [dir=rtl] div.wrap_help,
            [dir=rtl] div.wrap_todo,
            [dir=rtl] div.wrap_download {
                padding: 1em 60px .5em 1em;
                background-position: right 50%;
            }
            /*____________ info ____________*/
            .wrap_info {
                background-color: #d1d7df;
            }
            div.wrap_info {
                background-image: url(images/mywrap/info_48x48.png);
            }
            /*____________ important ____________*/
            .wrap_important {
                background-color: #ffd39f;
            }
            div.wrap_important {
                background-image: url(images/mywrap/important_48x48.png);
            }
            /*____________ alert ____________*/
            .wrap_alert {
                background-color: #ffbcaf;
            }
            div.wrap_alert {
                background-image: url(images/mywrap/alert_48x48.png);
            }
            /*____________ tip ____________*/
            .wrap_tip {
                background-color: #fff79f;
            }
            div.wrap_tip {
                background-image: url(images/mywrap/tip_48x48.png);
            }
            /*____________ help ____________*/
            .wrap_help {
                background-color: #dcc2ef;
            }
            div.wrap_help {
                background-image: url(images/mywrap/help_48x48.png);
            }
            /*____________ todo ____________*/
            .wrap_todo {
                background-color: #c2efdd;
            }
            div.wrap_todo {
                background-image: url(images/mywrap/todo_48x48.png);
            }
            /*____________ download ____________*/
            .wrap_download {
                background-color: #d6efc2;
            }
            div.wrap_download {
                background-image: url(images/mywrap/download_48x48.png);
            }
            /*____________ safety notes ____________*/
            .wrap_danger {
                background-color: #c00;
                color: #fff !important;
            }
            .wrap_warning {
                background-color: #f60;
                color: #000 !important;
            }
            .wrap_caution {
                background-color: #ff0;
                color: #000 !important;
            }
            .wrap_notice {
                background-color: #06f;
                color: #fff !important;
            }
            .wrap_safety {
                background-color: #090;
                color: #fff !important;
            }
            .wrap_danger *,
            .wrap_warning *,
            .wrap_caution *,
            .wrap_notice *,
            .wrap_safety * {
                color: inherit !important;
            }
            /* mark
            ********************************************************************/
            .wrap_lo {
                color: #666;
                font-size: 85%;
            }
            .wrap_em {
                color: #c00;
                font-weight: bold;
            }
            .wrap__dark.wrap_em {
                color: #f66;
            }
            .wrap_hi {
                background-color: #ff9;
                overflow: hidden;
            }
            .wrap__dark.wrap_hi {
                background-color: #4e4e0d;
            }
            /* miscellaneous
            ********************************************************************/
            /*____________ indent ____________*/
            .wrap_indent {
                padding-left: 1.5em;
            }
            [dir=rtl] .wrap_indent {
                padding-right: 1.5em;
                padding-left: 0;
            }
            /*____________ outdent ____________*/
            .wrap_outdent {
                margin-left: -1.5em;
            }
            [dir=rtl] .wrap_outdent {
                margin-right: -1.5em;
                margin-left: 0;
            }
            /*____________ word wrapping in pre ____________*/
            div.wrap_prewrap pre {
                white-space: pre-wrap;
                word-wrap: break-word;/* for IE < 8 */
            }
            /*____________ clear float ____________*/
            .wrap_clear {
                clear: both;
                line-height: 0;
                height: 0;
                font-size: 1px;
                visibility: hidden;
                overflow: hidden;
            }
            /*____________ hide ____________*/
            .wrap_hide {
                display: none;
            }
            /*____________ button-style link ____________*/
            .wrap_button {
                background-image: none;
                border: 1px solid #eee;
                border-radius: .3em;
                padding: .5em .7em;
                text-decoration: none;
                background-color: #eee;
            }
            .wrap_button a:link,
            .wrap_button a:visited {
                text-decoration: none;
                background-color: #eee;
            }
            .wrap_button a:link:hover,
            .wrap_button a:visited:hover,
            .wrap_button a:link:focus,
            .wrap_button a:visited:focus,
            .wrap_button a:link:active,
            .wrap_button a:visited:active {
                text-decoration:none
                background-color: #fff;
            }'
        ];

        $sId = $db->insert_query('themestylesheets', $newStyle);
        $db->update_query('themestylesheets', array('cachefile' => "css.php?stylesheet={$sId}"), "sid='{$sId}'", 1);
        $query = $db->simple_select('themes', 'tid');

        require MYBB_ROOT . 'inc/adminfunctions_templates.php';

        while ($theme = $db->fetch_array($query)) {
            require_once MYBB_ADMIN_DIR . 'inc/functions_themes.php';
            update_theme_stylesheet_list($theme['tid']);
        };

        // Add the BBCode drop-down to the editor
        if ($mybb->version_code >= 1808) {
            find_replace_templatesets('codebuttons', '#' . preg_quote('<script type="text/javascript" src="{$mybb->asset_url}/jscripts/bbcodes_sceditor.js?ver=1808"></script>') . '#',
                                                                      '<script type="text/javascript" src="{$mybb->asset_url}/jscripts/bbcodes_sceditor.js?ver=1808"></script>
<script type="text/javascript" src="{$mybb->asset_url}/jscripts/mywrap.min.js?ver=1808"></script>');
        } else if ($mybb->version_code <= 1806  && $mybb->version_code >= 1804) {
            find_replace_templatesets('codebuttons', '#' . preg_quote('<script type="text/javascript" src="{$mybb->asset_url}/jscripts/bbcodes_sceditor.js?ver=1804"></script>') . '#',
                                                                      '<script type="text/javascript" src="{$mybb->asset_url}/jscripts/bbcodes_sceditor.js?ver=1804"></script>
<script type="text/javascript" src="{$mybb->asset_url}/jscripts/mywrap.min.js?ver=1808"></script>');
        } else {
            find_replace_templatesets('codebuttons', '#' . preg_quote('<script type="text/javascript" src="{$mybb->asset_url}/jscripts/bbcodes_sceditor.js?ver=1800"></script>') . '#',
                                                                      '<script type="text/javascript" src="{$mybb->asset_url}/jscripts/bbcodes_sceditor.js?ver=1800"></script>
<script type="text/javascript" src="{$mybb->asset_url}/jscripts/mywrap.min.js?ver=1808"></script>');
        };

        find_replace_templatesets('codebuttons', '#' . preg_quote('{$link}') . '#', '{$link},wrap');
    }

    function mywrap_deactivate() {
        global $db;

        $db->delete_query('themestylesheets', "name='mywrap.css'");
        $query = $db->simple_select('themes', 'tid');

        while($theme = $db->fetch_array($query)) {
            require_once MYBB_ADMIN_DIR.'inc/functions_themes.php';
            update_theme_stylesheet_list($theme['tid']);
        };

        require MYBB_ROOT.'inc/adminfunctions_templates.php';

        // Delete the BBCode drop-down from the editor
        find_replace_templatesets('codebuttons', '#'.preg_quote('<script type="text/javascript" src="{$mybb->asset_url}/jscripts/mywrap.min.js?ver=1808"></script>').'#', '',0);
        find_replace_templatesets('codebuttons', '#'.preg_quote(',wrap').'#', '', 0);
    }


    function mywrap_run(&$message) {
        $message = preg_replace_callback('#\[wrap\](.*?)\[/wrap\]#is', 'mywrap_parse_callback', $message);
        $message = preg_replace_callback('#\[wrap style=(.*?)\](.*?)\[/wrap\]#is', 'mywrap_parse_styled_callback', $message);
        return $message;
    }

    function mywrap_getStyleAttribs($styles) {
        // Get rid of unwanted chars and split to array
        $arr = explode(' ', trim(str_replace('"', '', $styles)));
        $result = [];

        foreach ($arr as $k => $v) {
            if (preg_match('/^\d*\.?\d+(%|px|em|rem|ex|ch|vw|vh|pt|pc|cm|mm|in)$/', $v)) {
                $result['width'] = $v;
                continue;
            };

            if (preg_match('/[^A-Za-z0-9_-]/',$v))
                continue;

            if (array_key_exists('classes', $result)) {
                $result['classes'] .= ' wrap_' . $v;
            } else {
                $result['classes'] = ' wrap_' . $v;
            };
        };

        return $result;
    }

    function mywrap_parse_callback($matches) {
        return '<div class="plugin_wrap">' . $matches[1] . '</div>';
    }

    function mywrap_parse_styled_callback($matches) {
        $result = '<div class="plugin_wrap';
        $styles = mywrap_getStyleAttribs($matches[1]);

        if (array_key_exists('classes', $styles)) {
            $result .= $styles['classes'] . '"';
        } else {
            $result .= '"';
        };

        if (array_key_exists('width', $styles)) {
            $result .= ' style="';

            if (strpos($styles['width'], '%') !== False) {
                $result .= 'width: ' . htmlspecialchars($styles['width']) . ';"';
            } else {
                $result .= 'width: ' . htmlspecialchars($styles['width']) . '; max-width: 100%;"';
            };
        };

        return $result . '>' . $matches[2] . '</div>';
    }
