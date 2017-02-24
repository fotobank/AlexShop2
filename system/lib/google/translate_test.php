<?php
set_time_limit(0);
require_once('../gCurl/gcurl.class.php');
require_once('../curl_custom.php');
$request_headers = array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12','X-HTTP-Method-Override:GET');

$data = "Smart FiresThe EcoSmartв„ў Fire is an Australian innovation - an environmentally friendly open fireplace. The EcoSmartв„ў Fire is flue less and does not require any installation or utility connection for fuel supply, which makes it ideal for just about any architectural environment. Fuelled by a renewable modern energy (Denatured Ethanol), it burns clean and is virtually maintenance free.Featuring remarkable design flexibility, the simplicity of the EcoSmartв„ў burner and the modular nature of its design grants consumers with significant versatility and choice.вЂў New concept of open fireplaceвЂў No flue, no hard connectionвЂў Efficient and effective heating solutionвЂў Independently testedвЂў Ideal for apartments, houses, bars, restaurants and officesвЂў Unprecedented design flexibilityвЂў Environmentally friendlyвЂў Fuelled by a renewable green energyвЂў You can regulate the flame and turn it on/off at any timeDesign FocusWhile the traditional open fireplace is appealing and highly sought after, it is incompatible with modern housing and contemporary living standards and lacks the necessary environmental care, efficiency and design flexibility that consumers are looking for. The EcoSmartв„ў Fire presents a solution to these problems.The EcoSmartв„ў Fire redefines the fireplace, and reinstates it as the central focus of the modern living space. Installed in a loft, studio, apartment, terrace house or freestanding home, the EcoSmartв„ў Fire provides the вЂ?primalвЂ™ warmth and comfort of fire while enhancing the contemporary expectation of todayвЂ™s living environments.Quality of ManufactureEvery single part of the EcoSmartв„ў Burner is made of stainless steel вЂ“ it looks great, is very strong and will last you a lifetime. The predominant sheet metal design is computer cut and folded for accurate and easy assembly. This manufacturing technology guarantees each product is the same quality. All stainless steel parts of the EcoSmartв„ў Fire are manufactured in Australia by an ISO 9001 accredited manufacturer (AS/NZ/S ISO 9001:2000).All stone, joinery, glass and other material that make up each model are also manufactured by very reputable and successful companies who focus on quality and consistency.";
/////////////////////////////////////////
$curl = new gCurl("https://www.googleapis.com/language/translate/v2","POST");
$curl->Request->addPostVar("key","AIzaSyCSN1Fijjeclz6wFJ9M1dvOpg9joT2uqE0");
$curl->Request->addPostVar("source","en");
$curl->Request->addPostVar("target","ru");
$curl->Request->addPostVar("q",$data);
$curl->Request->registerCustomHeadersArray($request_headers);
curl_setopt($curl->ch,CURLOPT_REFERER,"http://www.architonic.com");
$result = $curl->exec();

$tr_data = json_decode($result->body);
print_r($tr_data->data->translations[0]->translatedText);exit;
//$tr_text = $tr_data->data->transla['data']['translations'][0]['translatedText'];
print $tr_text;
?>