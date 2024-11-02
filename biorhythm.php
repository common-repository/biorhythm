<?php
/**
 * @package Biorhythm
 * @author Dragos Boneanu
 * @version 1.0
 */

/*
Plugin Name: Biorhythm
Plugin URI: http://boneanu.homeip.net/wordpress-plugins
Description: The plugin displays the biorhythm in the sidebar. Make sure the folder 'img' is writable. In this folder the plugin will store the pictures of the biorhythms of your visitors. Each file is about 1.5KB so you will have to cleanup sometimes.
Author: Dragos Boneanu
Version: 1.0
Author URI: http://boneanu.homeip.net
*/

/*
Copyright © 2009  Dragos Boneanu (email: zgudu70@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function get_biorhythm_defaults() {
    $defaults = array(
        'title'                 => 'Biorhythm',
        'link_label'            => 'Change dates',
        'birth_date_label'      => 'Birth date:',
        'calc_date_label'       => 'Calculation date:',
        'physical_label'        => 'Physical',
        'emotional_label'       => 'Emotional',
        'intellectual_label'    => 'Intellectual',
        'intuitiv_label'        => 'Intuitiv',
        'days_to_calculate'     => 14,                  # days to display before and after the calculation date
        'margin_gap'            => 2,                   # gap from left and right margin (pixels)
        'horizontal_increment'  => 5,                   # distance between 2 days dots (pixels)
        'canvas_height'         => 150,                 # height of entire image (pixels)
        'image_height'          => 80,                  # height of graph image (pixels)
        'bg_color'              => '0, 0, 0',           # RGB color of background
        'axis_color'            => '255, 255, 255',     # RGB color of time axis
        'today_color'           => '255, 255, 255',     # RGB color of today axis
        'physical_color'        => '255, 0, 0',         # RGB color of physical dots and label
        'emotional_color'       => '0, 255, 0',         # RGB color of emotional dots and label
        'intellectual_color'    => '0, 190, 255',       # RGB color of intellectual dots and label
        'intuitiv_color'        => '255, 225, 94',      # RGB color of intuitiv dots and label
        'biorhythm_url_dirname' => get_option('siteurl').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__)),
        'biorhythm_fs_dirname'  => str_replace('\\', '/', dirname(__FILE__))
    );
    
    return $defaults;
}
add_action('admin_head', 'get_biorhythm_defaults');
add_action('wp_head', 'get_biorhythm_defaults');


function biorhythm_options_form_table($options) {
?>
<table>
    <tr><td align="right"><strong>Title</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-title" name="biorhythm-title" value="<?php echo wp_specialchars($options['title'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">The title to be displayed on the sidebar</td>
    </tr>
    <tr><td align="right"><strong>Link Label</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-link-label" name="biorhythm-link-label" value="<?php echo wp_specialchars($options['link_label'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">The link text to be displayed on the sidebar</td>
    </tr>
    <tr><td align="right"><strong>Birth Date Label</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-birth-date-label" name="biorhythm-birth-date-label" value="<?php echo wp_specialchars($options['birth_date_label'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">The text to be displayed in the sidebar form for birth date</td>
    </tr>
    <tr><td align="right"><strong>Calculation Date Label</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-calc-date-label" name="biorhythm-calc-date-label" value="<?php echo wp_specialchars($options['calc_date_label'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">The text to be displayed in the sidebar form for calculation date</td>
    </tr>
    <tr><td align="right"><strong>Physical Cycle Label</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-physical-label" name="biorhythm-physical-label" value="<?php echo wp_specialchars($options['physical_label'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">The text to be displayed on the image for physical cycle</td>
    </tr>
    <tr><td align="right"><strong>Emotional Cycle Label</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-emotional-label" name="biorhythm-emotional-label" value="<?php echo wp_specialchars($options['emotional_label'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">The text to be displayed on the image for emotional cycle</td>
    </tr>
    <tr><td align="right"><strong>Intellectual Cycle Label</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-intellectual-label" name="biorhythm-intellectual-label" value="<?php echo wp_specialchars($options['intellectual_label'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">The text to be displayed on the image for intellectual cycle</td>
    </tr>
    <tr><td align="right"><strong>Intuitiv Cycle Label</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-intuitiv-label" name="biorhythm-intuitiv-label" value="<?php echo wp_specialchars($options['intuitiv_label'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">The text to be displayed on the image for intuitiv cycle</td>
    </tr>
    <tr><td align="right"><strong>Number Of Days To Calculate</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-days-to-calculate" name="biorhythm-days-to-calculate" value="<?php echo wp_specialchars($options['days_to_calculate'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">The number of day dots to displayed before and after the calculation date</td>
    </tr>
    <tr><td align="right"><strong>Left and Right Margin Gap</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-margin-gap" name="biorhythm-margin-gap" value="<?php echo wp_specialchars($options['margin_gap'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">Left and right margin gap for displaying the dots (pixels)</td>
    </tr>
    <tr><td align="right"><strong>Horizontal Increment</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-horizontal-increment" name="biorhythm-horizontal-increment" value="<?php echo wp_specialchars($options['horizontal_increment'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">The distance between 2 days dots (pixels)</td>
    </tr>
    <tr><td align="right"><strong>Canvas Height</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-canvas-height" name="biorhythm-canvas-height" value="<?php echo wp_specialchars($options['canvas_height'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">The height of entire image (pixels)</td>
    </tr>
    <tr><td align="right"><strong>Image Height</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-image-height" name="biorhythm-image-height" value="<?php echo wp_specialchars($options['image_height'], true); ?>" /></td>
        <td style="font-size:0.75em" align="left">The height of graph image (pixels)</td>
    </tr>
    <tr><td align="right"><strong>Background color of graph</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-bg-color" name="biorhythm-bg-color" value="<?php echo wp_specialchars($options['bg_color'], true); ?>" onchange="validateColor(this)" /></td>
        <td style="font-size:0.75em" align="left">The background color of the image (RGB format with comma separator)</td>
    </tr>
    <tr><td align="right"><strong>Axis Color</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-axis-color" name="biorhythm-axis-color" value="<?php echo wp_specialchars($options['axis_color'], true); ?>" onchange="validateColor(this)" /></td>
        <td style="font-size:0.75em" align="left">The color of time axis (RGB format with comma separator)</td>
    </tr>
    <tr><td align="right"><strong>Calculation date color</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-today-color" name="biorhythm-today-color" value="<?php echo wp_specialchars($options['today_color'], true); ?>" onchange="validateColor(this)" /></td>
        <td style="font-size:0.75em" align="left">The color of calculation date axis (RGB format with comma separator)</td>
    </tr>
    <tr><td align="right"><strong>Physical cycle color</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-physical-color" name="biorhythm-physical-color" value="<?php echo wp_specialchars($options['physical_color'], true); ?>" onchange="validateColor(this)"/></td>
        <td style="font-size:0.75em" align="left">The color of the physical cycle dots (RGB format with comma separator)</td>
    </tr>
    <tr><td align="right"><strong>Emotional cycle color</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-emotional-color" name="biorhythm-emotional-color" value="<?php echo wp_specialchars($options['emotional_color'], true); ?>" onchange="validateColor(this)" /></td>
        <td style="font-size:0.75em" align="left">The color of the emotional cycle dots (RGB format with comma separator)</td>
    </tr>
    <tr><td align="right"><strong>Intellectual cycle color</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-intellectual-color" name="biorhythm-intellectual-color" value="<?php echo wp_specialchars($options['intellectual_color'], true); ?>" onchange="validateColor(this)" /></td>
        <td style="font-size:0.75em" align="left">The color of the intellectual cycle dots (RGB format with comma separator)</td>
    </tr>
    <tr><td align="right"><strong>Intuitiv cycle color</strong></td>
        <td><input style="text-align:right" type="text" id="biorhythm-intuitiv-color" name="biorhythm-intuitiv-color" value="<?php echo wp_specialchars($options['intuitiv_color'], true); ?>" onchange="validateColor(this)" /></td>
        <td style="font-size:0.75em" align="left">The color of the intuitiv cycle dots (RGB format with comma separator)</td>
    </tr>
</table>
<?php
}


function biorhythm_css_header() {
    echo '<!-- Biorhythm CSS START -->'."\n";
    echo '<link rel="stylesheet" type="text/css" href="'.plugins_url('biorhythm/biorhythm.css').'" />'."\n";
    echo '<!-- Biorhythm CSS END -->'."\n\n";
}
add_action('wp_head', 'biorhythm_css_header');


function biorhythm_js_header() {
    echo '<!-- Biorhythm javascript START -->'."\n";
    echo '<script type="text/javascript" src="'.plugins_url('biorhythm/biorhythm.js').'"></script>'."\n";
    echo '<!-- Biorhythm javascript END -->'."\n\n";
}
add_action('admin_head', 'biorhythm_js_header');
add_action('wp_head', 'biorhythm_js_header');


function biorhythm_calendar_header() {
?>
<!-- Biorhythm calendar START -->
<style type="text/css">@import url("<?php echo plugins_url('biorhythm/jscalendar/calendar-win2k-1.css'); ?>");</style>
<script type="text/javascript" src="<?php echo plugins_url('biorhythm/jscalendar/calendar.js'); ?>"></script>
<script type="text/javascript" src="<?php echo plugins_url('biorhythm/jscalendar/calendar-setup.js'); ?>"></script>
<script type="text/javascript" src="<?php echo plugins_url('biorhythm/jscalendar/lang/calendar-en.js'); ?>"></script>
<!-- Biorhythm calendar END -->

<?php
}
add_action('wp_head', 'biorhythm_calendar_header');


function biorhythm_form_header() {
?>
<!-- Biorhythm form submit START -->
<script type="text/javascript" language="javascript">
function submitForm() {
    if(document.biorhythm_form.birth_date.value == "") {
        alert("The birth date cannot be blank");
        document.biorhythm_form.birth_date.focus();
        return false;
    }
    if(document.biorhythm_form.calc_date.value == "") {
        alert("The calculation date cannot be blank");
        document.biorhythm_form.calc_date.focus();
        return false;
    }
    re = new RegExp("^(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$");
    if (!re.test(document.biorhythm_form.birth_date.value)) {
        alert("The birth date is not valid");
        document.biorhythm_form.birth_date.focus();
        return false;
    }
    if (!re.test(document.biorhythm_form.calc_date.value)) {
        alert("The calculation date is not valid");
        document.biorhythm_form.calc_date.focus();
        return false;
    }
    document.biorhythm_form.submit();
}
</script>
<!-- Biorhythm form submit END -->

<?php
}
add_action('wp_head', 'biorhythm_form_header');


function biorhythm_add_page() {
    // Add a new submenu under Options:
    add_options_page('Biorhythm', 'Biorhythm', 8, 'biorhythmoptions', 'biorhythm_options_page');
}
add_action('admin_menu', 'biorhythm_add_page');


function biorhythm_options_page() {
    $options = $newoptions = get_option('biorhythm_options');
    if ($_POST['biorhythm-submit']) {
        $newoptions['title'] = strip_tags(stripslashes($_POST['biorhythm-title']));
        $newoptions['link_label'] = strip_tags(stripslashes($_POST['biorhythm-link-label']));
        $newoptions['birth_date_label'] = strip_tags(stripslashes($_POST['biorhythm-birth-date-label']));
        $newoptions['calc_date_label'] = strip_tags(stripslashes($_POST['biorhythm-calc-date-label']));
        $newoptions['physical_label'] = strip_tags(stripslashes($_POST['biorhythm-physical-label']));
        $newoptions['emotional_label'] = strip_tags(stripslashes($_POST['biorhythm-emotional-label']));
        $newoptions['intellectual_label'] = strip_tags(stripslashes($_POST['biorhythm-intellectual-label']));
        $newoptions['intuitiv_label'] = strip_tags(stripslashes($_POST['biorhythm-intuitiv-label']));
        $newoptions['days_to_calculate'] = strip_tags(stripslashes($_POST['biorhythm-days-to-calculate']));
        $newoptions['margin_gap'] = strip_tags(stripslashes($_POST['biorhythm-margin-gap']));
        $newoptions['horizontal_increment'] = strip_tags(stripslashes($_POST['biorhythm-horizontal-increment']));
        $newoptions['canvas_height'] = strip_tags(stripslashes($_POST['biorhythm-canvas-height']));
        $newoptions['image_height'] = strip_tags(stripslashes($_POST['biorhythm-image-height']));
        $newoptions['bg_color'] = strip_tags(stripslashes($_POST['biorhythm-bg-color']));
        $newoptions['axis_color'] = strip_tags(stripslashes($_POST['biorhythm-axis-color']));
        $newoptions['today_color'] = strip_tags(stripslashes($_POST['biorhythm-today-color']));
        $newoptions['physical_color'] = strip_tags(stripslashes($_POST['biorhythm-physical-color']));
        $newoptions['emotional_color'] = strip_tags(stripslashes($_POST['biorhythm-emotional-color']));
        $newoptions['intellectual_color'] = strip_tags(stripslashes($_POST['biorhythm-intellectual-color']));
        $newoptions['intuitiv_color'] = strip_tags(stripslashes($_POST['biorhythm-intuitiv-color']));
?>
        <div class="updated"><p><strong>Biorhythm options saved</strong></p></div>
<?php
    }

    if ($options != $newoptions) {
        $options = $newoptions;
        update_option('biorhythm_options', $options);
    }

    echo '<div class="wrap">';
    echo '    <h2>Biorhythm Options</h2>';
?>
    <form name="biorhythm_admin_form" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <?php wp_nonce_field('update-options') ?>
        <?php biorhythm_options_form_table($options) ?>
        <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Update Options &raquo;') ?>" />
        </p>
        <input type="hidden" name="biorhythm-submit" id="biorhythm-submit" value="1" />
    </form>
</div>
<?php
}


function widget_biorhythm_init() {
    if (!function_exists('register_sidebar_widget') || !function_exists('register_widget_control')) {
        return;
    }

    function widget_biorhythm_control() {
        $options = $newoptions = get_option('biorhythm_options');
        if ($_POST['biorhythm-submit']) {
            $newoptions['title'] = strip_tags(stripslashes($_POST['biorhythm-title']));
            $newoptions['link_label'] = strip_tags(stripslashes($_POST['biorhythm-link-label']));
            $newoptions['birth_date_label'] = strip_tags(stripslashes($_POST['biorhythm-birth-date-label']));
            $newoptions['calc_date_label'] = strip_tags(stripslashes($_POST['biorhythm-calc-date-label']));
            $newoptions['physical_label'] = strip_tags(stripslashes($_POST['biorhythm-physical-label']));
            $newoptions['emotional_label'] = strip_tags(stripslashes($_POST['biorhythm-emotional-label']));
            $newoptions['intellectual_label'] = strip_tags(stripslashes($_POST['biorhythm-intellectual-label']));
            $newoptions['intuitiv_label'] = strip_tags(stripslashes($_POST['biorhythm-intuitiv-label']));
            $newoptions['days_to_calculate'] = strip_tags(stripslashes($_POST['biorhythm-days-to-calculate']));
            $newoptions['margin_gap'] = strip_tags(stripslashes($_POST['biorhythm-margin-gap']));
            $newoptions['horizontal_increment'] = strip_tags(stripslashes($_POST['biorhythm-horizontal-increment']));
            $newoptions['canvas_height'] = strip_tags(stripslashes($_POST['biorhythm-canvas-height']));
            $newoptions['image_height'] = strip_tags(stripslashes($_POST['biorhythm-image-height']));
            $newoptions['bg_color'] = strip_tags(stripslashes($_POST['biorhythm-bg-color']));
            $newoptions['axis_color'] = strip_tags(stripslashes($_POST['biorhythm-axis-color']));
            $newoptions['today_color'] = strip_tags(stripslashes($_POST['biorhythm-today-color']));
            $newoptions['physical_color'] = strip_tags(stripslashes($_POST['biorhythm-physical-color']));
            $newoptions['emotional_color'] = strip_tags(stripslashes($_POST['biorhythm-emotional-color']));
            $newoptions['intellectual_color'] = strip_tags(stripslashes($_POST['biorhythm-intellectual-color']));
            $newoptions['intuitiv_color'] = strip_tags(stripslashes($_POST['biorhythm-intuitiv-color']));
        }
        if ($options != $newoptions) {
            $options = $newoptions;
            update_option('biorhythm_options', $options);
        }
?>
    <div style="text-align:center">
        <h3>Biorhythm Options</h3>
        <span style="line-height:15px"><br /><br /></span>
        <?php biorhythm_options_form_table($options) ?>
        <input type="hidden" name="biorhythm-submit" id="biorhythm-submit" value="1" />
    </div>
<?php
    }

    function widget_biorhythm($args) {
        extract($args);
        $options = (array) get_option('biorhythm_options');

        echo $before_widget."\n";
        echo $before_title.$options['title'].$after_title."\n";
        echo '<ul>'."\n";
        biorhythm();
        echo '</ul>'."\n";
        echo $after_widget."\n";
    }

    register_sidebar_widget('Biorhythm', 'widget_biorhythm');
    register_widget_control('Biorhythm', 'widget_biorhythm_control', 700, 510);
}
add_action('widgets_init', 'widget_biorhythm_init');


function biorhythm() {
    $defaults = get_biorhythm_defaults();

    $biorhythm_cfg_array = (array) get_option('biorhythm_options');

    foreach ($defaults as $key => $value) {
        if ($biorhythm_cfg_array[$key] == "") {
            $biorhythm_cfg_array[$key] = $defaults[$key];
        }
    }
    extract($biorhythm_cfg_array);

    $input_form = 1; # display the date input form
    if (isset($_COOKIE['my_birth_date']) and $_COOKIE['my_birth_date'] != '') {
        $birth_date = $_COOKIE['my_birth_date'];
        $calc_date = date('Y-m-d');
        $input_form = 0;
    }
    if (isset($_POST['submit_form'])) {
        $birth_date = $_POST['birth_date'];
        $calc_date = $_POST['calc_date'];

        $cookie_name_str = 'my_birth_date';
        $cookie_value = $birth_date;
        $cookie_ttl = 30; # cookie time to live (days)
        @setcookie($cookie_name_str, $cookie_value, time()+ $cookie_ttl * 60*60*24, '/');
        $input_form = 0;
    }
    if ($input_form == 1) {
        $return = biorhythm_html_form($birth_date, $calc_date, 1, $biorhythm_cfg_array);
    } else {
        $return  = biorhythm_html_form($birth_date, $calc_date, 0, $biorhythm_cfg_array);
        $return .= biorhythm_html_img($birth_date, $calc_date, $biorhythm_cfg_array);
    }
    echo apply_filters( 'biorhythm', $return );
}


function biorhythm_color($color_str) {
   $return = explode(',', str_replace(' ', '', $color_str));
   return apply_filters( 'biorhythm_color', $return, $color_str );
}


function biorhythm_make_gif($birth_date, $calc_date, $biorhythm_cfg_array) {
    extract($biorhythm_cfg_array);

    $debug = 0; # 1 for debug

    // create a blank image
    $canvas_width = $margin_gap * 2 + $days_to_calculate * 2 * $horizontal_increment;
    $image_width = $margin_gap * 2 + $days_to_calculate * 2 * $horizontal_increment;
    $half_height = $image_height / 2;

    $image = imagecreatetruecolor($canvas_width, $canvas_height);

    $biorhythm_cycles_array = array (
        'physical'     => 23,
        'emotional'    => 28,
        'intellectual' => 33,
        'intuitiv'     => 38
    );

    foreach ($biorhythm_cycles_array as $biorhythm_cycle => $biorhythm_cycle_duration) {
        list($color_R, $color_G, $color_B) = biorhythm_color(${$biorhythm_cycle.'_color'});
        $biorhythm_array[$biorhythm_cycle] = array(
            $biorhythm_cycle_duration,
            ${$biorhythm_cycle.'_label'},
            imagecolorallocate($image, $color_R, $color_G, $color_B));
    }

# fill the background color
    list($color_R, $color_G, $color_B) = biorhythm_color($bg_color);
    $bg_color = imagecolorallocate($image, $color_R, $color_G, $color_B);

# time axis color
    list($color_R, $color_G, $color_B) = biorhythm_color($axis_color);
    $axis_color = imagecolorallocate($image, $color_R, $color_G, $color_B);

# today axis color
    list($color_R, $color_G, $color_B) = biorhythm_color($today_color);
    $today_color = imagecolorallocate($image, $color_R, $color_G, $color_B);

    list($Y,$m,$d) = split('-', $birth_date);
    $birth_mktime = mktime(0, 0, 0, (int)$m, (int)$d, (int)$Y);

    list($Y,$m,$d) = split('-', $calc_date);
    for ($idx=-$days_to_calculate; $idx<=$days_to_calculate; $idx++) {
        $calc_mktime = mktime(0, 0, 0, (int)$m, (int)$d + $idx, (int)$Y);
        $days_from_birth = ($calc_mktime - $birth_mktime) / (60 * 60 * 24);

        foreach ($biorhythm_array as $key => $value) {
            $return_array[$idx][$key] = sin(2 * pi() * $days_from_birth / $value[0]);
        }
    }

    if ($debug == 0) {
        imagefilledrectangle($image, 0, 0, $image_width, $image_height, $bg_color); # the background
        imageline($image, 0, $half_height, $image_width, $half_height, $axis_color); # time axis
        imagefilledrectangle($image, (int)($image_width/2), (int)($half_height - $image_height*0.53), (int)($image_width/2), (int)($half_height + $image_height*0.53), $today_color); # today axis
    }

    $i = 0;
    foreach ($return_array as $key => $value) {
        $ellipse_cen_x = (int)($margin_gap + $horizontal_increment * $i++);
        $text_font = 3;
        $j = 1;
        foreach ($biorhythm_array as $bio_cycle_name => $bio_cycle_info) {
            $ellipse_cen_y[$bio_cycle_name] = $image_height - (int)($half_height + $half_height * $value[$bio_cycle_name]);

            $ellipse_cen[$key] = array($ellipse_cen_x, $ellipse_cen_y[$bio_cycle_name]);

            if ($debug == 0) { # output the biorhythm cycle dots
                imagefilledellipse($image, $ellipse_cen_x, $ellipse_cen_y[$bio_cycle_name], 4, 4, $bio_cycle_info[2]);
                imagestring($image, $text_font, $margin_gap * 6, $image_height + $margin_gap * 6 * $j++, $bio_cycle_info[1], $bio_cycle_info[2]);
            }
        }
    }

    # output the picture or display debug information
    if ($debug == 0) {
        imagegif($image, $biorhythm_fs_dirname.'/img/'.$birth_date.'_'.$calc_date.'.gif'); # write the gif file
        imagedestroy ($image);
        return $biorhythm_url_dirname.'/img/'.$birth_date.'_'.$calc_date.'.gif';
    } else {
        echo '<pre>';
        print_r($biorhythm_cfg_array);
        print_r($return_array);
        print_r($ellipse_cen);
        echo '</pre>';
    }
}


function biorhythm_html_form($birth_date, $calc_date, $display_form, $biorhythm_cfg_array) {
    extract($biorhythm_cfg_array);

    $return =
'<div class="biorhythm_expand"><li><a href="javascript:expand_biorhythm_form(\'biorhythm_form\');">'.$link_label.'</a></li></div>
<div class="biorhythm_form" id="biorhythm_form"'.(($display_form == 0)?' style="display:none"':'').'>
<form name="biorhythm_form" action="'.$_SERVER['PHP_SELF'].'" method="post" style="margin-bottom:0;">
    '.$birth_date_label.'<br />
    <input class="biorhythm_input" type="text" name="birth_date" id="birth_date" value="'.((isset($birth_date) and $birth_date != '')?$birth_date:'').'" size="10" readonly />
    <a href="#" id="birth_date_dateview"><img class="biorhythm_icon" src="'.$biorhythm_url_dirname.'/jscalendar/calendar.gif" alt="Select Date" /></a>
    <script type="text/javascript">Calendar.setup({ifFormat:"%Y-%m-%d", inputField:"birth_date", button:"birth_date_dateview"});</script>
    <br />
    '.$calc_date_label.'<br />
    <input class="biorhythm_input" type="text" name="calc_date" id="calc_date" value="'.((isset($calc_date) and $calc_date != '')?$calc_date:date('Y-m-d')).'" size="10" readonly />
    <a href="#" id="calc_date_dateview"><img class="biorhythm_icon" src="'.$biorhythm_url_dirname.'/jscalendar/calendar.gif" alt="Select Date" /></a>
    <script type="text/javascript">Calendar.setup({ifFormat:"%Y-%m-%d", inputField:"calc_date", button:"calc_date_dateview"});</script>
    <br />
    <input type="hidden" name="submit_form" value="submit" />
    <input class="biorhythm_submit" type="button" value="submit" onclick="submitForm();" />
</form>
</div>'."\n";
    return apply_filters( 'biorhythm_html_form', $return, $birth_date, $calc_date, $display_form, $biorhythm_cfg_array );
}


function biorhythm_html_img($birth_date, $calc_date, $biorhythm_cfg_array) {
    extract($biorhythm_cfg_array);
    
    $biorhythm_url_img_filename = $biorhythm_url_dirname.'/img/'.$birth_date.'_'.$calc_date.'.gif';
    if (!file_exists($biorhythm_fs_dirname.'/img/'.$birth_date.'_'.$calc_date.'.gif')) {
        $biorhythm_url_img_filename = biorhythm_make_gif($birth_date, $calc_date, $biorhythm_cfg_array);
    }

    $return = '<img src="'.$biorhythm_url_img_filename.'" border="0" />'."\n";
    return apply_filters( 'biorhythm_html_img', $return, $birth_date, $calc_date, $biorhythm_cfg_array );
}


?>
