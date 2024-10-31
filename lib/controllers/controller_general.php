<?php

/* Alertas Sweetalert */
function AlertaGeneral($title, $text, $icon, $url){
	$alerta = "
	<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
	<script>
		Swal.fire({
		  title: '$title',
		  text: '$text',
		  icon: '$icon'
		}).then((result) => {
		  /* Read more about isConfirmed, isDenied below */
		  if (result.isConfirmed) {
			location.replace('$url')
		  }
		})
	</script>
	";
  return $alerta;
}

/* Encriptar textos */

function Enc($action, $string)
{
  $output = false;
  $encrypt_method = "AES-256-CBC";
  $secret_key = 'G05Os3dhky';
  $secret_iv = 'HTgGh78o05Rgsh4O';
  // hash
  $key = hash('sha256', $secret_key);
  // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
  if ($action == 'enc') {
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
  } else if ($action == 'dec') {
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  }
  return $output;
}