<?php
//MULTI_SITE
if( is_multisite() ) {
//url to post
$spam_master_url = "aHR0cDovL3NwYW1tYXN0ZXIudGVjaGdhc3AuY29tL2xpY2Vuc2UvZ2V0X2xpYy5waHA=";
$spam_master_url_post = base64_decode($spam_master_url);
//create array of data to be posted
$time = current_time('mysql');
$wordpress = get_bloginfo('version');
$blog = get_site_option('blogname');
$admin_email = get_site_option('admin_email');
$web_adress = get_site_url();
$spam_master_version = get_site_option('spam_master_installed_version');
$spam_master_protection = get_site_option('spam_master_selected');
$license = get_site_option('spam_master_license_code');
$post_data['Time']			= urlencode($time);
$post_data['Wordpress']		= urlencode($wordpress);
$post_data['Blog Name']		= urlencode($blog);
$post_data['Admin Email']	= urlencode($admin_email);
$post_data['Web Adress']	= urlencode($web_adress);
$post_data['Spam Master']	= urlencode($spam_master_version);
$post_data['Protection']	= urlencode($spam_master_protection);
$post_data['License Code']	= urlencode($license);

//traverse array and prepare data for posting (key1=value1)
foreach ( $post_data as $key => $value) {$post_items[] = $key . '=' . $value;}

//create the final string to be posted using implode()
$post_string = implode ('&', $post_items);

$curl_connection = curl_init($spam_master_url_post);
curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

//set data to be posted
curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);

//perform our request
$result = curl_exec($curl_connection);

//close the connection
curl_close($curl_connection);
}
//SINGLE_SITE
else{
//url to post
$spam_master_url = "aHR0cDovL3NwYW1tYXN0ZXIudGVjaGdhc3AuY29tL2xpY2Vuc2UvZ2V0X2xpYy5waHA=";
$spam_master_url_post = base64_decode($spam_master_url);
//create array of data to be posted
$time = current_time('mysql');
$wordpress = get_bloginfo('version');
$blog = get_option('blogname');
$admin_email = get_option('admin_email');
$web_adress = get_site_url();
$spam_master_version = get_option('spam_master_installed_version');
$spam_master_protection = get_option('spam_master_selected');
$license = get_option('spam_master_license_code');
$post_data['Time']			= urlencode($time);
$post_data['Wordpress']		= urlencode($wordpress);
$post_data['Blog Name']		= urlencode($blog);
$post_data['Admin Email']	= urlencode($admin_email);
$post_data['Web Adress']	= urlencode($web_adress);
$post_data['Spam Master']	= urlencode($spam_master_version);
$post_data['Protection']	= urlencode($spam_master_protection);
$post_data['License Code']	= urlencode($license);

//traverse array and prepare data for posting (key1=value1)
foreach ( $post_data as $key => $value) {$post_items[] = $key . '=' . $value;}

//create the final string to be posted using implode()
$post_string = implode ('&', $post_items);

$curl_connection = curl_init($spam_master_url_post);
curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

//set data to be posted
curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);

//perform our request
$result = curl_exec($curl_connection);

//close the connection
curl_close($curl_connection);
}
?>