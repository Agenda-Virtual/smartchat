<?php
/*
Plugin Name: Smartchat
Plugin URI: https://smartchat.agendavirtual.net/plugin
Description: Transforme a interação com seus clientes com nosso incrível plugin de assistente virtual, que utiliza a inteligência artificial do ChatGPT para fornecer respostas precisas e eficientes em tempo real. Insira facilmente informações importantes para que a assistente virtual possa personalizar as respostas de acordo com as necessidades dos usuários e aprimorar a experiência do cliente.
Version: 2.0.6
Author: Smartchat
Author URI: https://smartchat.agendavirtual.net
License: GPL2
*/

require_once 'plugin-update-checker/plugin-update-checker.php';

/*
 * Plugin Update Checker Setting
 *
 * @see https://github.com/YahnisElsts/plugin-update-checker for more details.
 */
function smartchat_update_checker_setting() {
	if ( ! is_admin() || ! class_exists( 'Puc_v4_Factory' ) ) {
		return;
	}

	$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'https://github.com/Agenda-Virtual/smartchat/',
		__FILE__,
		'smartchat'
	);

	// (Opcional) Set the branch that contains the stable release.
	$myUpdateChecker->setBranch('20-03-23_2');
}

add_action( 'admin_init', 'smartchat_update_checker_setting' );

// Carrega o script JavaScript
function plugin_agenda_virtual() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'virtual_assistant';
    $url = $wpdb->get_var("SELECT Data FROM $table_name WHERE Features = 'URL'");
    $visible = $wpdb->get_var("SELECT Data FROM $table_name WHERE Features = 'visible'");
    $cor = $wpdb->get_var("SELECT Data FROM $table_name WHERE Features = 'Cor'");
    $position_button = $wpdb->get_var("SELECT Data FROM $table_name WHERE Features = 'position'");
    $icon = $wpdb->get_var("SELECT Data FROM $table_name WHERE Features = 'icon'");
    
    wp_enqueue_script( 'jquery-script', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js' );
    wp_enqueue_script( 'bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js', array( 'jquery-script' ) );
    wp_enqueue_script( 'agenda-virtual-script', plugin_dir_url( __FILE__ ) . 'public/js/agenda-virtual-script.js', array( 'bootstrap-script' ), '2', true );
    wp_enqueue_style( 'agenda-virtual-style', plugin_dir_url( __FILE__ ) . 'public/css/agenda-virtual.css', array(), '1.0.1' );
	wp_enqueue_style( 'agenda-virtual-script', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css');

    $data = array('url' => $url);
    wp_localize_script('agenda-virtual-script', 'agendaVirtualData', $data);
    $dataview = array('visible' => $visible);
    wp_localize_script('agenda-virtual-script', 'agendaVirtualVisible', $dataview);
    $dataposition = array('position' => $position_button);
    wp_localize_script('agenda-virtual-script', 'agendaVirtualDataPosition', $dataposition);
    $dataicon = array('icon' => $icon);
    wp_localize_script('agenda-virtual-script', 'agendaVirtualDataIcon', $dataicon);
    $datacor = array('cor' => $cor);
    wp_localize_script('agenda-virtual-script', 'agendaVirtualDataCor', $datacor);
}
add_action( 'wp_enqueue_scripts', 'plugin_agenda_virtual' );

//Area adminsitrativa do Plugin
function agenda_virtual_admin_menu() {
	wp_enqueue_script( 'agenda-virtual-script', plugin_dir_url( __FILE__ ) . 'js/bootstrap-iconpicker.bundle.min.js', array(), '2', true );
	wp_enqueue_style( 'agenda-virtual-script', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css');

	add_menu_page(
		'Smartchat',
		'Smartchat',
		'manage_options',
		'agenda-virtual-admin',
		'agenda_virtual_admin_page'
	);

	// Adicionando nova página
	add_submenu_page(
		'agenda-virtual-admin',
		'Pro Check',
		'Pro Check',
		'manage_options', // AQUI DEFINE AS PERMISSÕES
		'agenda-virtual-pro-check',
		'agenda_virtual_pro_check_page'
	);
}
add_action( 'admin_menu', 'agenda_virtual_admin_menu' );

function agenda_virtual_admin_page() {
	include( plugin_dir_path( __FILE__ ) . 'admin/admin.php' );
}

// Função para a página "agenda-virtual-pro-check"
function agenda_virtual_pro_check_page() {
	include_once( plugin_dir_path( __FILE__ ) . 'admin/pro_check.php' );
}


add_action('wp_ajax_update_visible', 'update_visible');
add_action('wp_ajax_nopriv_update_visible', 'update_visible');

function agenda_virtual_html() {
	
    echo '<div class="botao-agendavirtual"></div>';
    echo '<div id="virtual-assistant-box" class="virtual-assistant-box">';
    include(plugin_dir_path(__FILE__) . 'public/chat.php');
    echo '</div>';
    
    // Adicionando o script abaixo
    echo '<script type="text/javascript">';
    echo '$("#message").on(\'keyup\', function (e) {
            if (e.key === \'Enter\' || e.keyCode === 13) {
                $("#submit").click();
                $(\'#virtual-assistant-box\').scrollTop($(\'#virtual-assistant-box\')[0].scrollHeight);
            }
        });
        $(document).ready(function() {
            $("#virtual-assistant-box").hover(function() {
                $(this).css("overflow-y", "scroll");
            }, function() {
                $(this).css("overflow-y", "hidden");
            });
        });';
    echo '</script>';
}

add_action( 'wp_footer', 'agenda_virtual_html' );

?>
