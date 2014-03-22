<?php
class MyPayPal {
    function PPHttpPost($methodName_, $nvpStr_, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature) {
            $API_UserName = urlencode($PayPalApiUsername);
            $API_Password = urlencode($PayPalApiPassword);
            $API_Signature = urlencode($PayPalApiSignature);
            $API_Endpoint = "https://api-3t.paypal.com/nvp";
            $version = urlencode('109');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3);
			curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);

            $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

            curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

            $httpResponse = curl_exec($ch);

            if(!$httpResponse) {
                exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
            }

            $httpResponseAr = explode("&", $httpResponse);

            $httpParsedResponseAr = array();
            foreach ($httpResponseAr as $i => $value) {
                $tmpAr = explode("=", $value);
                if(sizeof($tmpAr) > 1) {
                    $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
                }
            }

        return $httpParsedResponseAr;
    }

}
?>