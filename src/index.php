<?php

if( !isset($_POST['image_url']) or !isset($_POST['caption']) or !isset($_POST['access_token']) ){
	echo 'hi';
	return;
}

$final = [];

$url = 'https://graph.facebook.com/v13.0/17841452776574352/media';

$data = [];
$data['image_url'] = $_POST['image_url'];
$data['caption'] = $_POST['caption'];
$data['access_token'] = $_POST['access_token'];

$data = json_encode( $data );


$curl = curl_init();
curl_setopt_array($curl, array(
	
  CURLOPT_URL => $url,
  CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
  CURLOPT_POSTFIELDS => $data,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 24,
  CURLOPT_FOLLOWLOCATION => true,
  
));

$response = curl_exec($curl);

if (curl_errno($curl)) {

	$final['state'] = false;
	$final['step'] = 1;
	$final['message'] = curl_error($curl);

	echo json_encode($final);
	return;
}

curl_close($curl);

$result = json_decode($response, true, JSON_PRETTY_PRINT);
		
$container_id = $result['id'];



$url2 = 'https://graph.facebook.com/v13.0/17841452776574352/media_publish';

$data2 = array(
	'access_token' => $_POST['access_token'],
	'creation_id' => $container_id,
);
$data2 = json_encode( $data2 );

$curl2 = curl_init();
curl_setopt_array($curl2, array(
	
  CURLOPT_URL => $url2,
  CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
  CURLOPT_POSTFIELDS => $data2,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 24,
  CURLOPT_FOLLOWLOCATION => true,
  
));

$response2 = curl_exec($curl2);

if (curl_errno($curl2)) {

	$final['state'] = false;
	$final['step'] = 2;
	$final['message'] = curl_error($curl2);

	echo json_encode($final);
	return;
}

curl_close($curl2);
	
$result2 = json_decode($response2, true, JSON_PRETTY_PRINT);
		

if( $result['id'] and $result2['id']){

	$final['state'] = true;

	echo json_encode($final);
	return;
}




?>
