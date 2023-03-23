<!-- Google Fonts -->
<link rel="preconnect" href="//fonts.googleapis.com">
<link rel="preconnect" href="//fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

<!-- Bootstrap-CDN -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
<!-- Bootstrap-Iconpicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-iconpicker/1.10.0/css/bootstrap-iconpicker.min.css" integrity="sha512-0SX0Pen2FCs00cKFFb4q3GLyh3RNiuuLjKJJD56/Lr1WcsEV8sOtMSUftHsR6yC9xHRV7aS0l8ds7GVg6Xod0A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?php
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'virtual_assistant';

$sql = "CREATE TABLE $table_name (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    Features VARCHAR(255) NOT NULL,
    Data VARCHAR(1024) NOT NULL,
    PRIMARY KEY (ID)
) $charset_collate;";
wp_enqueue_style( 'agenda-virtual-style', plugin_dir_url( __FILE__ ) . 'css/admin-av.css' );
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

if (isset($_POST['submit'])) {
  $url = sanitize_text_field($_POST['url']);
  $visible = sanitize_text_field($_POST['visible']);
  $icon = sanitize_text_field($_POST['icon']);
  $cor = sanitize_text_field($_POST['cor']);
  $position = sanitize_text_field($_POST['position']);
  $personality = sanitize_text_field($_POST['personality']);
  $language = sanitize_text_field($_POST['language']);
  $language_parts = explode('_', $language);
  $language = $language_parts[1];
  $acronym = $language_parts[0];
  $info = sanitize_text_field($_POST['info']);

  $nome_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'Cor'");
  if (count($nome_result) > 0) {
    $wpdb->update($table_name, array('Data' =>$cor), array('Features' => 'Cor'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'Cor', 'Data' => $cor));
  }
  
  $visible_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'visible'");
  if (count($visible_result) > 0) {
    $wpdb->update($table_name, array('Data' =>$visible), array('Features' => 'visible'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'visible', 'Data' => $visible));
  }
  
  $icon_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'icon'");
  if (count($icon_result) > 0) {
    $wpdb->update($table_name, array('Data' =>$icon), array('Features' => 'icon'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'icon', 'Data' => $icon));
  }

  $url_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'URL'");
  if (count($url_result) > 0) {
    $wpdb->update($table_name, array('Data' => $url), array('Features' => 'URL'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'URL', 'Data' => $url));
  }
  
  $info_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'info'");
  if (count($info_result) > 0) {
    $wpdb->update($table_name, array('Data' => $info), array('Features' => 'info'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'info', 'Data' => $info));
  }

  $position_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'position'");
  if (count($position_result) > 0) {
    $wpdb->update($table_name, array('Data' => $position), array('Features' => 'position'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'position', 'Data' => $position));
  }
  $personality_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'personality'");
  if (count($personality_result) > 0) {
    $wpdb->update($table_name, array('Data' => $personality), array('Features' => 'personality'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'personality', 'Data' => $personality));
  }
  $language_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'language'");
  if (count($language_result) > 0) {
    $wpdb->update($table_name, array('Data' => $language), array('Features' => 'language'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'language', 'Data' => $language));
  }
  $acronym_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'acronym'");
  if (count($acronym_result) > 0) {
    $wpdb->update($table_name, array('Data' => $acronym), array('Features' => 'acronym'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'acronym', 'Data' => $acronym));
  }
}

$max_info_characters = "1000";

// código para buscar os valores armazenados na tabela e preencher os campos correspondentes, caso existam
$nome_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'Cor'");
$cor = '';
if (count($nome_result) > 0) {
  $cor = $nome_result[0]->Data;
}

$visible_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'visible'");
$visible = '';
if (count($visible_result) > 0) {
  $visible = $visible_result[0]->Data;
}

$icon_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'icon'");
$icon = '';
if (count($icon_result) > 0) {
  $icon = $icon_result[0]->Data;
}

$url_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'URL'");
$url = '';
if (count($url_result) > 0) {
  $url = $url_result[0]->Data;
}

$info_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'info'");
$info = '';
if (count($info_result) > 0) {
  $info = $info_result[0]->Data;
}

$position_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'position'");
$position = 'inferior_direito'; // definindo "inferior_direito" como padrão
if (count($position_result) > 0) {
  $position = $position_result[0]->Data;
}

$personality_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'personality'");
$personality = 'divertida'; // definindo "divertida" como padrão
if (count($personality_result) > 0) {
  $personality = $personality_result[0]->Data;
}

$languages = [
  'en_english' => 'English',
  'pt_portuguese' => 'Português',
  'es_spanish' => 'Español',
  'fr_french' => 'Français',
  'de_german' => 'Deutsch',
  'it_italian' => 'Italiano'
  /*'ja_japanese' => '日本語',
  'zh_chinese' => '中文',
  'ar_arabic' => 'العربية',
  'bn_bengali' => 'বাংলা',
  'gu_gujarati' => 'ગુજરાતી',
  'hi_hindi' => 'हिन्दी',
  'id_indonesian' => 'Bahasa Indonesia',
  'jv_javanese' => 'Basa Jawa',
  'ko_korean' => '한국어',
  'mr_marathi' => 'मराठी',
  'pa_punjabi' => 'ਪੰਜਾਬੀ',
  'ru_russian' => 'Русский',
  'sw_swahili' => 'Kiswahili',
  'ta_tamil' => 'தமிழ்',
  'te_telugu' => 'తెలుగు',
  'tr_turkish' => 'Türkçe',
  'uk_ukrainian' => 'Українська',
  'ur_urdu' => 'اردو',
  'vi_vietnamese' => 'Tiếng Việt',
  'yo_yoruba' => 'Yorùbá',
  'zu_zulu' => 'isiZulu'*/
];
asort($languages);

// Store user's language preference
$language_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'language'");
$acronym_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'acronym'");

// Set default language
$default_language = 'en';

// Detect user's language preference
if (isset($_SESSION['language'])) {
    $acronym = $_SESSION['language'];
} else {
    $acronym = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}

if (count($language_result) > 0) {
  $language_sql = $language_result[0]->Data;
  $acronym_sql = $acronym_result[0]->Data;
  $language = $language_sql;
  $acronym = $acronym_sql;
}

// Load language file
include_once ( plugin_dir_path( __FILE__ ) . '../languages/' . $acronym . '.php' );
?>
<div class="g-sidenav-show bg-gray-100 margin-body">
	<div class="container-fluid py-4">				
		<form method="post">
		
		<div class="container-fluid width-admin">
			<div class="page-header min-height-150 border-radius-xl mt-4" style="background-image: url('<?php echo plugin_dir_url( __FILE__ ) . 'img/curved0.jpg'; ?>'); background-position-y: 50%;">
				<span class="mask bg-gradient-primary opacity-6"></span>
			</div>
			<div class="card card-body blur shadow-blur mx-4 mt-n6">
				<div class="row gx-4">
					<div class="col-auto">
						<div href="https://agendavirtual.net/app" class="m-5 text-center ">
							<img src="<?php echo plugin_dir_url( __FILE__ ) . 'img/Logo_Agenda_Virtual.png'; ?>" alt="Logo Agenda Virtual" width="200px" height="auto">
						</div>
					</div>
					<div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
						<div class="nav-wrapper position-relative end-0 text-center">
							<label class="form-control-label" for="language"><?php echo strtoupper($lang['language']); ?></label></br>
							<!-- idioma -->				
							<div class="col-md-12">
								<div class="form-group">
									<select id="language" name="language">
									<?php foreach ($languages as $code => $language): ?>
									  <option value="<?php echo $code; ?>"<?php if ($code === $acronym_sql . "_" . $language_sql) { echo ' selected'; } ?>><?php echo $language; ?></option>
									<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
			<div class="container-fluid py-4 centralizar">				
				<div class="card container-fluid">
					<div class="card-header pb-0 px-3">
						<h6 class="mb-0"><?php echo $lang['subtitle'] . "<br/>" . $lang['subtitle_2']; ?></h6>
					</div>
					<div class="card-body pt-4 p-3">
						
							
							<div class="row">
								<!-- Nome de usuário -->				
								<div class="col-md-4">
									<div class="form-group">
										<label class="form-control-label" for="url"><?php echo $lang['assistant_name']; ?></label>
										<input class="form-control" value="<?php echo $url; ?>" placeholder="<?php echo $lang['assistant_name_placeholder']; ?>" type="text" name="url" required="" autocomplete="off" autofocus="">
									</div>
								</div>
								
								<!-- Personalidade -->	
								<div class="col-md-8">
									<div class="form-group">
										<label class="form-control-label" for="personality"><?php echo $lang['speaking_style']; ?></label></br>
										<select class="form-control" name="personality" required>
											<option value="formal, respectful, and professional" <?php echo ($personality === 'formal, respectful, and professional') ? 'selected' : ''; ?>><?php echo $lang['speaking_style_formal']; ?></option>
											<option value="friendly, establishing an emotional connection" <?php echo ($personality === 'friendly, establishing an emotional connection') ? 'selected' : ''; ?>><?php echo $lang['speaking_style_friendly']; ?></option>
											<option value="fun, playful, and relaxed" <?php echo ($personality === 'fun, playful, and relaxed') ? 'selected' : ''; ?>><?php echo $lang['speaking_style_fun']; ?></option>
											<option value="polite, courteous, and refined" <?php echo ($personality === 'polite, courteous, and refined') ? 'selected' : ''; ?>><?php echo $lang['speaking_style_polite']; ?></option>
											<option value="technical, precise, and objective, providing detailed information" <?php echo ($personality === 'technical, precise, and objective, providing detailed information') ? 'selected' : ''; ?>><?php echo $lang['speaking_style_technical']; ?></option>
											<option value="empathetic, understanding, showing solidarity and concern" <?php echo ($personality === 'empathetic, understanding, showing solidarity and concern') ? 'selected' : ''; ?>><?php echo $lang['speaking_style_empathetic']; ?></option>
											<option value="youthful, relaxed, and informal" <?php echo ($personality === 'youthful, relaxed, and informal') ? 'selected' : ''; ?>><?php echo $lang['speaking_style_youthful']; ?></option>
											<option value="direct, offering brief and precise answers" <?php echo ($personality === 'direct, offering brief and precise answers') ? 'selected' : ''; ?>><?php echo $lang['speaking_style_direct']; ?></option>
										  </select>
									</div>
								</div>
							</div>
							<div class="row">
								<!-- Informações -->				
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-control-label" for="info"><?php echo $lang['main_informations']; ?></label><label class="form-control-label text-muted"><?php echo $lang['maximum'] . " " . $max_info_characters . " " . $lang['characters']; ?></label></br>
										<textarea class="form-control form-control-lg" name="info" rows="5" maxlength="<?php echo $max_info_characters; ?>" placeholder="<?php echo $lang['maximum_characters_placeholder']; ?>"><?php echo $info; ?></textarea>
									</div>
								</div>
							</div>

							<input type="hidden" name="visible" value="1">
							<div class="row"> 
								<!-- Cor do botão -->
								<div class="col-md-3">
									<div class="form-group">
										<label class="form-control-label" for="cor"><?php echo $lang['button_color']; ?></label>
										<input class="form-control form-control-solid" value="<?php echo $cor; ?>" type="color" name="cor">
									</div>
								</div>
								<!-- Icon Picker -->
								<div class="col-md-3">
									<div class="form-group">
										<label class="form-control-label" for="cor"><?php echo $lang['choose_icon']; ?></label>
										<button class="btn btn-secondary" data-placement="left" data-icon="<?php echo $icon; ?>" role="iconpicker"></button>
									</div>
								</div>
								
								<!-- Posição -->
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-control-label" for="position"><?php echo $lang['position']; ?></label></br>
										<select class="form-control" name="position" required>
											<option value="inferior_direito" <?php echo ($position === 'inferior_direito') ? 'selected' : ''; ?>><?php echo $lang['position_bottom_right']; ?></option>
											<option value="inferior_esquerdo" <?php echo ($position === 'inferior_esquerdo') ? 'selected' : ''; ?>><?php echo $lang['position_bottom_left']; ?></option>
											<option value="superior_direito" <?php echo ($position === 'superior_direito') ? 'selected' : ''; ?>><?php echo $lang['position_top_right']; ?></option>
											<option value="superior_esquerdo" <?php echo ($position === 'superior_esquerdo') ? 'selected' : ''; ?>><?php echo $lang['position_top_left']; ?></option>
										  </select>
									</div>
								</div>
							</div>
							<div class="text-center">
								<button type="submit" name="submit" id="kt_sign_in_submit" class="btn bg-gradient-primary mt-3 w-100">
									<span class="indicator-label"><?php echo $lang['save']; ?></span>
								</button>
							</div>		
						<a href="<?php echo admin_url( 'admin.php?page=agenda-virtual-pro-check' ); ?>">Pro Version</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- jQuery CDN -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!-- Bootstrap CDN -->
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>