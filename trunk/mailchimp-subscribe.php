<?php
/*
Plugin Name: MailChimp Subscription Plus
Version: 1.0
Plugin URI: http://www.finalwebsites.com/
Description: Raise the count of new subscribers for your blog or website by using MailChimp and a professional subscribe form.
Author: Olaf Lederer
Author URI: http://www.finalwebsites.com/
Text Domain: fws-mailchimp-subscribe
Domain Path: /languages/
License: GPL v3

MailChimp Subscription Plus
Copyright (C) 2014, Olaf Lederer - olaf@finalwebsites.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

include_once('MailChimp.class.php');

add_action( 'plugins_loaded', 'FWSMC_load_textdomain' );

function FWSMC_load_textdomain() {
	load_plugin_textdomain( 'fws-mailchimp-subscribe', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('admin_menu', 'FWSMC_plugin_menu');

function FWSMC_plugin_menu() {
	add_options_page('MailChimp Subscribe Options', 'MailChimp Subscribe', 'manage_options', 'FWSMC-topmenu', 'FWSMC_options_page');
	add_action( 'admin_init', 'register_FWSMC_setting' );
}

add_action('wp_enqueue_scripts', 'FWSMC_add_script');

function FWSMC_add_script() {
	global $post;
	if((is_single() && get_option('fwsmc-addToContent')) || ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'FWSSubscriptionForm') )) {
		wp_enqueue_script('fws-mailchimp', plugin_dir_url(__FILE__).'mc.js', array('jquery') );
		wp_localize_script( 'fws-mailchimp', 'ajax_object',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'plugin_base_path' => plugin_dir_url(__FILE__),
				'js_alt_loading' => __( 'Loading...', 'fws-mailchimp-subscribe' ),
				'js_msg_enter_email_name' => __( 'Please enter your name and email address.', 'fws-mailchimp-subscribe' ),
				'js_msg_invalid_email' => __( 'The entered mail address is invalid.', 'fws-mailchimp-subscribe' ),
				'js_default_firstname' => __( 'Your first name', 'fws-mailchimp-subscribe' ),
				'googleanalytics' => get_option('fwsmc-googleanalytics'),
				'clickyanalytics' => get_option('fwsmc-clickyanalytics')
			)
		);
		if (get_option('fwsmc-include-css')) {
			wp_enqueue_style( 'fws-mailchimp-style', plugin_dir_url(__FILE__).'style.css' );
		}
	}
}

function register_FWSMC_setting() {
	register_setting( 'FWSMC_options', 'fwsmc-firstNameMergField' );
	register_setting( 'FWSMC_options', 'fwsmc-extraMergeField' );
	register_setting( 'FWSMC_options', 'fwsmc-extraMergeFieldValue' );
	register_setting( 'FWSMC_options', 'fwsmc-listID' );
	register_setting( 'FWSMC_options', 'fwsmc-apiKey' );
	register_setting( 'FWSMC_options', 'fwsmc-include-css' );
	register_setting( 'FWSMC_options', 'fwsmc-addToContent' );
	register_setting( 'FWSMC_options', 'fwsmc-googleanalytics' );
	register_setting( 'FWSMC_options', 'fwsmc-clickyanalytics' );
}

function FWSMC_options_page() {

	echo '
	<div class="wrap">
		<h2>MailChimp Subscription Plus</h2>
		<p>You need a working MailChimp account, a valid API key and mailing list ID to use this plugin. Register a free <a href="http://eepurl.com/r54KL">Mailchimp account</a>, setup a mailing list and get an API key.</p>
		<p>Enter below the required settings and click the button below to safe them.</p>';

	echo '
		<form action="options.php" method="post">';
	settings_fields( 'FWSMC_options' );
	echo '
			<h3>Configuration</h3>

			<table class="form-table">
				<tr valign="top">
					<th scope="row"> MailChimp API Key: </th>
					<td>
						<input class="regular-text" type="text" placeholder="" value="'.esc_attr( get_option('fwsmc-apiKey') ).'" name="fwsmc-apiKey">
						<p class="description">Get one from your MailChimp account: Your Account &raquo; Extra\'s &raquo; API Keys</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"> MailChimp List ID: </th>
					<td>
						<input class="regular-text" type="text" placeholder="" value="'.esc_attr( get_option('fwsmc-listID') ).'" name="fwsmc-listID">
						<p class="description">Create a mailing list and enter the ID here: Lists  &raquo; Settings (at the bottom)</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"> Merge field "First name": </th>
					<td>
						<input class="regular-text" type="text" placeholder="" value="'.esc_attr( get_option('fwsmc-firstNameMergField') ).'" name="fwsmc-firstNameMergField">
						<p class="description">Enter here the merge field for the first name: Lists  &raquo; Settings &raquo; List fields and *|MERGE|* tags</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"> Optional merge field (name)</th>
					<td>
						<input class="regular-text" type="text" placeholder="" value="'.esc_attr( get_option('fwsmc-extraMergeField') ).'" name="fwsmc-extraMergeField">
						<p class="description">Use this optional merge field for a unique ID if you use the same list ID on different places.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"> Optional merge field (value)</th>
					<td>
						<input class="regular-text" type="text" placeholder="" value="'.esc_attr( get_option('fwsmc-extraMergeFieldValue') ).'" name="fwsmc-extraMergeFieldValue">
						<p class="description">Add here the value for your additional merge field. You can overule this value if you use the form shortcode!</p>
					</td>
				</tr>';
				$checkCss = (get_option('fwsmc-include-css')) ? ' checked="checked"' : '';
				$checkContent = (get_option('fwsmc-addToContent')) ? ' checked="checked"' : '';
				echo '
				<tr valign="top">
					<th scope="row"> Include CSS </th>
					<td>
						<label for="fwsmc-include-css">
						<input id="fwsmc-include-css" type="checkbox" value="1" name="fwsmc-include-css"'.$checkCss.'>
						Include our stylesheet for your web form
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"> Include the form in all blogs </th>
					<td>
						<label for="fwsmc-addToContent">
						<input id="fwsmc-addToContent" type="checkbox" value="1" name="fwsmc-addToContent"'.$checkContent.'>
						Use this checkbox to add the subscription form at the end of each blog post.
						</label>
					</td>
				</tr>
			</table>
			<h4>Don\'t use the fields below if your Google Analytics or Clicky JavaScript snippet isn\'t installed!</h4>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"> Track page views in Google Analytics </th>
					<td>
						<input class="regular-text" type="text" placeholder="" value="'.esc_attr( get_option('fwsmc-googleanalytics') ).'" name="fwsmc-googleanalytics">
						<p class="description">Track a page view in Google analytics after the subscription form is submitted (f.e. /subscription/submitted.html).</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"> Track goals in Clicky </th>
					<td>
						<input class="regular-text" type="text" placeholder="" value="'.esc_attr( get_option('fwsmc-clickyanalytics') ).'" name="fwsmc-clickyanalytics">
						<p class="description">Add here the goal ID for a manual goal you\'ve already defined in Clicky (check the FAQ for information).</p>
					</td>
				</tr>
			</table>

			<p class="submit">
				<input class="button-primary" type="submit" value="Save Changes">
			</p>
		</form>';
		if (get_option('fwsmc-apiKey')) echo '
		<h3>How to use?</h3>
		<p>You can include the subscription form in every post and it\'s possible to add the following shortcode into your page or post.</p>
		<p><code>[FWSSubscriptionForm]</code> or <code>[FWSSubscriptionForm extramergefield="via blog post"]</code></p>
	</div>';
}


add_action( 'wp_ajax_subscribeform_action', 'FWSMC_subform_action_callback' );
add_action( 'wp_ajax_nopriv_subscribeform_action', 'FWSMC_subform_action_callback' );

function FWSMC_subform_action_callback() {
	$error = '';
	$status = 'error';

	if (empty($_POST['name']) || empty($_POST['email'])) {
		$error = __( 'Both fields are required to enter.', 'fws-mailchimp-subscribe' );
	} else {
		if (!wp_verify_nonce($_POST['_fwsmc_subnonce'], 'fwsmc_subform')) {
			$error = __( 'Verification error, try again.', 'fws-mailchimp-subscribe' );
		} else {
			$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
			$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$extranamevalue = filter_var($_POST['extramergefield'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
			$ak = get_option('fwsmc-apiKey');
			$mc = new MailChimp($ak);
			$fnamevar = get_option('fwsmc-firstNameMergField');
			$mvars = array('optin_ip'=>$_SERVER['REMOTE_ADDR'], $fnamevar => $name);
			if ($extranamevar = get_option('fwsmc-extraMergeField')) {
				$mvars[$extranamevar] = $extranamevalue;
			}
			$result = $mc->call('lists/subscribe', array(
				'id'                => get_option('fwsmc-listID'),
				'email'             => array('email'=>$email),
				'merge_vars'        => $mvars,
				'double_optin'      => true,
				'update_existing'   => false,
				'replace_interests' => false,
				'send_welcome'      => false
			));

			//var_dump($result);

			if (!empty($result['euid'])) {
				$error = __( 'Thanks, please check your emailbox and confirm your subscription.', 'fws-mailchimp-subscribe' );
				$status = 'success';
			} else {
				if (isset($result['status'])) {
					switch ($result['code']) {
						case 214:
						$error = __( 'You\'re already subscribed to this list.', 'fws-mailchimp-subscribe' );
						break;
						// check the MailChimp API for more options
						default:
						$error = __( 'An unknown error occurred.', 'fws-mailchimp-subscribe' );
						break;
					}
				}

			}
		}
	}

	$resp = array('status' => $status, 'errmessage' => $error);
	header( "Content-Type: application/json" );
	echo json_encode($resp);
	die();
}

add_filter( 'the_content', 'FWSMC_add_to_content', 20 );

function FWSMC_add_to_content($content) {
	if (get_option('fwsmc-addToContent')) {
		$content .= FWSMC_create_subform();
	}
	return $content;
}

function FWSMC_create_subform($atts = null) {
	extract( shortcode_atts(
		array(
			'extramergefield' => get_option('fwsmc-extraMergeFieldValue')
		), $atts )
	);
	return '<h3>'.__( 'Subscribe now!', 'fws-mailchimp-subscribe' ).'</h3>
		<p>'.__( 'Subscribe today and get future blog posts your email.', 'fws-mailchimp-subscribe' ).'</p>
		<form id="subscribeform" role="form" class="form-inline">
			<div class="form-group">
				<label class="sr-only" for="firstname">'.__( 'Your first name', 'fws-mailchimp-subscribe' ).'</label>
				<input type="text" class="form-control defaultText" title="'.__( 'Your first name', 'fws-mailchimp-subscribe' ).'" id="firstname" name="name" tabindex="1" />
			</div>
			<div class="form-group">
				<label class="sr-only" for="emailaddress">'.__( 'Your email address', 'fws-mailchimp-subscribe' ).'</label>
				<input type="email" class="form-control defaultText" title="'.__( 'Your email address', 'fws-mailchimp-subscribe' ).'" id="emailaddress" name="email" tabindex="2" />
			</div>
			'.wp_nonce_field('fwsmc_subform', '_fwsmc_subnonce', true, false).'
			<input type="hidden" name="action" value="subscribeform_action" />
			<input type="hidden" name="extramergefield" value="'.esc_attr($extramergefield).'" />
			<button class="btn btn-primary btn-sm" id="subbutton" tabindex="3" type="button">'.__( 'Subscribe', 'fws-mailchimp-subscribe' ).'</button>
		</form>
		<div id="submsg" class="error-message"></div>
	';
}
add_shortcode('FWSSubscriptionForm', 'FWSMC_create_subform');

