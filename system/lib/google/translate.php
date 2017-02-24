<?php

function translateEnToRu($text)
	{
	$tr_api_key = "AIzaSyCSN1Fijjeclz6wFJ9M1dvOpg9joT2uqE0";
	require_once('gCurl/gcurl.class.php');
	//require_once('curl_custom.php');
	$request_headers = array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12','X-HTTP-Method-Override:GET');
	//require_once 'googleApi/src/Google_Client.php';
	//require_once 'googleApi/src/contrib/Google_TranslateService.php';
	if($text == "" || strlen($text) < 3) return "";
	
	/*$client = new Google_Client();
	$client->setApplicationName('Google Translate PHP');
		
	$client->setDeveloperKey($tr_api_key);
	$service = new Google_TranslateService($client);
	$translations = $service->translations->listTranslations($text, 'RU', array('EN'));
	} catch (Exception $e) {
	print "Google API Error ".$e->getMessage()." txt $text \r\n";
	return "";*/
		
	$curl = new gCurl("https://www.googleapis.com/language/translate/v2","POST");
	$curl->Request->addPostVar("key",$tr_api_key);
	$curl->Request->addPostVar("source","en");
	$curl->Request->addPostVar("target","ru");
	$curl->Request->addPostVar("q",$text);
	$curl->Request->registerCustomHeadersArray($request_headers);
	$result = $curl->exec();
	$tr_data = json_decode($result->body);
	return $tr_data->data->translations[0]->translatedText;
		
	return false;
	}
?>
