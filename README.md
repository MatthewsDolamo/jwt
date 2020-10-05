## jwt
A simple library to encode and decode JSON Web Tokens (JWT) in PHP using RSA key pair

#### Generate an RSA key using OpenSSL command-line tools.

### You can generate a 2048-bit RSA key pair with the following commands:
      openssl genpkey -algorithm RSA -out rsa_private.pem -pkeyopt rsa_keygen_bits:2048
      openssl rsa -in rsa_private.pem -pubout -out rsa_public.pem

### These commands create the following public/private key pair:
       rsa_private.pem: The private key that must be securely stored and is used to sign the authentication JWT.
       rsa_public.pem: The public key that can be shared and is used to verify the signature of the authentication JWT.

### Reading the Private Key

	$fp1 = fopen("keys/rsa_private.pem", "r");
	$privateKey = fread($fp1, 8192);
	fclose($fp1);

###  Reading the Public Key

	$fp2 = fopen("keys/rsa_public.pem", "r");
	$publicKey = fread($fp2, 8192);
	fclose($fp2);

###  Payload to sign using the private key
       /*
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

###  Signing the payload and print it

	$jwt = JWT::encode($payload, $privateKey, 'RS256');
	echo "Encoded<br>";
	print_r($jwt);

### Verifying the payload

	*$decoded = JWT::decode($jwt, $publicKey, array('RS256'));


		/*
 		NOTE: This will now be an object instead of an associative array. To get
		 an associative array, you will need to cast it as such:
		*/
		* echo "<br>";
		* echo "<br>";
		* $decoded_array = (array) $decoded;
		* print_r($decoded) ;
		* echo "</pre>";

