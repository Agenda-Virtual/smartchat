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
	
		<form method="post">
			<div class="container-fluid py-4 centralizar">				
				<div class="card container-fluid">
					<div class="m-3 centralizar">
						<h6 class="mb-0"><?php echo $lang['key_code']; ?></h6>
					</div>
					<div class="card-body pt-4 p-3">
						
							
							<div class="row">
								<!-- Nome de usuário -->				
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-control-label" for="url"><?php echo $lang['key_code']; ?></label>
										<input class="form-control" value="" placeholder="<?php echo $lang['key_code_here']; ?>" type="text" name="key" id="key" required autocomplete="off" autofocus="">
									</div>
								</div>
							</div>


							<div class="text-center">
								<button type="submit" name="submit" id="kt_sign_in_submit" class="btn bg-gradient-primary mt-3 w-100">
									<span class="indicator-label"><?php echo $lang['save']; ?></span>
								</button>
							</div>		
						<a href="<?php echo admin_url( 'admin.php?page=agenda-virtual-admin' ); ?>">Voltar</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
if(isset($_POST['submit'])) { // verifique se o formulário foi enviado
    $key = $_POST['key']; // obter o valor do campo de entrada
    $url = 'http://smartchat.agendavirtual.net/validation/?key=' . $key; // adicionar o valor à URL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resposta = curl_exec($ch);
    curl_close($ch);
	
	$inicio = strpos($resposta, "Value@:") + strlen("Value@:");
	$fim = strpos($resposta, "end@", $inicio);
	$dados = substr($resposta, $inicio, $fim - $inicio);
}

if(isset($dados) && !empty($dados)) {
	$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE Features = 'key'" );
	if ( count( $results ) > 0 ) {
		// Atualiza o valor da coluna "Data"
		$wpdb->update( $table_name, array(
			'Data' => $dados,
		), array(
			'Features' => 'key',
		) );
	} else {
		// Adiciona a linha "key" na coluna "Features" e insere o valor "123" na coluna "Data"
		$wpdb->insert( $table_name, array(
			'Features' => 'key',
			'Data' => $dados,
		) );
	}
}

?>
<!-- jQuery CDN -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!-- Bootstrap CDN -->
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>