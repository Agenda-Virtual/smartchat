
<?php
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'smartchat';

$acronym_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'acronym'");
$default_language = 'pt';
$acronym_sql = $acronym_result[0]->Data;
$acronym = $acronym_sql;

// Load language file
include_once ( plugin_dir_path( __FILE__ ) . 'languages/' . $acronym . '.php' );

$info_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'info'");
$info = '';
if (!empty($info_result) && !empty($info_result[0]->Data)) {
	$info = "aditional informations: " . $info_result[0]->Data;
} else {
	$info = "";
}

$URL_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'URL'");
$URL = '';
if (count($URL_result) > 0) {
  $URL = $URL_result[0]->Data;
}

$personality_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'personality'");
$personality = 'divertida';
if (count($personality_result) > 0) {
  $personality = $personality_result[0]->Data;
}

$language_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'language'");
$language = 'portuguese'; // definindo "portuguese" como padrão
if (count($language_result) > 0) {
  $language = $language_result[0]->Data;
}

$hide_logo_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'hide_logo'");
$hide_logo = '';
if (count($hide_logo_result) > 0) {
  $hide_logo = $hide_logo_result[0]->Data;
}

$time_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'time'");
$time = '';
if (count($time_result) > 0) {
  $time = $time_result[0]->Data;
}

$key = '';
$key_ver = $wpdb->get_var( "SELECT Data FROM $table_name WHERE Features = 'key'" );
if ( !empty( $key_ver ) ) {
    $key = 1;
}

if ( empty( $key ) ) {
	$hide_logo = 0;
	$time = 0;
}
?>

<script>
var url = "https://wsgi.agendavirtual.net/bot";
var historico = "";

jQuery(document).ready(function($) {

    $("#submit").click(function() {
        var message = $("#message").val();
        message = message.replace(/(https?:\/\/[^\s]+)|(www.[^\s]+)/g, function(match) {
            if (match.startsWith("http")) {
                return '<a href="' + match + '" target="_blank">' + match + '</a>';
            } else {
                return '<a href="http://' + match + '" target="_blank">' + match + '</a>';
            }
        });

        var nome = $("#nome").val();
        var personalidade = $("#personalidade").val();
        var language = $("#language").val();
        var frase = $("#frase").val();

		$("#chat-log").append("<p class='message my-message' style='display:none'>" + message + "</p>");
		$(".message:last").fadeIn(150)

        if (historico === "") {
			message = personalidade + '. ' + language + ', ' + frase + ', ' + nome + '. Answer only the question ahead:' + message + ".";
		} else {
			message = "Previous message: " + historico + '. ' + personalidade + '. ' + language + ', ' + frase + ', ' + nome + '. Answer only the question ahead:' + message + ".";
			historico = "";
		}
			if(<?php echo $time; ?> == 1){
				$("#chat-log").append("<p class='typing'><span><?php echo esc_attr($lang['writing']); ?></span></p>");
				$('#virtual-assistant-box').scrollTop($('#virtual-assistant-box')[0].scrollHeight);
				var typingMessage = $(".typing span");
				setTimeout(function() {
				  typingMessage.parent().addClass("show");
				}, 2000);
				var interval = setInterval(function() {
				  typingMessage.fadeIn(1000, function() {
					typingMessage.fadeOut(1000);
				  });
				}, 1000);
			}
			
			// Envia mensagem para o servidor
			$.post(url, {Body: message}, function(data) {		  
				data = data.replace(/(^\s*<\?xml[^>]*>\s*<Response>\s*<Message>\s*)/g, ''); // removes XML header and opening tags
				data = data.replace(/<\/Message>\s*<\/Response>/g, ''); // removes closing tags
				data = data.replace(/(https?:\/\/[^\s]+)|(www.[^\s]+)/g, function(match) {
					if (match.startsWith("http")) {
						return '<a href="' + match + '" target="_blank">' + match + '</a>';
					} else {
						return '<a href="http://' + match + '" target="_blank">' + match + '</a>';
					}
				});
			var delay = data.length;
			if(<?php echo $time; ?> == 1){
				var delay = data.length * 30;
			}
			setTimeout(function() {
				$(".typing").remove();
				$("#chat-log").append("<li class='clearfix'><p class='message other-message float-right' style='display:none'><b><?php echo esc_attr($URL); ?>:</b> " + data + "</p></li>");
				$(".message:last").fadeIn(150)
				historico = data;
				$('#virtual-assistant-box').scrollTop($('#virtual-assistant-box')[0].scrollHeight);
			}, delay);
		});
		$("#message").val("");
	});
	$("#message").on('keypress', function (e) {
	  if (e.key === 'Enter' || e.keyCode === 13) {
		e.preventDefault();
		$("#submit").click();
		$('#virtual-assistant-box').scrollTop($('#virtual-assistant-box')[0].scrollHeight);
	  }
	});
});
</script>

<input type="hidden" id="nome" value="<?php echo "You are the assistant " . esc_attr($URL); ?>">
<input type="hidden" id="personalidade" value="<?php echo "use a tone of voice " . esc_attr($personality); ?>">
<input type="hidden" id="language" value="<?php echo "You speak in " . esc_attr($language) . " language" ?>">
<input type="hidden" id="frase" value="<?php echo esc_attr($info); ?>">
<div class="chat">
	<div class="chat-history">
		<ul>
			<div id="chat-log"></div>
		</ul>
	</div>
	<div class="chat-message clearfix">
		<div class="input-group box-message-chat">
			<input type="text" id="message" class="form-control" placeholder="<?php echo esc_attr($lang['write_here']); ?>">
			<div class="input-group-prepend">
				<button class="input-group-text" id="submit"><i class="button-message fas fa-location-arrow"></i></button>
			</div>
		</div>
		<?php 
		if($hide_logo == 0){ ?>
			<div class="logo_box_chat">
				<a href="https://smartchat.agendavirtual.net" target="_blank">
					<img src="<?php echo plugin_dir_url( __FILE__ ) . 'img/logo_smartchat.png' ?>" alt="Logo Smartchat" width="70px">
				</a>
			</div>
		<?php }; ?>
	</div>
</div>