<?php
use \Firebase\JWT\JWT;
require_once 'library/jwt.php';

/*
 * Reading the Private Key
 */
$fp1 = fopen("keys/rsa_private.pem", "r");
$privateKey = fread($fp1, 8192);
fclose($fp1);


/*
    * Reading the Public Key
 */
$fp2 = fopen("keys/rsa_public.pem", "r");
$publicKey = fread($fp2, 8192);
fclose($fp2);

/*
     *Payload to sign using the private key
     * iat is Issued at
     * nbf is Not Before
     * exp is Expiration Time
     * iis is Issuer
     * sub is Subject
     * aud Audience
 */
$payload = array(
        "LoggedInAs"=> "John Doe",
        "ViewAs" => "John",
        "AccountNo" =>  "1234 , 5678, 97879",
        "iss" => "https://jwt.co.za:443/signer",
        "aud" => "https://jwt.co.za:443/signer",
        "iat" => time() ,
        "nbf" => time() ,
        "exp" => (time() + 120)
);

/*
    * Signing the payload
 */
$jwt = JWT::encode($payload, $privateKey, 'RS256');
echo "Encoded<br>";
print_r($jwt);


/*
    * Verifying the payload
 */
$decoded = JWT::decode($jwt, $publicKey, array('RS256'));


/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/
echo "<br>";
echo "<br>";
$decoded_array = (array) $decoded;
print_r($decoded) ;
echo "</pre>";

