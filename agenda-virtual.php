<?php
/*
Plugin Name: Agenda Virtual2
Plugin URI: https://agendavirtual.net/plugin
Description: O plugin Agenda Virtual para WordPress permite que os clientes agendem compromissos por meio de um botão flutuante no site do seu negócio. A ferramenta oferece uma experiência de agendamento online fácil e conveniente para clientes e empresas.
Version: 2.0.3
Author: Agenda Virtual
Author URI: https://agendavirtual.net
License: GPL2
*/

// Adicione funções e ações do seu plugin abaixo deste cabeçalho.
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
    wp_enqueue_script( 'agenda-virtual-script', plugin_dir_url( __FILE__ ) . 'js/agenda-virtual-script.js', array( 'bootstrap-script' ), '2', true );
    wp_enqueue_style( 'agenda-virtual-style', plugin_dir_url( __FILE__ ) . 'css/agenda-virtual.css', array(), '1.0.1' );
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
		'Agenda Virtual',
		'Agenda Virtual',
		'manage_options',
		'agenda-virtual-admin',
		'agenda_virtual_admin_page'
	);
}
add_action( 'admin_menu', 'agenda_virtual_admin_menu' );

function agenda_virtual_admin_page() {
	include( plugin_dir_path( __FILE__ ) . 'admin.php' );
}

add_action('wp_ajax_update_visible', 'update_visible');
add_action('wp_ajax_nopriv_update_visible', 'update_visible');

function agenda_virtual_html() {
	
    echo '<div class="botao-agendavirtual"></div>';
    echo '<div id="virtual-assistant-box" class="virtual-assistant-box">';
    include(plugin_dir_path(__FILE__) . 'chat.php');
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
