<?php
/***************************/
/* Miscellaneous functions */
/***************************/


/* Detects the current URL address */
function currentURL() {

  $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') 
                === FALSE ? 'http' : 'https';
                
  return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
  
}


/* Applies addslashes() function to each element of an array */
function arrayAddslashes($array) {

  foreach($array as $key => $value) {
    $array[$key] = addslashes($value);
  }
  
  return $array;

}


/* Returns the file's extension */
function getExtension($filename) {

  $path_info = pathinfo($filename);
  return $path_info['extension'];
          
}



/* Uploads file to a selected directory */
function uploadFile($file, $filename, $path) {

  $uploadfile = $path . $filename;

  if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
    return true;
  } else {
    return false;
  }
}



/* Inserts STRING to the given POSITION of the SRC_STRING */
function insertToString($src_string, $string, $pos) {
  return substr($src_string, 0, $pos) . $string . substr($src_string, $pos, strlen($src_string) - $pos); 
}
  
  
  
/* Deletes COUNT characters from the given STRING, starting from START */
function deleteFromString($string, $start, $count) {
  return substr($string, 0, $start) . substr($string, $start+$count, strlen($string) - $start-$count); 
}


/* Converts DAY, MONTH, YEAR, HOUR, MINUTE to UNIX time */
function convertDate($day, $month, $year, $hour, $min) {

  return strtotime($year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':00');

}


/* Sends an e-mail */
function email($to, $from_address, $from_name, $subject, $text, $attachment_file = false, $attachment_name = false) {

  $from = $from_name . " <" . $from_address . ">";
  $separator = md5(time());
  
  /* End of line constant */
  $eol = PHP_EOL;
  
  /* Main header */
  $headers  = "From: ".$from.$eol;
  $headers .= "MIME-Version: 1.0".$eol; 
  $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";
  
  /* Body of the e-mail */
  $body = "--".$separator.$eol;
  $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
  
  /* Message */
  $body .= "--".$separator.$eol;
  $body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
  $body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
  $body .= $text.$eol;


  /* If there is also an attachment to send */
  if ($attachment_file) {
    
    /* Encode and split the attachment file */
    $attachment = chunk_split(base64_encode($attachment_file));
    
    /* Add it to the body */
    $body .= "--".$separator.$eol;
    $body .= "Content-Type: application/octet-stream; name=\"".$attachment_name."\"".$eol; 
    $body .= "Content-Transfer-Encoding: base64".$eol;
    $body .= "Content-Disposition: attachment".$eol.$eol;
    $body .= $attachment.$eol;
    $body .= "--".$separator."--";    
  
  }           

  /* Send that e-mail! */
  mail($to, $subject, $body, $headers);

}

/* Returns a lowercased string without diacritics */
function removeDiacritics($string) {
  $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', 'ľ'=>'l', 'ť'=>'t', 'Ľ'=>'L', 'Ť'=>'T', 'ř'=>'r', 'Ř'=>'R', 'ě'=>'e', 'Ě'=>'E',
  );
    
  return strtolower(strtr($string, $table));
}


/* Generates a random password */
function randomPassword($len = 6) {

  return substr(md5(rand().rand()), 0, $len);

}




$GLOBALS['country_list'] = array(
"AF" => "Afghanistan",
"AL" => "Albania",
"DZ" => "Algeria",
"AS" => "American Samoa",
"AD" => "Andorra",
"AO" => "Angola",
"AI" => "Anguilla",
"AQ" => "Antarctica",
"AG" => "Antigua and Barbuda",
"AR" => "Argentina",
"AM" => "Armenia",
"AW" => "Aruba",
"AU" => "Australia",
"AT" => "Austria",
"AZ" => "Azerbaijan",
"BS" => "Bahamas",
"BH" => "Bahrain",
"BD" => "Bangladesh",
"BB" => "Barbados",
"BY" => "Belarus",
"BE" => "Belgium",
"BZ" => "Belize",
"BJ" => "Benin",
"BM" => "Bermuda",
"BT" => "Bhutan",
"BO" => "Bolivia",
"BA" => "Bosnia and Herzegovina",
"BW" => "Botswana",
"BV" => "Bouvet Island",
"BR" => "Brazil",
"IO" => "British Indian Ocean Territory",
"BN" => "Brunei Darussalam",
"BG" => "Bulgaria",
"BF" => "Burkina Faso",
"BI" => "Burundi",
"KH" => "Cambodia",
"CM" => "Cameroon",
"CA" => "Canada",
"CV" => "Cape Verde",
"KY" => "Cayman Islands",
"CF" => "Central African Republic",
"TD" => "Chad",
"CL" => "Chile",
"CN" => "China",
"CX" => "Christmas Island",
"CC" => "Cocos (Keeling) Islands",
"CO" => "Colombia",
"KM" => "Comoros",
"CG" => "Congo",
"CD" => "Congo, the Democratic Republic of the",
"CK" => "Cook Islands",
"CR" => "Costa Rica",
"CI" => "Cote D'Ivoire",
"HR" => "Croatia",
"CU" => "Cuba",
"CY" => "Cyprus",
"CZ" => "Czech Republic",
"DK" => "Denmark",
"DJ" => "Djibouti",
"DM" => "Dominica",
"DO" => "Dominican Republic",
"EC" => "Ecuador",
"EG" => "Egypt",
"SV" => "El Salvador",
"GQ" => "Equatorial Guinea",
"ER" => "Eritrea",
"EE" => "Estonia",
"ET" => "Ethiopia",
"FK" => "Falkland Islands (Malvinas)",
"FO" => "Faroe Islands",
"FJ" => "Fiji",
"FI" => "Finland",
"FR" => "France",
"GF" => "French Guiana",
"PF" => "French Polynesia",
"TF" => "French Southern Territories",
"GA" => "Gabon",
"GM" => "Gambia",
"GE" => "Georgia",
"DE" => "Germany",
"GH" => "Ghana",
"GI" => "Gibraltar",
"GR" => "Greece",
"GL" => "Greenland",
"GD" => "Grenada",
"GP" => "Guadeloupe",
"GU" => "Guam",
"GT" => "Guatemala",
"GN" => "Guinea",
"GW" => "Guinea-Bissau",
"GY" => "Guyana",
"HT" => "Haiti",
"HM" => "Heard Island and Mcdonald Islands",
"VA" => "Holy See (Vatican City State)",
"HN" => "Honduras",
"HK" => "Hong Kong",
"HU" => "Hungary",
"IS" => "Iceland",
"IN" => "India",
"ID" => "Indonesia",
"IR" => "Iran, Islamic Republic of",
"IQ" => "Iraq",
"IE" => "Ireland",
"IL" => "Israel",
"IT" => "Italy",
"JM" => "Jamaica",
"JP" => "Japan",
"JO" => "Jordan",
"KZ" => "Kazakhstan",
"KE" => "Kenya",
"KI" => "Kiribati",
"KP" => "Korea, Democratic People's Republic of",
"KR" => "Korea, Republic of",
"KW" => "Kuwait",
"KG" => "Kyrgyzstan",
"LA" => "Lao People's Democratic Republic",
"LV" => "Latvia",
"LB" => "Lebanon",
"LS" => "Lesotho",
"LR" => "Liberia",
"LY" => "Libyan Arab Jamahiriya",
"LI" => "Liechtenstein",
"LT" => "Lithuania",
"LU" => "Luxembourg",
"MO" => "Macao",
"MK" => "Macedonia, the Former Yugoslav Republic of",
"MG" => "Madagascar",
"MW" => "Malawi",
"MY" => "Malaysia",
"MV" => "Maldives",
"ML" => "Mali",
"MT" => "Malta",
"MH" => "Marshall Islands",
"MQ" => "Martinique",
"MR" => "Mauritania",
"MU" => "Mauritius",
"YT" => "Mayotte",
"MX" => "Mexico",
"FM" => "Micronesia, Federated States of",
"MD" => "Moldova, Republic of",
"MC" => "Monaco",
"MN" => "Mongolia",
"ME" => "Montenegro",
"MS" => "Montserrat",
"MA" => "Morocco",
"MZ" => "Mozambique",
"MM" => "Myanmar",
"NA" => "Namibia",
"NR" => "Nauru",
"NP" => "Nepal",
"NL" => "Netherlands",
"AN" => "Netherlands Antilles",
"NC" => "New Caledonia",
"NZ" => "New Zealand",
"NI" => "Nicaragua",
"NE" => "Niger",
"NG" => "Nigeria",
"NU" => "Niue",
"NF" => "Norfolk Island",
"MP" => "Northern Mariana Islands",
"NO" => "Norway",
"OM" => "Oman",
"PK" => "Pakistan",
"PW" => "Palau",
"PS" => "Palestinian Territory, Occupied",
"PA" => "Panama",
"PG" => "Papua New Guinea",
"PY" => "Paraguay",
"PE" => "Peru",
"PH" => "Philippines",
"PN" => "Pitcairn",
"PL" => "Poland",
"PT" => "Portugal",
"PR" => "Puerto Rico",
"QA" => "Qatar",
"RE" => "Reunion",
"RO" => "Romania",
"RU" => "Russian Federation",
"RW" => "Rwanda",
"SH" => "Saint Helena",
"KN" => "Saint Kitts and Nevis",
"LC" => "Saint Lucia",
"PM" => "Saint Pierre and Miquelon",
"VC" => "Saint Vincent and the Grenadines",
"WS" => "Samoa",
"SM" => "San Marino",
"ST" => "Sao Tome and Principe",
"SA" => "Saudi Arabia",
"SN" => "Senegal",
"RS" => "Serbia",
"SC" => "Seychelles",
"SL" => "Sierra Leone",
"SG" => "Singapore",
"SK" => "Slovakia",
"SI" => "Slovenia",
"SB" => "Solomon Islands",
"SO" => "Somalia",
"ZA" => "South Africa",
"GS" => "South Georgia and the South Sandwich Islands",
"ES" => "Spain",
"LK" => "Sri Lanka",
"SD" => "Sudan",
"SR" => "Suriname",
"SJ" => "Svalbard and Jan Mayen",
"SZ" => "Swaziland",
"SE" => "Sweden",
"CH" => "Switzerland",
"SY" => "Syrian Arab Republic",
"TW" => "Taiwan, Province of China",
"TJ" => "Tajikistan",
"TZ" => "Tanzania, United Republic of",
"TH" => "Thailand",
"TL" => "Timor-Leste",
"TG" => "Togo",
"TK" => "Tokelau",
"TO" => "Tonga",
"TT" => "Trinidad and Tobago",
"TN" => "Tunisia",
"TR" => "Turkey",
"TM" => "Turkmenistan",
"TC" => "Turks and Caicos Islands",
"TV" => "Tuvalu",
"UG" => "Uganda",
"UA" => "Ukraine",
"AE" => "United Arab Emirates",
"GB" => "United Kingdom",
"US" => "United States",
"UM" => "United States Minor Outlying Islands",
"UY" => "Uruguay",
"UZ" => "Uzbekistan",
"VU" => "Vanuatu",
"VE" => "Venezuela",
"VN" => "Viet Nam",
"VG" => "Virgin Islands, British",
"VI" => "Virgin Islands, U.s.",
"WF" => "Wallis and Futuna",
"EH" => "Western Sahara",
"YE" => "Yemen",
"ZM" => "Zambia",
"ZW" => "Zimbabwe"
);


/* Converts a country code to a country name */
function convertCountry($country_code) {

  return $GLOBALS['country_list'][$country_code];
 
}


/* Returns a nice select form of all countries */
function countrySelect($name, $selected) {
  
  if (empty($selected)) {
    $selected = 'SK';
  }
  
  $output = '<select name="' . $name . '">' . "\n";
  
  foreach ($GLOBALS['country_list'] as $country_code => $country_name) {
  
    if ($selected == $country_code) {
      $option_selected = ' selected="selected"';
    } else {
      $option_selected = '';
    }
    
    $output = $output . '<option value="' . $country_code . '"' . $option_selected . '>' . $country_name . '</option>' . "\n";
  
  }
  
  $output = $output . '</select>';
  
  return $output;


}

?>