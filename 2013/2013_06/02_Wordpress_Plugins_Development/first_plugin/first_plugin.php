<?php
/**
 * @package First Plugin
 * @version 0.1
 */
/*
Plugin Name: First Plugin
Plugin URI: http://nextmap.co.kr
Description: First Plugin by Jido Park (jpark@nextmap.co.kr)
Author: Jido Park
Version: 0.1
Author URI: http://nextmap.co.kr
*/

//filter 사용 예제 - 1 시작
function first_plugin_filter($title){
    return '제목 : '.$title;
}
add_filter( 'the_title', 'first_plugin_filter', 10, 1);
//filter 사용 예제 - 1 끝

//filter 사용 예제 - 2 시작 (워드프레스 로고 링크 수정)
function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );
//filter 사용 예제 - 2 끝

//filter 사용 예제 - 3 시작 (워드프레스 로그인 타이틀 수정 )
function my_login_logo_url_title() {
    return 'Your Site Name and Info';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
//filter 사용 예제 - 3 끝

//Action 사용 예제 - 1 시작 (로그인화면 수정)
function custom_login() {
	?>
	<style type="text/css">
	h1 a {
		background:url('http://nextmap.co.kr/mordernphp.png') no-repeat !important;
		width:340px !important;
		height:150px !important;
	}
</style>

	<?php
}
add_action('login_head', 'custom_login');
//Action 사용 예제 - 1 끝

//Action 사용 예제 - 2 시작 (admin 워드프레스 로고제거)
function annointed_admin_bar_remove() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);
//Action 사용 예제 - 2 끝

//관리자 페이지 추가 예제 시작
add_action( 'admin_menu', 'register_my_custom_menu_page' );
function register_my_custom_menu_page(){

add_menu_page( 'modernphp', 'Modernphp', 'manage_options', 'modernphp', 'modernphp_page', '','2' );
}

function modernphp_page () {
	?>
<h1>MordernPHP!!</h1>
<p>안녕하세요. 워드프레스를 이용해 다양한 플러그인을 만들어보세요 ^^ </p>
	<?php
}

//관리자 페이지 추가 예제 끝
	?>

