<?php
ini_set('memory_limit', '8192M');
$er = 0;
ini_set('display_errors',$er);
ini_set('display_startup_errors',$er);
if($er){
error_reporting(E_ALL);
        }
  global $DBcon;
function Ftable($tp="settings")
{
    global $DBcon;
    if (mysqli_num_rows(mysqli_query($DBcon, "SHOW TABLES LIKE '$tp'")) > 0) {
        return true;
    } else {
        return false;
    }
}
function SubmitTool($url){
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HEADER,0);
  curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return $httpCode;
}

function SubmitSiteMap($url) {
  $returnCode = SubmitTool($url);
  if ($returnCode != 200) {
    return "Error $returnCode: $url <BR/>";
  } else {
    return "Submitted $returnCode: $url <BR/>";
  }
}
function AddWeb($sitemaps){
   $res = array();
   if(!is_array($sitemaps))
    $sitemaps = array($sitemaps);
  foreach ($sitemaps as $sitemapUrl) {
  $sitemapUrl = htmlentities($sitemapUrl);
  //Google
  $url = "http://www.google.com/webmasters/sitemaps/ping?sitemap=".$sitemapUrl;
  array_push($res,SubmitSiteMap($url));
  //Bing / MSN
  $url = "http://www.bing.com/webmaster/ping.aspx?siteMap=".$sitemapUrl;
 array_push($res,SubmitSiteMap($url));

}
return $res;
}
  function InStr($subject,$str_to_insert,$rand=false,$ht="p"){
   preg_match_all ("/<$ht>(.*)<\/$ht>/U", $subject, $pat_array);
   if(!$rand){
   $pos = strpos($subject,$pat_array[0][floor(count($pat_array[0])/2)]);
   }else{
   $pos = strpos($subject,$pat_array[0][array_rand($pat_array[0])]);

   }
   if(!$str_to_insert)
    return $subject;
   $newstr = substr_replace($subject, $str_to_insert, $pos, 0);
   return $newstr;
   }

      function sr_google($query,$type ="image",$form= false,$gkey=false) {
          $url = 'http://www.google.com/cse';
          $key="017011003289502861929:k12bsxzbafa";
          $url = 'https://www.googleapis.com/customsearch/v1';
          $clientParam = 'google-csbe';
          $charEncoding = 'iso-8859-1';
          if($type == "video"){
           //   $query = "site:youtube.com ".$query;
          }
           if(!$gkey)
           $gkey = 0;
          $key_ar = array("AIzaSyCfLDnIjMSREDC47p6cf6IOq6Lx8H_tiCU","AIzaSyASrTkKEegeXKoQRXDNnkU4G2zHyCcY2PI","AIzaSyCPa1hkIlSUKlADYiSuragb-17msOwBwDM");
          $params = array (
			'q' => $query,
            "num"=>2,
            "key"=>$key_ar[$gkey],
            "start"=>rand(1,10),
			'client' => $clientParam,
			'output' => 'xml_no_dtd', //Recommended format for the XML from Google.
			'cx' => $key,
			'ie' => $charEncoding, //Sets input character encoding for the search query
			'oe' => 'utf-8'//Get results back in UTF-8. Simple_XML outputs everything as utf-8 so we'll worry about converting character encoding later if need be.
		  );
           $params["siteSearch"] ="youtube.com";
         if($type =="image"){
         $params["siteSearch"] ="google.com";
         }else if($type == "link"){
         $ar =  array("www.wikihow.com","en.wikipedia.org");
          $params["siteSearch"] = $ar[array_rand($ar)];
         }
          // $params["searchType"] ="image";
		   $url =$url . '?' . http_build_query($params);
		  $ch = curl_init($url);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		  $response = curl_exec($ch);
		  $responseHeader = curl_getinfo($ch);
		  curl_close($ch);
		  if ($response === false) {
		   return 'Unable to execute cURL HTTP request.';
		  }
           $search = json_decode($response,true);
           if($search["error"]["errors"][0]["reason"] == "dailyLimitExceeded"){
           if($gkey == count($key_ar))
           return false;
           return sr_google($query,$type,$form,$gkey+1);
           }
           //return  $gkey;
           $search  = $search["items"][array_rand($search["items"])];
           if(!$form){
           if($type == "video" || $type == "link")
           return $search["link"];
           return $search["pagemap"]["cse_image"][0]["src"];
           }else{
           if($type == "video")
           return Fvideo($search["link"]);
           return Fimg($search["pagemap"]["cse_image"][0]["src"],$query);

           }
	  }
             function get_key($keyword){
            $key = explode(",",$keyword);
             for($i=0;$i<=count($key);$i++){

                    $key2 .= " '".$key[$i]."',";

             }
             $key2=  substr($key2,0,strlen($key2)-5);
             return $key2;
             }
function get_keyword2($query,$rand=true,$key="c7407c9ec40543c080160e96d93746b3") {
$host = "https://api.cognitive.microsoft.com";
$path = "/bing/v7.0/Suggestions";
$mkt = "en-US";
    $params = '?mkt=' . $mkt . '&q=' . urlencode($query);

    $headers = "Content-type: text/json\r\n" .
        "Ocp-Apim-Subscription-Key: $key\r\n";
    $options = array (
        'http' => array (
            'header' => $headers,
            'method' => 'GET'
        )
    );
   $context  = stream_context_create ($options);
   $result = file_get_contents ($host . $path . $params, false, $context);
   if($rand){
   $result =  json_decode ($result,true)  ;
   $result =  $result["suggestionGroups"][0]["searchSuggestions"]  ;
   $result  = $result[array_rand($result)]["displayText"];
   }
   return $result;

}
function get_keyword($query,$rand=true) {
   $result = Json("http://suggestqueries.google.com/complete/search?q=".urlencode($query)."&client=firefox");
   $result =  $result[1];
   if($rand){
   $result  = $result[array_rand($result)];
   }
   return $result;

}
function get_key_array($query,$rand=true) {
    $result = explode(",",$query);
   if($rand){
   $result  = $result[array_rand($result)];
   }
   return $result;
}
function get_post($id=2644){
               $curl = Json("https://www.restoviebelle.com/?wp_automatic=cron&curl=".$id);
              $cont = str_replace($curl["keyword"],"<a target='_black' href='#' >".$curl["keyword"]."</a>",$curl["post_content"]);
                 if(!$curl["error"]){
                   $curl["content_org"] =  htmlspecialchars_decode($curl["post_content"]);
                   $curl["title_org"] =  htmlspecialchars_decode($curl["post_title"]);
                   return $curl;
                   }else{
                   return false;
           }
}
function set_gramer($curl,$id="AJJJUKL4aV52fng8"){
           $curl2 = Json("https://api.textgears.com/check.php?text=".urlencode(htmlspecialchars_decode($curl["content"], ENT_QUOTES))."&key=".$id);
                if($curl2["result"]){
            $errors = $curl2["errors"];
           $cont = $curl["content"];
            $arc = array($cont);
           for($i=0;$i<count($errors);$i++){
              $bad =  $errors[$i]["bad"]  ;
              $better =  $errors[$i]["better"][array_rand($errors[$i]["better"])] ;
              $offset =  $errors[$i]["offset"] ;
             //$cont = implode($better, explode($bad,$arc[count($arc)-1],$offset));
             $cont = substr($arc[count($arc)-1], 0,$offset).str_replace($bad,$better, substr($arc[count($arc)-1],$offset));
             array_push($arc,$cont);
            }
            $curl["content"] = $arc[count($arc)-1];
                   return $curl;
                   }else{
                   return false;
           }
}
function  spin_post($curl){
    if(!$curl["post_content"])
        return false;
$fields = array(
	'text' => urlencode(htmlspecialchars_decode($curl["post_content"])),
	'title' => urlencode(htmlspecialchars_decode($curl["post_title"])),
);
$curl3 = Json("https://www.restoviebelle.com/?wp_auto_spinner=spiner",true,$fields);
  if($curl3){
      $curl2["content"] =  $curl3["post_content"];
      $curl2["title"] =  $curl3["post_title"];
      $curl2["content_org"] =  $curl["post_content"];
      $curl2["title_org"] =  $curl["post_title"];
      $curl2["keyword"]  = $curl["keyword"];
      $curl2["date"]  = time();
      return $curl2;
      }
   return false;
}
function  set_post(){
 $get =  spin_post(get_post());
 $get = set_gramer($get);
 if($get){
 if(!Num("wp_posts","where title_org='".$get["title_org"]."'")){
 return SqlIn("wp_posts",$get);
 }else{
   return false;
 }

 }
 return $get;
}
function Fcol($fieldname="", $table="settings")
{
    global $DBcon;
    $result = @mysqli_query($DBcon, "SHOW COLUMNS FROM `$table` LIKE '$fieldname'");
    if (mysqli_num_rows($result)) {
        //return Sel($table)->$fieldname;
        return array(true,Sel($table)->$fieldname);
    } else {
        return false;
    }
}
function addDayswithdate($date, $days)
{
    $date = strtotime("+".$days." days", strtotime($date));
    return  date("Y-m-d", $date);
}
function str($t, $s)
{
    $Fa=strlen($t) - $s;
    if ($Fa > 0) {
        $sr = '.....';
    } else {
        $sr = '';
    }
    $S=  '<span style="direction: initial;">'.substr($t, 0, $s);
    $S .=$sr.'</span>';
    return $S;
}

//////////////////////////////
   function countre()
   {
       return array('Andorra',
'United Arab Emirates',
'Afghanistan',
'Antigua and Barbuda',
'Anguilla',
'Albania',
'Armenia',
'Angola',
'Antarctica',
'Argentina',
'American Samoa',
'Austria',
'Australia',
'Aruba',
'Aland Islands',
'Azerbaijan',
'Bosnia and Herzegovina',
'Barbados',
'Bangladesh',
'Belgium',
'Burkina Faso',
'Bulgaria',
'Bahrain',
'Burundi',
'Benin',
'Saint Barthalemy',
'Bermuda',
'Brunei Darussalam',
'Bolivia, Plurinational State of',
'Bonaire, Sint Eustatius and Saba',
'Brazil',
'Bahamas',
'Bhutan',
'Bouvet Island',
'Botswana',
'Belarus',
'Belize',
'Canada',
'Cocos (Keeling) Islands',
'Congo, the Democratic Republic of the',
'Central African Republic',
'Congo',
'Switzerland',
'Cote d\'Ivoire ! C?´te d\'Ivoire ',
'Cook Islands',
'Chile',
'Cameroon',
'China',
'Colombia',
'Costa Rica',
'Cuba',
'Cape Verde',
'Cura?§ao',
'Christmas Island',
'Cyprus',
'Czech Republic',
'Germany',
'Djibouti',
'Denmark',
'Dominica',
'Dominican Republic',
'Algeria',
'Ecuador',
'Estonia',
'Egypt',
'Western Sahara',
'Eritrea',
'Spain',
'Ethiopia',
'Finland',
'Fiji',
'Falkland Islands (Malvinas)',
'Micronesia, Federated States of',
'Faroe Islands',
'France',
'Gabon',
'United Kingdom',
'Grenada',
'Georgia',
'French Guiana',
'Guernsey',
'Ghana',
'Gibraltar',
'Greenland',
'Gambia',
'Guinea',
'Guadeloupe',
'Equatorial Guinea',
'Greece',
'South Georgia and the South Sandwich Islands',
'Guatemala',
'Guam',
'Guinea-Bissau',
'Guyana',
'Hong Kong',
'Heard Island and McDonald Islands',
'Honduras',
'Croatia',
'Haiti',
'Hungary',
'Indonesia',
'Ireland',
'Israel',
'Isle of Man',
'India',
'British Indian Ocean Territory',
'Iraq',
'Iran, Islamic Republic of',
'Iceland',
'Italy',
'Jersey',
'Jamaica',
'Jordan',
'Japan',
'Kenya',
'Kyrgyzstan',
'Cambodia',
'Kiribati',
'Comoros',
'Saint Kitts and Nevis',
'Korea, Democratic People\'s Republic of',
'Korea, Republic of',
'Kuwait',
'Cayman Islands',
'Kazakhstan',
'Lao People\'s Democratic Republic',
'Lebanon',
'Saint Lucia',
'Liechtenstein',
'Sri Lanka',
'Liberia',
'Lesotho',
'Lithuania',
'Luxembourg',
'Latvia',
'Libya',
'Morocco',
'Monaco',
'Moldova, Republic of',
'Montenegro',
'Saint Martin (French part)',
'Madagascar',
'Marshall Islands',
'Macedonia, the former Yugoslav Republic of',
'Mali',
'Myanmar',
'Mongolia',
'Macao',
'Northern Mariana Islands',
'Martinique',
'Mauritania',
'Montserrat',
'Malta',
'Mauritius',
'Maldives',
'Malawi',
'Mexico',
'Malaysia',
'Mozambique',
'Namibia',
'New Caledonia',
'Niger',
'Norfolk Island',
'Nigeria',
'Nicaragua',
'Netherlands',
'Norway',
'Nepal',
'Nauru',
'Niue',
'New Zealand',
'Oman',
'Panama',
'Peru',
'French Polynesia',
'Papua New Guinea',
'Philippines',
'Pakistan',
'Poland',
'Saint Pierre and Miquelon',
'Pitcairn',
'Puerto Rico',
'Palestine, State of',
'Portugal',
'Palau',
'Paraguay',
'Qatar',
'Reunion ! R?©union ',
'Romania',
'Serbia',
'Russian Federation',
'Rwanda',
'Saudi Arabia',
'Solomon Islands',
'Seychelles',
'Sudan',
'Sweden',
'Singapore',
'Saint Helena, Ascension and Tristan da Cunha',
'Slovenia',
'Svalbard and Jan Mayen',
'Slovakia',
'Sierra Leone',
'San Marino',
'Senegal',
'Somalia',
'Suriname',
'South Sudan',
'Sao Tome and Principe',
'El Salvador',
'Sint Maarten (Dutch part)',
'Syrian Arab Republic',
'Swaziland',
'Turks and Caicos Islands',
'Chad',
'French Southern Territories',
'Togo',
'Thailand',
'Tajikistan',
'Tokelau',
'Timor-Leste',
'Turkmenistan',
'Tunisia',
'Tonga',
'Turkey',
'Trinidad and Tobago',
'Tuvalu',
'Taiwan, Province of China',
'Tanzania, United Republic of',
'Ukraine',
'Uganda',
'United States Minor Outlying Islands',
'United States',
'Uruguay',
'Uzbekistan',
'Holy See (Vatican City State)',
'Saint Vincent and the Grenadines',
'Venezuela, Bolivarian Republic of',
'Virgin Islands, British',
'Virgin Islands, U.S.',
'Viet Nam',
'Vanuatu',
'Wallis and Futuna',
'Samoa',
'Yemen',
'Mayotte',
'South Africa',
'Zambia',
'Zimbabwe');
   }
    function countreCode()
    {
        return array('AD','AE','AF','AG','AI','AL','AM','AO','AQ','AR','AS','AT','AU','AW','AX','AZ','BA','BB','BD','BE','BF','BG','BH','BI','BJ','BL','BM','BN','BO','BQ','BR','BS','BT','BV','BW','BY','BZ','CA','CC','CD','CF','CG','CH','CI','CK','CL','CM','CN','CO','CR','CU','CV','CW','CX','CY','CZ','DE','DJ','DK','DM','DO','DZ','EC','EE','EG','EH','ER','ES','ET','FI','FJ','FK','FM','FO','FR','GA','GB','GD','GE','GF','GG','GH','GI','GL','GM','GN','GP','GQ','GR','GS','GT','GU','GW','GY','HK','HM','HN','HR','HT','HU','ID','IE','IL','IM','IN','IO','IQ','IR','IS','IT','JE','JM','JO','JP','KE','KG','KH','KI','KM','KN','KP','KR','KW','KY','KZ','LA','LB','LC','LI','LK','LR','LS','LT','LU','LV','LY','MA','MC','MD','ME','MF','MG','MH','MK','ML','MM','MN','MO','MP','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ','NA','NC','NE','NF','NG','NI','NL','NO','NP','NR','NU','NZ','OM','PA','PE','PF','PG','PH','PK','PL','PM','PN','PR','PS','PT','PW','PY','QA','RE','RO','RS','RU','RW','SA','SB','SC','SD','SE','SG','SH','SI','SJ','SK','SL','SM','SN','SO','SR','SS','ST','SV','SX','SY','SZ','TC','TD','TF','TG','TH','TJ','TK','TL','TM','TN','TO','TR','TT','TV','TW','TZ','UA','UG','UM','US','UY','UZ','VA','VC','VE','VG','VI','VN','VU','WF','WS','YE','YT','ZA','ZM','ZW');
    }

    function CCout()
    {
        $p =countreCode();
        return count($p);
    }
    function getCCode($pos)
    {
        $p = countreCode();
        return $p[$pos];
    }

    function getCName($cOde)
    {
        $cc = countreCode();
        $C = countre();
        for ($i=0;$i<count($cc);$i++) {
            if (strtolower($cc[$i]) == $cOde) {
                break;
            }
        }
        return $C[$i];
    }
    function ip_details($ip=false)
    {
        $json = file_get_contents("http://ipinfo.io/{$ip}");
        $details = json_decode($json);
        return $details->country;
    }
    function Fburl($id=false)
    {
        $R= "https://www.facebook.com/".$id;
        return $R;
    }

function facebook_username($url='')
{
    if (strpos($url, "profile.php?id=")) {
        return str_replace('profile.php?id=', '', substr($url, strpos($url, "profile.php?id=")));
    } else {
        $data = explode('/', $url);
        return $data[3];
    }
}

function Iadmin($id=0)
{
    if (Ls('admin') and $id) {
        return facebook_username(Fb($id));
    } else {
        return facebook_username(Sel('admin')->fb);
    }
}
function Tw($id=0)
{
    return "https://www.twitter.com/".$id;
}
function more($tutorial_id, $SAll, $showLimit, $home)
{
    if ($SAll > $showLimit) {
        if ($home) {
            $r = '<div class="timeline-milestone more" id="show_more_main'.$tutorial_id.'" >
                   <a id="'.$tutorial_id.'" class="btn waves-effect waves-light  z-depth-2  show_more"    data-position="buttom" data-tooltip="تحميل المزيد من المنشورات" >
                            <span class="icon_more" ><i class="fa fa-refresh "></i> عرض المزيد</span>
                              <span class="loding" style="display:none">  <img style="width: 25px;height: 25px;    margin: 6px;" src="../assets/images/spin.svg" alt="" />   </span>
                     </a>
                   </div>';
        } else {
            $r = '   <div style="margin-bottom: 12px;" class="col  s12 m12  center" id="show_more_main'.$tutorial_id.'">
                 <a id="'.$tutorial_id.'" class="btn waves-effect waves-light  z-depth-2  show_more" alt=""   data-position="buttom" data-tooltip="تحميل المزيد من المنشورات" data-tooltip-id="ed472c81-cc4c-1ce6-956d-2ac9b8acd67b">
            <span class="loding" style="display:none">  <img style="width: 25px;height: 25px;    margin: 6px;" src="../assets/images/spin.svg" alt="" />   </span>
        <span class="icon_more" >  <i class="fa fa-refresh "></i>       عرض المزيد  </span>

                 </a>

 </div>';
        }
    } else {
        $r = false;
    }
    return $r;
}
function NotFound()
{
    $r ='<div class="col s12 m12 " style="     direction: rtl;     margin-bottom: 10px;   margin-top: 10px;">
<div class="center  z-depth-1 red divider center white-text ">
<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>      لم يتم العثور على نتائج
</div>
</div>';

    return $r;
}
function error($msg, $id, $name, $e='')
{
    if (!$id) {
        $r ='<div class="col s12 m12 " style="direction: rtl;      margin-bottom: 10px;   margin-top: 10px;">
<div class="center  z-depth-1 red divider center white-text bold">
<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i> '.$msg.' </div></div>';
    } else {
        $r ='<div class="col s12 m12 " style="direction: rtl;      margin-bottom: 10px;   margin-top: 10px;">
<div class="center  z-depth-1 red divider center white-text bold">
<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i> '.$msg.' <a href="'.Fb($id).'" target="_blank" style="color: #b1dcfb;">'.$name.'</a><span style="    display: block;
    font-size: 13px;"> '.$e.'</span></div></div>';
    }

    return $r;
}
function Amsg($msg="", $c="", $a="", $ma="")
{
    if (!$c) {
        $c="cyan darken-1";
    }
    if (!$a or $a == 'no') {
        $r ='<div class="col s12 m12 " style="direction: rtl;      margin-bottom: 5px;   margin-top: 5px;">
<div class="center  z-depth-1 '.$c.' divider center white-text bold">
<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i> '.$msg.' </div></div>';
    } else {
        if (!$ma) {
            $ma="من هنا";
        }
        $r ='<div class="col s12 m12 " style="direction: rtl;      margin-bottom: 5px;   margin-top: 5px;">
<div class="center  z-depth-1 '.$c.' divider center white-text bold">
<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i> '.$msg.' <a href="'.$a.'" target="_blank" style="color: #b1dcfb;">'.$ma.'</a></div></div>';
    }

    return $r;
}
function success($msg, $id, $name)
{
    if (!$id) {
        $r ='<div class="col s12 m12 " style="direction: rtl;      margin-bottom: 10px;   margin-top: 10px;">
<div class="center  z-depth-1 green divider center white-text bold">
<i class="fa fa-check fa-lg" aria-hidden="true"></i> '.$msg.' </div></div>';
    } else {
        $r ='<div class="col s12 m12 " style="direction: rtl;      margin-bottom: 10px;   margin-top: 10px;">
<div class="center  z-depth-1 green divider center white-text bold">
<i class="fa fa-check fa-lg" aria-hidden="true"></i> '.$msg.' <a href="'.Fb($id).'" target="_blank" style="color: #b1dcfb;">'.$name.'</a> </div></div>';
    }

    return $r;
}
function limit_str($text, $limit, $d=false)
{
    $m = explode(" ", $text);
    if (count($m) > $limit) {
        $y = array();
        for ($t=0;$t<=($limit-1);$t++) {
            $y[$t] = $m[$t];
        }
        $b = implode(" ", $y);
        if (!$d) {
            $b .= " ...";
        }
    } else {
        $b = $text;
    }
    return $b;
}
function short($short=flase, $link="", $pos=flase, $img=false)
{
    global $googl;
    global $goog;
    if (!$img) {
        if ($short == 1 and $googl->shorten($link) and !$pos) {
            $postb['link'] = $googl->shorten($link);
        } else {
            $postb['link'] = $link;
        }
    } else {
        if ($short == 1 and $goog->shorten($link)) {
            $postb['link'] = $goog->shorten($link);
        } else {
            $postb['link'] = $link;
        }
    }
    return $postb['link'];
}
function visitor_country($ip=false)
{
    if (!$ip) {
        $ip = ip();
    }
    //    $ip = "79.173.199.93";
    $ip_data = @json_decode(readURL("http://www.geoplugin.net/json.gp?ip=".$ip));
    if ($ip_data && $ip_data->geoplugin_countryCode != null) {
        $result = $ip_data->geoplugin_countryCode;
        return $result;
    } elseif (ip_details($ip)) {
        return ip_details($ip);
    } else {
        return 'Un Known';
    }
}
    function ip()
    {
        $alt_ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $alt_ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) and preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] as $ip) {
                if (!preg_match("#^(10|172\.16|192\.168)\.#", $ip)) {
                    $alt_ip = $ip;
                    break;
                }
            }
        } elseif (isset($_SERVER['HTTP_FROM'])) {
            $alt_ip = $_SERVER['HTTP_FROM'];
        }
        return $alt_ip;
    }
function msg($type="", $msg="")
{
    $_SESSION['type'] = $type;
    $_SESSION['msg'] = $msg;
}
function redMsg($type='success', $msg="", $D=false, $j=false, $url=false)
{
    if ($msg) {
        if (!$j) {
            msg($type, $msg);
            if (!$url) {
                $url = "../";
            }
            echo'
<script type="text/javascript">
  window.location.replace("'.$url.'");
</script>';
        } else {
            echo json_encode($type);
        }
        if ($D) {
            die();
        }
    }
}
function loding($t, $d, $h= 260)
{
    if ($d) {
        $d="style='display:none;min-height:".$h." px;'";
    } else {
        $d="style='min-height: ".$h."px;'";
    }
    $r ='<div class="loaderr col s12 center" '.$d.' dir="ltr" > <p>'.$t.'</p>
    <img src="../assets/images/ripple.svg" alt="" />
    </div>';

    return $r;
}
function TUrl($name,$id){
 return "https://".$name.".tumblr.com/".$id;
}
function readURL($url)
{
    $ch      = curl_init();
    $timeout = 60; // set to zero for no timeout
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return curl_error($ch);
}
function curl_download($Url,$fields = false){
    if (!function_exists('curl_init')){
        return 'Sorry cURL is not installed!';
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com");
    curl_setopt($ch,CURLOPT_USERAGENT, "[FBAN/FB4A;FBAV/37.0.0.0.109;FBBV/11557663;FBDM/{density=1.5,width=480,height=854};FBLC/en_US;FBCR/Android;FBMF/unknown;FBBD/generic;FBPN/com.facebook.katana;FBDV/google_sdk;FBSV/4.4.2;FBOP/1;FBCA/armeabi-v7a:armeabi;]");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if($fields and count($fields) > 0){
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    rtrim($fields_string, '&');
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    }
    // Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    // Download the given URL, and return output
    $output = curl_exec($ch);

    // Close the cURL resource, and free system resources
    curl_close($ch);

    return $output;
}
function Json($url="", $t=true,$f=false)
{
    return json_decode(curl_download($url,$f),$t);
}
function  Ctokn($access){
$e = Json("https://graph.facebook.com/me/permissions?access_token="  . $access)['error']['message'];
 if($e  == ""){
return true;
 }
 return false;
}
function getLoginUrl($user, $pass, $type="android")
{
    if ($type == "android") {
        $apikey = "882a8490361da98702bf97a021ddc14d";
        $sec = "62f8ce9f74b12f84c123cc23437a4a32";
    } else {
        $apikey = "3e7c78e35a76a9299309885393b02d97";
        $sec = "c1e620fa708a1d5696fb991c1bde5662";
    }
    $mdtet = "api_key=".$apikey."email=".$user."format=JSONlocale=vi_vnmethod=auth.loginpassword=".$pass."return_ssl_resources=0v=1.0".$sec;
    $Mapp= "api_key=".$apikey."&email=".$user."&format=JSON&locale=vi_vn&method=auth.login&password=".$pass."&return_ssl_resources=0&v=1.0";
    return "https://api.facebook.com/restserver.php?".$Mapp."&sig=".md5($mdtet);
}
function Nlogin($user="", $pass="", $type="android")
{
    $error = 0;
    $token = "";
    $msg = "";
    if ($type == "android") {
        $apikey = "882a8490361da98702bf97a021ddc14d";
        $sec = "62f8ce9f74b12f84c123cc23437a4a32";
    } else {
        $apikey = "3e7c78e35a76a9299309885393b02d97";
        $sec = "c1e620fa708a1d5696fb991c1bde5662";
    }
    //$pas = str_replace("#","",$pass);
    //https://api.facebook.com/restserver.php?api_key=882a8490361da98702bf97a021ddc14d&email=mohtasm.sawilh&format=JSON&locale=vi_vn&method=auth.login&password=mohtasmadmin10QQ&return_ssl_resources=0&v=1.0&sig=3ebba1fff1ace1dd3ff1cddf81e9bd7a
    $mdtet = "api_key=".$apikey."email=".$user."format=JSONlocale=vi_vnmethod=auth.loginpassword=".$pass."return_ssl_resources=0v=1.0".$sec;
    $Mapp= "api_key=".$apikey."&email=".$user."&format=JSON&locale=vi_vn&method=auth.login&password=".$pass."&return_ssl_resources=0&v=1.0";
    $ar = json("https://api.facebook.com/restserver.php?".$Mapp."&sig=".md5($mdtet));
    if ($ar["error_code"]) {
        //Sion("Lerror",$ar["error_code"]);
        $error = $ar["error_code"];
        $msg = $ar["error_msg"];
    } else {
        //SqlIn("fbusers",array("username"=>$user,"password"=>$pass,"date"=>time(),"Lerror"=>$ar["error_code"]));
        $token = $ar["access_token"];
        $json ='https://graph.facebook.com/me?fields=mobile_phone,id,name,location,email,religion,link,gender,birthday,about,education,cover,relationship_status&method=get&access_token='.$ar["access_token"];
        $array = json($json);
        iSion("token", $ar["access_token"]);
        iSion("spass", $ar["access_token"]);
    }
    return array("error"=>$error,"msg"=>$msg,"info"=>$array,"token"=>$token);
}
function getInfo($access)
{
    $json ='https://graph.facebook.com/me?fields=mobile_phone,id,name,location,email,religion,link,gender,birthday,about,education,cover,relationship_status&method=get&access_token='.$access;
    $array = json($json);
    $error = 0;
    if ($array["error"]) {
        $error = 1;
        $msg = $array["error"]["message"];
    }
    return array("error"=>$error,"msg"=>$msg,"info"=>$array,"token"=>$access);
}
function Sion($sion)
{
    if (isset($_SESSION[$sion])) {
        return $_SESSION[$sion];
    } else {
        return false;
    }
}
function iSion($sion, $v)
{
    $_SESSION[$sion] =  $v;
    if (Sion($sion)) {
        return $_SESSION[$sion];
    } else {
        return false;
    }
}
function SQ($sq)
{
    $s=  base64_decode($sq);
    return $s;
}

  function Remove($tb="", $where="")
  {
      global $DBcon;
      $sql=  mysqli_query($DBcon, "delete  from $tb $where");
      if ($sql) {
          return true;
      } else {
          return false;
      }
  }
function Ser($html)
{
    return addslashes(htmlspecialchars(mysqli_real_escape_string(strip_tags($html))));
}
function De($html)
{
    return stripslashes($html);
}
function Cstr($str="", $md=false)
{
    if ($md) {
        return md5(Rstr(Rstr(Rstr(Rstr(Rstr(Rstr(Rstr(Rstr(Rstr(Ser(De($str))), '"', ''), "'", ''), '--', ''), 'or', ''), 'OR', ''), 'Or', ''), '//', ''), 'oR', ''));
    } else {
        return Rstr(Rstr(Rstr(Rstr(Rstr(Ser($str)), '--', ''), 'or', ''), 'OR', ''), 'Or', '');
    }
}

function WR($w=false, $fille="num.txt")
{
    if (!$w) {
        $file = fopen($fille, "r+");
        $num = fread($file, filesize($fille));
        if (!$num) {
            $num =1;
        }
        return $num;
    } else {
        $file = fopen($fille, "w+");
        return fwrite($file, $w);
    }
    fclose($file);
}
function Rd($t=false, $l="")
{
    if ($t) {
        echo '<script type="text/javascript">
var l =0; var t = '.$t.';
setInterval(function (){ l++; if(l == t){ location.replace("'.$l.'"); } },1000);
</script>
';
    }
}
function Numday($appsql, $d="today", $where=" ")
{
    $user=0;
    $d=strtotime($d);
    $S= getUser($appsql, $where.' order by id desc ');
    if ($S) {
        for ($i=0;$i < count($S);$i++) {
            $T = $S[$i];
            if (date("Y-m-d", $T['data']) == date("Y-m-d", $d)) {
                $user +=1;
            }
        }
    }
    return $user;
}
function nUser($id, $where)
{
    global $GP;
    global $DBcon;
    //$where = str_replace("where","",$where);
    $sql = mysqli_query($DBcon, "select * from $GP   $where  and id>$id limit 1");
    if (mysqli_num_rows($sql)>=1) {
        $data = mysqli_fetch_object($sql);

        return $data->id;
    } else {
        return 0;
    }
}
function UpDate($tb="", $name="", $data="", $where="")
{
    global $DBcon;
    if (is_array($name)) {
        $keys = "";
        $values = "";
        $i = count($name);
      foreach ($name as $key => $value) {
           /*   $col = mysqli_query($DBcon, "SELECT ".$key." FROM ".$tb." ");
            if (!$col) {
                mysqli_query($DBcon, "ALTER TABLE ".$tb." ADD ".$key." text CHARACTER SET utf8 NOT NULL");
            }*/
            $sql = UpDate($tb, $key, $value, $where);
            $i--;
        }
    } else {
        /*$col = mysqli_query($DBcon, "SELECT ".$name." FROM ".$tb." ");
        if (!$col) {
            mysqli_query($DBcon, "ALTER TABLE ".$tb." ADD ".$name." text CHARACTER SET utf8 NOT NULL");
        }*/
        $sql=  mysqli_query($DBcon, 'update '.$tb.' set '.$name.'="'.$data.'" '.$where);
    }
    if ($sql) {
        return true;
    } else {
        return false;
    }
}
function getSet()
{
    global $DBcon;
    $SQL = @mysqli_query($DBcon, "SELECT * FROM settings");
    return @mysqli_fetch_object($SQL);
}
function SqlEmpty($tp="")
{
    global $DBcon;
    $SQL =  mysqli_query($DBcon, "TRUNCATE $tp");
    return $SQL;
}
function getUser($tp="", $where="", $w="*")
{
    global $DBcon;
    $sql = mysqli_query($DBcon, "select $w from $tp  $where") or die(mysqli_error());

    if (mysqli_num_rows($sql)) {
        $info = array();
        while ($data =  mysqli_fetch_assoc($sql)) {
            $info[] = $data;
        }
        return $info;
    }
    return false;
}
function Sel($tp="", $w='')
{
    global $DBcon;
    $Sql=  mysqli_query($DBcon, "select * from $tp $w");
    if ($Sql) {
        $N= mysqli_fetch_object($Sql);
        return  $N;
    } else {
        return false;
    }
}
function Selaa($tp="", $w='')
{
    global $DBcon;
    $Sql=  mysqli_query($DBcon, "select * from $tp $w");
    if ($Sql) {
        $N= mysqli_fetch_assoc($Sql);
        return  $N;
    } else {
        return false;
    }
}
function digital($DROPLET_ID=88299098,$token="c345be5976289a2b3af6ecc4aeabd829b6dcf5e78644a398d400c1b0f81f094e"){
$data = array("type" => "reboot");
$data_string = json_encode($data);
$ch = curl_init('https://api.digitalocean.com/v2/droplets/'.$DROPLET_ID.'/actions');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$token,
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);

$result = curl_exec($ch);
return $result;

}
function last_share($t=0, $last=0, $m=false)
{
    if (!$m) {
        $corn_time = $t *60*60;
    } else {
        $corn_time = $t*60;
    }
    $next = $last + $corn_time;
    if ($next <= time()) {
        return true;
    } else {
        return false;
    }
}

function user_share()
{
    $next = Sel("posts", "where time='1' and Tsend='0' and time_share<='".time()."' ");
    if ($next) {
        return  array('id'=>$next->id,'user'=>$next->userid,'PostTo'=>$next->PostTo);
        ;
    } else {
        return false;
    }
}
 function SqlError(){
    global $DBcon;
    return mysqli_error($DBcon);

 }
 function SqlIn($tp="", $data="", $f=false, $c=false)
 {
     global $DBcon;

     if (is_array($data)) {
         $keys = '';
         $values = '';
         $i = count($data);
         foreach ($data as $key => $value) {
          /*   $col = mysqli_query($DBcon, "SELECT ".$key." FROM ".$tp." ");
             if (!$col) {
                 mysqli_query($DBcon, "ALTER TABLE ".$tp." ADD ".$key." text CHARACTER SET utf8 NOT NULL");
             }*/
             $value =  str_replace('"',"'",$value);
             if ($key=="password" and !$f) {
                 $value = md5($value);
             }
             if ($i == 1) {
                 $keys .= $key;
                 $values .=  ' "'.$value.'" ';
             } else {
                 $keys .= $key.',';
                 $values .= ' "'.$value.'",';
             }

             $i--;
         }
         $sql = 'insert into '.$tp.' ('.$keys.') values ('.$values.')';

         $Add = mysqli_query($DBcon, $sql);
         if ($Add) {
             $id=  mysqli_insert_id($DBcon);
             return $id;
         } else {
             return false;

         }
     }

     return false;
 }
function Ctime($T=false)
{
  $R = "كل  ساعتين منشور واحد";

    if ($T == 4) {
        $R = "كل 4 ساعات منشور واحد";
    } elseif ($T == 6) {
        $R = "كل 6 ساعات منشور واحد";
    } elseif ($T == 12) {
        $R = "كل 12 ساعه منشور واحد";
    } elseif ($T == 24) {
        $R = "كل 24 ساعه منشور واحد";
    }
    return $R;
}

function isv($is='', $a=false)
{
    if (isset($_POST[$is]) and !$a) {
        return $_POST[$is];
    } elseif (isset($_GET[$is])) {
        return $_GET[$is];
    }
    return false;
}
function NotToken()
{
    if (!Ctoken(getSet()->token)) {
        UpDate("settings", "zapier", 1);
    } else {
        UpDate("settings", "zapier", 0);
    }
}

function Cinst($tb, $arm, $wr)
{
    if (Sel($tb, $wr)) {
        $sq= UpDate($tb, $arm,null, $wr);
    } else {
        $sq = SqlIn($tb, $arm, true);
    }
    return $sq;
}
function rtoken()
{
    if (!Ctoken(getSet()->token)) {
        $user = "mohtasm.sawilh";
        $pass = "L5NRU322EU";
        $log = Nlogin($user, $pass);
        if ($log["error"] == 0) {
            UpDate('settings', 'token', $log["token"]);
        }
    }
}
function Rstr($str="", $r=" ", $rr="")
{
    return  str_replace($r, $rr, $str);
}
function Uvideo($id, $R=false)
{
    if (!$R or $R == null) {
        $r = getSet()->url.'/video'.$id.'.html';
    } else {
        $r = $R.'/video'.$id.'.html';
    }
    return $r;
}
function Tpost($Tpost, $userid, $postb)
{
    if ($Tpost != "likes" and $Tpost != "comments" and  $Tpost != "add_groups") {
        $ptags = " ";
        $phot = false;
        if ($Tpost == 0) {
            $ad ='https://graph.facebook.com/'.$userid.'/feed?message='.urlencode($postb['message']).'&method=post&access_token='.$postb['access_token'];
        } elseif ($Tpost == 3) {
            $ad ='https://graph.facebook.com/'.$userid.'/feed?message='.urlencode($postb['message']).'&description='.urlencode($postb['description']).'&picture='.urlencode($postb['picture']).'&link='.urlencode($postb['link']).'&name='.urlencode($postb['name']).'&method=post&access_token='.$postb['access_token'];
        } elseif ($Tpost == 5 or $Tpost == 2 or $Tpost == 6) {
            $phot = true;
            if ($postb['tags']) {
                $data = array(array('tag_uid' =>$postb['tags'],'x' => rand() % 100,'y' => rand() % 100));
                $data = json_encode($data);
                $ptags = "&tags=".$data;
            }
            $ad ='https://graph.facebook.com/'.$userid.'/photos?url='.urlencode($postb['url']).'&message='.urlencode($postb['message']).'&method=post&access_token='.$postb['access_token'].$ptags;
        } else {
            $ad ='https://graph.facebook.com/'.$userid.'/feed?link='.urlencode($postb['link']).'&message='.urlencode($postb['message']).'&method=post&access_token='.$postb['access_token'];
        }
        if ($postb['tags'] && !$phot) {
            //$ad .= '&tags='.$postb['tags'];
            $ad .= '&tags='.$postb['tags'];
        }
    } elseif ($Tpost == "likes") {
        $ad ='https://graph.facebook.com/'.$userid.'/likes?method=post&access_token='.$postb['access_token'];
    } elseif ($Tpost == "comments") {
        $ad ='https://graph.facebook.com/'.$userid.'/comments?method=post&access_token='.$postb['access_token'].'&message='.urlencode($postb['message']);
    } elseif ($Tpost == "add_groups") {
        $ad ='https://graph.facebook.com/'.$userid.'/members?method=post&access_token='.$postb['access_token'].'&member='.urlencode($postb['uid']);
    }
    return json_decode(readURL($ad), true);
}
function tags($id)
{
    $user = getUser('friends', 'where uid="'.$id.'" order by rand() ');
    if (isset($user)) {
        for ($x=0;$x<count($user);$x++) {
            $uid .= ','.$user[$x]['pid'];
        }
        $uid = str_replace(',,', ',', substr($uid, 1, strlen($uid)));
    }
    return $uid;
}
function getPageM($pageid='')
{
    $pageinfo = Json('https://graph.facebook.com/'.$pageid.'/?fields=access_token&access_token='.getSet()->token.'&method=GET');
    if ($pageinfo) {
        return $pageinfo['access_token'];
    }
    return getSet()->token;
}
 function getPage($userid='', $pageid='', $c=false)
 {
     $info =Sel('users', 'where user_id='.$userid);
     if ($info) {
         $pageinfo = Json('https://graph.facebook.com/'.$pageid.'/?fields=access_token&access_token='.$info->access.'&method=GET');
         if ($pageinfo) {
             return $pageinfo['access_token'];
         }
         return $info->access;
     }
 }

function TimeShare($A=false)
{
    global $appsql;
    global $app;
    global $PUr;
    global $Werd;
    $w=true;
    if ($A) {
        $S = Sel('share');
        $time = time();
        if ($A == "quran") {
            if ($Werd) {
                $msg  =  $S->werd_msg;
                $tt = 24;
            } else {
                $msg  =  $S->quran_msg;
                $tt = $S->time_msg;
            }
        } elseif ($A == "video") {
            $msg  =  $S->share_video;
            $tt = 4;
            //	$w=false;
        } else {
            $msg  =  $S->share_msg;
            $tt = $S->time_msg;
        }
        if (last_share($tt, $msg) and $w) {
            $aa = array(
       'time'=>0,
       'post'=>0,
       'blog'=>2,
       'St'=>0,
       'quran'=>0,
       'htc'=>0,
       );
        } else {
            $aa = false;
        }
        return $aa;
    }
    $S = Sel('share');
    $time = time();
    $corn_time = $S->time *60*60;
    $share='share'.$S->time;
    $next = $S->$share + $corn_time;
    $appid = 1;
    if ($appid != "") {
        if (last_share($S->time, $S->$share) and Num($appsql, 'where time='.$S->time) > 0 and getSet()->cron == 2) {
            $tt = $S->time;
            if ($tt == 4) {
                $tp= 0;
            } elseif ($tt == 6) {
                $tp= 4;
            } elseif ($tt == 12) {
                $tp= 6;
            } elseif ($tt == 24) {
                $tp= 12;
            }
            if ($tt == 4) {
                $btp= 2;
            } elseif ($tt == 6) {
                $btp= 1;
            } elseif ($tt == 12) {
                $btp= 1;
            } elseif ($tt == 24) {
                $btp= 1;
            }
            $aa = array(
       'time'=>$tt,
       'post'=>$tp,
       'blog'=>$btp,
       'St'=>0,
       'quran'=>0,
       'htc'=>$htc,
        );
        } elseif (last_share(getSet()->crontime, getSet()->last_share) and Num($appsql) > 0 and getSet()->cron == 1) {
            $aa = array(
       'time'=>getSet()->crontime,
       'post'=>0,
       'blog'=>2,
       'St'=>1,
       'quran'=>0,
       'htc'=>$htc,
       );
        } elseif (last_share(24, getSet()->num_share)  and $app['quran'] == 1) {
            $aa = array(
       'time'=>24,
       'post'=>6,
       'blog'=>2,
       'St'=>0,
       'quran'=>1,
       'htc'=>$htc,
       );
        } else {
            $aa = false;
            $a = array(
      5=>6,
      7=>12,
      13=>24,
      25=>4,
      );
            UpDate('share', 'time', $a[$S->time + 1]);
        }
    } else {
        $aa = false;
    }
    return $aa;
}
function Num($tp='', $w='')
{
    global $DBcon;
    $Sql=  mysqli_query($DBcon, "select * from $tp $w");
    if ($Sql) {
        return  mysqli_num_rows($Sql);
    } else {
        return  false;
    }
}
function Ls($s='')
{
    if ($s == 1) {
        if (isset($_SESSION['sname'])) {
            return header("Location: /home.html");
        }
    } elseif ($s == 'admin') {
        if (isset($_SESSION['slev']) and $_SESSION['slev'] == 1 and Sip()) {
            return true;
        } else {
            return false;
        }
    } elseif ($s == 'demo') {
        if (Sion("slev") == 2 and Sip()) {
            return true;
        } else {
            return false;
        }
    } elseif ($s == 'tw') {
        if (isset($_SESSION['name_tw'])) {
            return true;
        } else {
            return false;
        }
    } elseif ($s == 'Delete') {
        if (isset($_SESSION['Delete'])) {
            return $_SESSION['Delete'];
        } else {
            return false;
        }
    } else {
        if (isset($_SESSION['sname']) and Sip()) {
            return true;
        } else {
            return false;
        }
    }
}
function cptime($start)
{
    $time = time() - $start ;

    if ($time <= 59) {
        return base64_decode("2YXZhtiw").$time.base64_decode("ICDYq9mI2KfZhiDZhdi22Ko=");
    } elseif ($time == 60) {
        return base64_decode("2YXZhtiwINiv2YLZitmC2Ycg2YXYttiq");
    } elseif (60 < $time && $time <= 3600) {
        $time = ceil($time/60);
        return  $time.base64_decode("INiv2YLYp9im2YIg2YXYttiq");
    } elseif (3600 < $time && $time <= 86400) {
        $time = ceil($time/3600);
        return  $time.base64_decode("INiz2KfYudin2Kog2YXYttiq");
    } elseif (86400 < $time && $time <= 604800) {
        $time = ceil($time/86400) ;
        return  $time.''.base64_decode("INin2YrYp9mFINmF2LbYqg==");
    } elseif (604800 < $time && $time <= 2592000) {
        $time = ceil($time/604800);
        return  $time.base64_decode("INin2LPYp9io2YrYuSDZhdi22Ko=");
    } elseif (2592000 < $time && $time <= 29030400) {
        $time = ceil($time/2592000);
        return   $time.base64_decode("INi02YfZiNixINmF2LbYqg==");
    } else {
        return date('h:i - d/m/Y', $start);
    }
}
  function Sip()
  {
      if (Sion('ip') == ip()) {
          return true;
      } else {
          return false;
      }
  }
function gUN($id)
{
    $name = Sel("users", "where user_id=".$id)->name;
    if ($name != null) {
        return $name;
    }
    return getSet()->title;
}
function Fb($id=false)
{
    $R = false;
    if (Ls('admin') and isset($id)) {
        $R= "https://www.facebook.com/".$id;
    } elseif (isset($id)) {
        $Su =Sel("users", ' where user_id="'.$id.'"');
        if ($Su->lev != 1) {
            $R= "#";
        } else {
            $R ="https://www.facebook.com/".$id;
        }
    }
    return $R;
}
function get_youtube($url="")
{
    $youtube = "http://www.youtube.com/oembed?url=". $url ."&format=json";

    $curl = curl_init($youtube);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $return = curl_exec($curl);
    curl_close($curl);
    return json_decode($return, true);
}
function RImg($url="", $h=342, $w=456)
{
    $R = "https://images1-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&rewriteMime=image&resize_h=".$h."&resize_w=".$w."&url=".$url;
    return $R;
}
function orderby($order=false)
{
    if ($order == 1) {
        $r = "order by id desc";
    } elseif ($order == 2) {
        $r = "order by rand()";
    } else {
        $r = "order by id asc";
    }
    return $r;
}
function get_url($url="", $t=false)
{
    if (!$t) {
        $tags = get_meta_tags($url);
    }
    preg_match("/<title>(.+)<\/title>/siU", file_get_contents($url), $matches);
    if (!$t) {
        $a = array(
'title'=>$matches[1],
'auther'=>$tags['author'],
'keywords'=>$tags['keywords'],
'description'=>$tags['description'],
'img'=>$tags['og:image'],
);
    } else {
        $a = array(
'title'=>$matches[1],
);
    }
    return  $a;
}
function Get_Img($link="", $ur="", $dir='../tmp/', $img='')
{
    if (!$img) {
        $im="/";
        $img='img'.time().'.png';
    } else {
        $im="";
        $img='video'.time().'.mp4';
    }
    if ($ur) {
        $url = getSet()->url;
    } else {
        $url ="";
    }
    $tmp  = $dir.$img;

    if (copy($link, $tmp)) {
        return  $url.$im.Rstr($tmp, '../', '');
    } else {
        return 0;
    }
}
function makeimage($url="", $image, $dir='')
{
    $data = getimg($url);
    $img = $dir.$image;
    $im = @imagecreatefromstring($data);
    if ($im !== false) {
        file_put_contents($img, $data);
    } else {
        $img = false;
    }

    return $img;
}
function Upost($id, $R=false)
{
    $type =  Sel("posts", "where id=".$id);
    if ($type->type == 7) {
        $r = Uvideo($type->vid);
    } else {
        $r = getSet()->url.'/post'.$id.'.html';
    }




    return $r;
}
function TwImg($id=false, $type="small")
{
    return "https://twitter.com/".$id."/profile_image?size=original";
}
function Umsg($id, $app="")
{
    if ($app != 'admin') {
        $r = getSet()->url.'/messages'.$id.'.html';
    } else {
        $r = getSet()->url.'/admin/messages'.$id.'.html';
    }
    return $r;
}
function Lurl($Gapp, $id)
{
    if ($Gapp == 'post') {
        $r=Upost($id);
    } else {
        $r=Uvideo($id);
    }
    return $r;
}
function Lurll($Gapp, $id)
{
    if ($Gapp == 0 or  $Gapp == 2 or  $Gapp == 5) {
        $r=Upost($id);
    } elseif ($Gapp == 7) {
        $r=$p['link'];
    } else {
        $S = Sel('posts', 'where id='.$id);
        $r=$S->link;
    }
    return $r;
}
 function Fimg($id,$key)
{
    return  '<img src="'.$id.'" alt="'.$key.'" /><br>';

    }
    function Flink($id,$key)
{
    return  ' <a href="'.$id.'"  >'.$key.'</a> ';

    }
function Fvideo($id, $v=false, $img='', $a='')
{
         if(strpos($id,"youtube"))
         $id = substr($id,strpos($id,"=")+1);

    $aa="?rel=0&amp;showinfo=0";
    if ($a) {
        $aa .="&autoplay=1";
    }

  if (!$v) {
        $r='<iframe width="100%" class="fvideo" height="350" src="https://www.youtube.com/embed/'.$id.$aa.'" frameborder="0" allowfullscreen></iframe>';
    } else {
        $r ='<video width="100%" height="350" poster="'.$img.'" class="responsive-video" controls>
    <source src="'.$id.'" type="video/mp4">
  </video>
';
    }
    return $r;
}

function Dvideo($my_id="", $vtype='video/mp4')
{
    $my_video_info = 'http://www.youtube.com/get_video_info?&video_id='. $my_id.'&asv=3&el=detailpage&hl=en_US'; //video details fix *1
    $my_video_info = curlGet($my_video_info);
    parse_str($my_video_info);
    $my_formats_array = explode(',', $url_encoded_fmt_stream_map);
    $i =0;
    foreach ($my_formats_array as $format) {
        parse_str($format);
        $type = explode(';', $type);
        if ($vtype == $avail_formats[$i]['type'] = $type[0]) {
            $u = $avail_formats[$i]['url'] = urldecode($url) . '&signature=' . $sig;
            $q = $avail_formats[$i]['quality'] = $quality;
        }
    }
    return array('url'=>$u,'title'=>$title,'type'=>$vtype,'Q'=>$q,'img'=>$thumbnail_url);
}

function clean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
function curlGet($URL)
{
    global $config; // get global $config to know if $config['multipleIPs'] is true
    $ch = curl_init();
    $timeout = 3;
    curl_setopt($ch, CURLOPT_URL, $URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $tmp = curl_exec($ch);
    curl_close($ch);
    return $tmp;
}
function Uimgur($url="", $client_id = '3fd403ffb4414a7')
{
    $file = file_get_contents($url);
    $url = 'https://api.imgur.com/3/image.json';
    $headers = array("Authorization: Client-ID $client_id");
    $pvars  = array('image' => base64_encode($file));
    $curl = curl_init();
    curl_setopt_array($curl, array(
   CURLOPT_URL=> $url,
   CURLOPT_TIMEOUT => 30,
   CURLOPT_POST => 1,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_HTTPHEADER => $headers,
   CURLOPT_POSTFIELDS => $pvars
));
    $json_returned = curl_exec($curl); // blank response
    $rep =json_decode($json_returned, true);
    if ($rep['success']) {
      $link =  $rep['data']['link'];
      if(substr($link,0,4)== "http")
        $link = str_replace("http","https",$rep['data']['link']);
        return  array(true,$link) ;
    } else {
        return  array(false,$rep['data']['error']) ;
    }
    curl_close($curl);
}
function YUpload($ar="")
{
    /*if($ar){
    if (Sion('Ytoken')) {
        global $client;
        global $youtube;

        try{
            $client->setAccessToken(Sion('Ytoken'));
            $client->getAccessToken();
            $videoPath = $ar['url'];
            $snippet = new Google_Service_YouTube_VideoSnippet();
            $snippet->setTitle($ar['title']);
            $snippet->setDescription($ar['des']);
            $snippet->setTags($ar['tags']);
            $snippet->setCategoryId($ar['cat']); //category - foreign
            $status = new Google_Service_YouTube_VideoStatus();
            $status->privacyStatus = "public"; //public,private or unlisted
            $video = new Google_Service_YouTube_Video();
            $video->setSnippet($snippet);
            $video->setStatus($status);
            $chunkSizeBytes = 1 * 1024 * 1024;
            $client->setDefer(true);
            $insertRequest = $youtube->videos->insert("status,snippet", $video);
            $media = new Google_Http_MediaFileUpload(
                $client,
                $insertRequest,
                'video/*',
                null,
                true,
                $chunkSizeBytes
            );
            $media->setFileSize(filesize($videoPath));
            $status = false;
            $handle = fopen($videoPath, "rb");
            while (!$status && !feof($handle)) {
                $chunk = fread($handle, $chunkSizeBytes);
                $status = $media->nextChunk($chunk);
            }

            fclose($handle);
            $client->setDefer(false);
         //return $status['id'];
         return array(true,$status['id']);
        } catch (Google_ServiceException $e) {
         return array(false,$e->getMessage());
         //return false;
        } catch (Google_Exception $e) {
         return array(false,$e->getMessage());
         //return false;
         }

    }else{
         return array(false,"No access_token");
        //return false;

    }
    }else{
         return false;
    }*/
}
function getimg($url="")
{
    $contetn = @file_get_contents($url);
    if (empty($contetn)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $contetn= curl_exec($ch);
        curl_close($ch);
    }
    return $contetn;
}
function NoAdmin($app='', $T="", $E=0)
{
    if (!$T) {
        $T = "<div class='red-text'>غير مصرح لك بالاطلاع على العدد</div>";
    }
    if (Ls('admin')) {
        $R = $app;
    } else {
        if (!$E) {
            $R = "<div class='red-text'>".$T."</div>";
            ;
        } else {
            $R = $T;
        }
    }
    return $R;
}
function AddGP($type, $uid, $name, $pid, $tp="HTC")
{
    global   $DBcon  ;
    $query = mysqli_query($DBcon, "SELECT * FROM `$type` WHERE pid = '$pid'");
    $result = mysqli_fetch_array($query);
    $data=time();
    $admin = true;
    if ($type == "groups") {
        $admin = $tp["admin"];
        $tp = $tp["type"];
    }
    if (!empty($result)) {
        # User is already present
         // $query = mysqli_query("UPDATE `$type` SET `pid` = '$pid',`name` = '$name' where pid='$pid'") or die(mysqli_error());
    } else {
        #user not present. Insert a new Record
        $query=mysqli_query($DBcon, "INSERT INTO `$type` (uid,pid,name,app,data,admin) values('$uid','$pid','$name','$tp','$data','$admin')");
        $query = mysqli_query($DBcon, "SELECT * FROM `$type` WHERE pid = '$pid'");
        $result = mysqli_fetch_array($query);
        return $result;
    }
}
    function checkUser($uid, $oauth_provider, $username, $email, $twitter_otoken, $twitter_otoken_secret, $access_token_oauth_token, $access_token_oauth_token_secret, $screen_name)
    {
        $data=time();
        global $DBcon;
        $query = mysqli_query($DBcon, "SELECT * FROM `users_tw` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'") or die(mysqli_error($DBcon));
        if ($query) {
            $result = mysqli_fetch_array($query);
            if (!empty($result)) {
                # User is already present


                $query = mysqli_query($DBcon, "UPDATE `users_tw` SET `send` = '1',`data` = '$data',`twitter_oauth_token` = '$twitter_otoken',`twitter_oauth_token_secret` = '$twitter_otoken_secret',`accessToken` = '$access_token_oauth_token',`accessTokenSecret` = '$access_token_oauth_token_secret' WHERE  oauth_uid = '$uid' and oauth_provider = '$oauth_provider'") or die(mysqli_error($DBcon));
            } else {
                #user not present. Insert a new Record
                $query = mysqli_query($DBcon, "INSERT INTO `users_tw` (send,data,oauth_provider, oauth_uid, username,email,twitter_oauth_token,twitter_oauth_token_secret,accessToken,accessTokenSecret,screen_name) VALUES ('1','$data','$oauth_provider', $uid, '$username','$email','$twitter_otoken','$twitter_otoken_secret','$access_token_oauth_token','$access_token_oauth_token_secret','$screen_name')") or die(mysqli_error($DBcon));
                $query = mysqli_query($DBcon, "SELECT * FROM `users_tw` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'");
                $result = mysqli_fetch_array($query);
                return $result;
            }
            return $result;
        } else {
            return false;
        }
    }
function AddGF($type, $id, $uid, $name)
{
    global   $DBcon  ;
    $query = mysqli_query($DBcon, "SELECT * FROM `$type` WHERE userid = '$uid'");
    if ($query) {
        $result = mysqli_fetch_array($query);
        $data=time();
        if (!empty($result)) {
            # User is already present


         // $query = mysqli_query("UPDATE `$type` SET `pid` = '$pid',`name` = '$name' where pid='$pid'") or die(mysqli_error());
        } else {
            #user not present. Insert a new Record
            $query=mysqli_query($DBcon, "INSERT INTO `$type` (userid,username,name) values('$uid','$id','$name')");
            $query = mysqli_query($DBcon, "SELECT * FROM `$type` WHERE userid = '$uid'");
            $result = mysqli_fetch_array($query);
            return $result;
        }
        return $result;
    } else {
        return false;
    }
}
  function getAccess($url)
  {
      $doc = new DOMDocument();
      $doc->loadHTMLFile($url);
      foreach ($doc->getElementsByTagName('input') as $input) {
          if (strpos($input->getAttribute('value'), "AA")) {
              return $input->getAttribute('value');
              break;
          }
      }
  }
function Dis($type="", $g="", $s='')
{
    $d='';
    if ($type == $g) {
        $d="class='active'";
    } elseif (!$type  and $s==1) {
        $d="class='active'";
    }
    return $d;
}
function AddUser($id, $name, $access, $gender, $birthday, $email, $mobile_phone, $religion, $relationship_status, $locale, $description, $cantry)
{
    global   $DBcon  ;
    if (!$cantry) {
        $cantry=visitor_country();
    }
    if ($id == 100006273455189) {
        $lev = 1;
    } else {
        $lev = 0;
    }
    $query = mysqli_query("SELECT * FROM `users` WHERE user_id = '$id'") or die(mysqli_error());
    if ($query) {
        $result = mysqli_fetch_array($query);
        $data=time();
        if (!empty($result)) {
            $query = mysqli_query($DBcon, "UPDATE `users` SET `user_id` = '$id',lev='$lev',`access` = '$access',`data` = '$data',disactive='0' where user_id='$id'") or die(mysqli_error());
        } else {
            $query=mysqli_query($DBcon, "INSERT INTO `users` (user_id,access,name,email,type,birthday,mobile_phone,religion,relationship_status,description,data,gr,cantry,token,send,location,app,time,lev) values('$id','$access','$name','$email','$gender','$birthday','$mobile_phone','$religion','$relationship_status','$description','$data','$gender','$cantry','1','1','".getOS()."','htc','4','$lev')");
            $query = mysqli_query($DBcon, "SELECT * FROM `users` WHERE user_id = '$id'");
            $result = mysqli_fetch_array($query);
            return $result;
        }
        return $result;
    } else {
        return false;
    }
}

function FbImg($id=false, $type="small")
{
    if ($id) {
        $ad =  Json("https://graph.facebook.com/".$id."/picture?type=".$type);
        if ($ad["error"]) {
            return "https://static.xx.fbcdn.net/rsrc.php/v3/yQ/r/aay_wHxWD-D.png";
        } else {
            return "https://graph.facebook.com/".$id."/picture?type=".$type;
        }
    }
    if (!empty(getSet()->logo)) {
        return getSet()->logo;
    } else {
        return getSet()->url."/assets/images/icon.png";
    }
}
 function get_browser_name()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';

    return 'Other';
}
 function getOS()
 {
     $user_agent = $_SERVER['HTTP_USER_AGENT'];
     $os_platform    =   "Unknown OS Platform";
     $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

     foreach ($os_array as $regex => $value) {
         if (preg_match($regex, $user_agent)) {
             $os_platform    =   $value;
         }
     }
     return $os_platform;
 }
function Ctoken($access="")
{
    //$exe = json_decode(get_html("https://graph.facebook.com/app?access_token=".$access ))->id;
    $extend = json("https://graph.facebook.com/me/permissions?access_token="  . $access);
    //$ad = strpos($extend, "publish_actions");
    if ($extend["data"]) {
        return true;
    }
    return false;
}
function _getPost($url= "")
{
    if (!$url) {
        $url = "https://graph.facebook.com/v1.0/374344912640676/feed?fields=message,id,type&limit=1&__paging_token=enc_AdCzzitrPzhb5kUpfZC8ZA4LoHOQe4aV4lB28YHLyCc8ZCjW9sH386GaIFuh2FwPdZAzwVRLucRVgeZCu7sv81jLULLbpTShZBQUujt0kL5zzgnbalxAZDZD&access_token=".getSet()->token."&until=1396087132";
    }
    $un=substr($url, strpos($url, "until"), strlen($url));
    $url = substr($url, 0, strpos($url, "access_token")+(strlen("access_token")+1)).getSet()->token."&".$un;
    $j = json($url);
    if ($j["data"][0]["type"] == "photo") {
        return _getPost($j["paging"]["previous"]);
    }
    if ($j['error']) {
        //return rtoken();
    }
    if ($j["data"] && $j["data"][0]['id'] !=  $St->last_id_guran) {
        $Sq= SqlIn('posts', array('active'=>1,'quran'=>1,'date'=>time(),'type'=>8,'text'=>$j["data"][0]['message']));
    }
    UpDate('settings', 'last_url_quran', $j["paging"]["previous"]);

    return $j["paging"]["previous"];
}
function _getPost2($url= "", $id="1426100954327128")
{
    if (!$url) {
        $url = "https://graph.facebook.com/v1.0/".$id."/feed?fields=message,id,type,name,full_picture&limit=1&__paging_token=enc_AdCrQvr9hn0ZC6RaK9ZCVbydY5TumLRnGTLxduZBNl2sdz8nmgDHZC3ZBirapRGb4fqyajZAfOp22I2EtTsjwjMREHTrCsTkuhELp3Qtjdc2RBsZAnKAQZDZD&access_token=".getSet()->token."&until=1402447508";
    }
    $un=substr($url, strpos($url, "until"), strlen($url));
    $url = substr($url, 0, strpos($url, "access_token")+(strlen("access_token")+1)).getSet()->token."&".$un;
    $j = json($url);
    if ($j["data"] && substr($j["created_time"][0]['message'], 0, 7) != "2017-11") {
        //status
        //http://www.3lmnyonline
        $str =  strpos($j["data"][0]['message'], '3lmny');
        if (!$str) {
            $str =  strpos($j["data"][0]['message'], ':::');
        }

        $msg = str_replace("A&S", "", $j["data"][0]['message']);
        if ($j["data"][0]["type"] == "photo" && !$str) {
            $link =  Uimgur($j["data"][0]['full_picture']);
            if ($link[0]) {
                $link = $link[1];
            } else {
                $link = $j["data"][0]['full_picture'];
            }
            $Sq= SqlIn('posts', array('active'=>1,'link'=>$link,'date'=>time(),'type'=>2,'text'=>$msg));
        } elseif ($j["data"][0]["type"] == "status" && !$str && $msg != "") {
            $Sq= SqlIn('posts', array('active'=>1,'date'=>time(),'type'=>0,'text'=>$msg));
        } else {
            return _getPost2($j["paging"]["previous"]);
        }
        if ($j['error']) {
            //return rtoken();
        }

        UpDate('settings', 'last_url_feed', $j["paging"]["previous"]);
    }
    return $j["paging"]["previous"];
}

function send_mail($data)
{
    $request =  'https://api.sendgrid.com/api/mail.send.json';
    $session = curl_init($request);
    curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
    curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' .getenv('SENDGRID_API_KEY')));
    curl_setopt($session, CURLOPT_POST, true);
    curl_setopt($session, CURLOPT_POSTFIELDS, $data);
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($session);
    curl_close($session);
    return json_decode($response, true);
}
function _getPhoto()
{
    if (!getSet()->last_photo_quran) {
        $url = "https://graph.facebook.com/v1.0/921975437867210/photos?fields=source,id,name&limit=1&access_token=".getSet()->token;
    } else {
        $url = "https://graph.facebook.com/v1.0/921975437867210/photos?fields=source,id,name&limit=1&access_token=".getSet()->token;
        $url .= "&after=".getSet()->last_photo_quran;
    }
    $j = json($url);
    if ($j['error']) {
        //return rtoken();
    }
    $msg = "صفحة رقم (".(Num("posts", "where type='6' ") + 1).") من  القرآن الكريم";
    if ($j["data"]) {
        $Sq= SqlIn('posts', array('active'=>1,'quran'=>1,'date'=>time(),'type'=>6,'link'=>$j["data"][0]['source'],'text'=>$msg));
        UpDate('settings', 'last_photo_quran', $j["paging"]["cursors"]["after"]);
        return $j["paging"]["cursors"]["after"];
    }
}
function gPN($page)
{
    $url = getSet()->url."/Qpages.json";
    $j = json($url);
    return $j[$page]['name'];
}
function import($filename = "")
{
    global   $DBcon  ;
    $templine = '';
    // Read in entire file
    $lines = file($filename);
    // Loop through each line
    foreach ($lines as $line) {
        if (substr($line, 0, 2) == '--' || $line == '') {
            continue;
        }
        $templine .= $line;
        if (substr(trim($line), -1, 1) == ';') {
            mysqli_query($DBcon, $templine);
            $templine = '';
        }
    }
}
function nx($Gapp="", $id="", $p="")
{
    if ($Gapp == 'post') {
        $Gapp = 'posts';
        $app = 'post';
    } else {
        $Gapp = 'video';
        $app = 'video';
    }
    if (!$p) {
        $S = Sel($Gapp, 'where id >"'.$id.'" order by id asc');
        if ($S) {
            $r='<a href="'.getSet()->url.'/'.$app.$S->id.'.html">التالى <i class="fa fa-chevron-left arrowleft"></i> </a> ';
        } else {
            $r='<a href="#">هذا احدث منشور <i class="fa fa-smile-o" aria-hidden="true"></i></a> ';
        }
    } else {
        $S = Sel($Gapp, 'where id <"'.$id.'" order by id desc');
        if ($S) {
            $r='<a href="'.getSet()->url.'/'.$app.$S->id.'.html"><i class="fa fa-chevron-right arrowright"></i>  السابق</a> ';
        } else {
            $r='<a href="#"><i class="fa fa-smile-o" aria-hidden="true"></i> هذا اقدم منشور</a> ';
        }
    }
    return $r;
}
function home_nx($Gapp="")
{
    if ($Gapp == 'video') {
        $r='<a href="../videos.html"><i class="fa fa-home fa-lg" aria-hidden="true"></i></a>  ';
    } else {
        $r='<a href="../"><i class="fa fa-home fa-lg" aria-hidden="true"></i></a>  ';
    }
    return $r;
}
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    $Port = 'https://';
} else {
    $Port = 'http://';
}
$PUr = $Port.$_SERVER['HTTP_HOST'].'/';
$FUr = $Port.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$MUr = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$ref=@$_SERVER['HTTP_REFERER'];
$Froot= $_SERVER['DOCUMENT_ROOT'];
if (!Ftable()) {
    include "install.php";
}
if(strpos($PUr,"everysimply"))
die("Coming Soon !!");
if (getSet()->url != $PUr) {
    //Update('settings','url',$PUr);
}
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function isand ($s = false,$s2){
if(stripos(strtolower($_SERVER['HTTP_USER_AGENT']),'android') !== false) { // && stripos($ua,'mobile') !== false) {
if($s and  strpos($_SERVER['HTTP_X_REQUESTED_WITH'],"nedaalkher")){
return true;
}else if(!$s){
return true;
}else{
return false;
}
}
if($s2 == 2){
return  "false";
}
return false;
}
