<?php
function pdoGetWriteDBConnection(){
	$servername = "localhost";
	$username = "root";
	//$password = "root";
	$password = "";
	$dbname = "tlrdb";
	try {
	  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	  // set the PDO error mode to exception
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    //echo "Connected successfully";
	} catch(PDOException $e) {
	  echo "Connection failed: " . $e->getMessage();
	}
	return $conn;
}

function pdoQuery($query, $paramsArray = array()) {
		$startTime = microtime(true);
		if (!empty($query) && is_array($paramsArray) && substr_count($query, "?") == count($paramsArray)) { //If query is not empty,parameters are in valid array format and parameters count matches with query parameters
		   $queryKeywords = explode(' ', trim($query)); //explode query
		   if (isset($queryKeywords[0])) {
				$operation = strtolower($queryKeywords[0]); //select,update,insert

				switch ($operation) {
				  	case 'insert':
						 $con = pdoGetWriteDBConnection();
						if (stripos($query, 'limit') !== false) {
						   $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Use MySql native prepare statements
						}
						
						if ($query) {
						   $stmt = $con->prepare($query);
						   if (empty($paramsArray)) { //if query like "select * from table"(i.e without parameters)
							$result = $stmt->execute();
						   } else {
							  $result = $stmt->execute($paramsArray);
						   }
						   if ($result) {
							return $con->lastInsertId();
						   } else {
							return false;
						   }
						} else {
						   return false;
						}
						break;
				   case 'update':
						$con = pdoGetWriteDBConnection();
						if (stripos($query, 'limit') !== false) {
						   $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Use MySql native prepare statements
						}
						if ($query) {
						   //$query = "UPDATE `goqii_quiz_question_raw` SET `category` = ?,`question` = ?,`one` = ?,`two` = ?,`three` = ?,`four` = ?,`answer` = ?,`information` = ? WHERE `questionId` = ?";
						   $stmt = $con->prepare($query);
						   if (empty($paramsArray)) { //if query like "select * from table"(i.e without parameters)
							$result = $stmt->execute();
						   } else {
							$result = $stmt->execute($paramsArray);
						   }
						   if ($result) {
							return true;
						   } else {
							return false;
						   }
						} else {
						   return false;
						}
						break;
					case 'select':
						$con = pdoGetWriteDBConnection();
						if (stripos($query, 'limit') !== false) {
						    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Use MySql native prepare statements
						}
						if ($query) {
						    $stmt = $con->prepare($query);
						    if (empty($paramsArray)) { //if query like "select * from table"(i.e without parameters)
							$result = $stmt->execute();
						    } else {
							$result = $stmt->execute($paramsArray);
						    }
						    if ($result) {
							$fetchAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$endTime = microtime(true);
							$timeDifference = $endTime - $startTime;
							return $fetchAll;
						    } else {
							return false;
						    }
						} else {
						    return false;
						}
						break;
				}	
			}	
		}
	}

function encrypt_decrypt($action, $string) {
	try {
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $secret_key = 'SecretKeyFor#tlr###';
	    $secret_iv = 'SecretKeyFor#tlr987@@@';
	    $key = hash('sha256', $secret_key);
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);
	    if ($action == 'encrypt') {
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
	    } else if ($action == 'decrypt') {
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }
	    return $output;
	} catch (Exception $e) {
	    
	}
}			 
?>