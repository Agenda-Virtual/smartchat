
<?php
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'virtual_assistant';

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

$key = '';
$key_ver = $wpdb->get_var( "SELECT Data FROM $table_name WHERE Features = 'key'" );
if ( !empty( $key_ver ) ) {
    $key = 1;
}
?>

<script>
var url = "https://wsgi.agendavirtual.net/bot";
//var url = "https://01cb-52-207-162-32.ngrok.io/bot";
var historico = "";
var timeWait = "0";

$(document).ready(function() {

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
				$("#chat-log").append("<li class='clearfix'><p class='message other-message float-right' style='display:none'><b><?php echo $URL; ?>:</b> " + data + "</p></li>");
				$(".message:last").fadeIn(150)
				historico = data;
				$('#virtual-assistant-box').scrollTop($('#virtual-assistant-box')[0].scrollHeight);
			});
        $("#message").val("");
    });
});
</script>


<input type="hidden" id="nome" value="<?php echo "You are the assistant " . $URL; ?>">
<input type="hidden" id="personalidade" value="<?php echo "use a tone of voice " . $personality; ?>">
<input type="hidden" id="language" value="<?php echo "You speak in " . $language . " language" ?>">
<input type="hidden" id="frase" value="<?php echo $info; ?>">
<div class="chat">
	<div class="chat-history">
		<ul class="m-b-0">
			<div id="chat-log"></div>
		</ul>
	</div>
	<div class="chat-message clearfix">
		<div class="input-group mb-0 box-message-chat">
			<input type="text" id="message" class="form-control" placeholder="Digite seu texto aqui...">
			<div class="input-group-prepend">
				<button class="input-group-text" id="submit"><i class="button-message fas fa-location-arrow"></i></button>
			</div>
		</div>
		<?php 
		if ( empty( $key ) ) {
			$hide_logo = 0;
		}
		if($hide_logo == 0){ ?>
			<div class="logo_box_chat">
				<img src="<?php echo plugin_dir_url( __FILE__ ) . 'img/logo_smartchat.png' ?>" alt="Logo Smartchat" width="70px">
			</div>
		<?php }; ?>
	</div>
</div>

