<?php

function auth($user, $pass) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $data = array('accountType' => 'GOOGLE',
    'Email' => $user,
    'Passwd' => $pass,
    'source'=>'PHP Picasa Utility',
    'service'=>'lh2');

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $gvals = array();

    $ret = explode("\n",curl_exec($ch));
    curl_close($ch);

    foreach($ret as $item) {
        $flds = explode("=", $item);

        if(count($flds) > 1) {
            $gvals[$flds[0]] = $flds[1];
        }
    }

    $authHeader = 'Authorization:  GoogleLogin auth="' . $gvals['Auth'] . '"';

    return $authHeader;
}

function getAlbumIDs($rawXML) {
    if(!function_exists('parseEntry')) {
        function parseEntry($child) {
            $fields = explode('/', (string)$child->id);
            return array((string)$child->title, $fields[count($fields)-1]);
        }
    }

    $xml = new SimpleXMLElement($rawXML);

    $albums = array();
    if($xml->getName() == 'entry') {
        //We have a single entry element (like the return from createAlbum)
        list($title, $id) = parseEntry($xml);
        $albums[$title] = $id;
    }else {
        //We have an unknown number of albums (like the return from albumList
        foreach($xml->children() as $child) {
            if($child->getName() == 'entry') {
                list($title, $id) = parseEntry($child);
                $albums[$title] = $id;
            }
        }
    }

    return $albums;
}

function replaceEmptyWithSpace(&$arr, $key) {
    $arr[$key] = isset($arr[$key]) ? $arr[$key] : '';
}

function albumList($opts = '') {
    if(!is_array($opts)) {
        $opts = array(
            'auth-header'=> AUTH_HEADER,
            'feed-url'=> FEED_URL,
        );
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $opts['feed-url']);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $options = array(
                CURLOPT_SSL_VERIFYPEER=> false,
                CURLOPT_RETURNTRANSFER=> true,
                CURLOPT_HEADER=> false,
                CURLOPT_FOLLOWLOCATION=> true,
                CURLOPT_HTTPHEADER=> array('GData-Version:  2', $opts['auth-header'], 'Content-Type:  application/atom+xml')
            );
    curl_setopt_array($ch, $options);

    $ret = curl_exec($ch);
    curl_close($ch);

    //header('Content-type: text/plain');
    //echo $ret;

    return getAlbumIDs($ret);
}

function albumIDByName($find, $albums = '') {
    if(!is_array($albums)) {
        $albums = albumList();
    }

    foreach($albums as $name=>$id) {
        if($find == $name) {
            return $id;
        }
    }
}

function uploadImage($opts) {
    file_exists($opts['image']) || die("Could not locate file {$opts['image']}\n");

    if(!isset($opts['image-title'])) {
        $opts['image-title'] = $opts['image'];
    }
    if(!isset($opts['image-desc'])) {
        $opts['image-desc'] = '';
    }

    $rawImgXml = '<entry xmlns="http://www.w3.org/2005/Atom">
                  <title>' . $opts['image-title'] . '</title>
                  <summary>' . $opts['image-desc'] . '</summary>
                  <category scheme="http://schemas.google.com/g/2005#kind"
                    term="http://schemas.google.com/photos/2007#photo"/>
                </entry>';


    $fileSize = filesize($opts['image']);
    $fh = fopen($opts['image'], 'rb');
    $imgData = fread($fh, $fileSize);
    fclose($fh);

    $data = "";
    $data .= "\nMedia multipart posting\n";
    $data .= "--P4CpLdIHZpYqNn7\n";
    $data .= "Content-Type: application/atom+xml\n\n";
    $data .= $rawImgXml . "\n";
    $data .= "--P4CpLdIHZpYqNn7\n";
    $data .= "Content-Type: image/jpeg\n\n";
    $data .= $imgData . "\n";
    $data .= "--P4CpLdIHZpYqNn7--";

    $header = array('GData-Version:  2', $opts['auth-header'], 'Content-Type: multipart/related; boundary=P4CpLdIHZpYqNn7;', 'Content-Length: ' . strlen($data), 'MIME-version: 1.0');

    //This works for uploading an image WITHOUT metadata
    /*$header = array('GData-Version:  2', AUTH_HEADER, 'Content-Type: image/jpeg', 'Content-Length: ' . $fileSize, 'Slug: cute_baby_kitten.jpg');
    $data = $imgData;*/

    $ret = "";
    $albumUrl = "https://picasaweb.google.com/data/feed/api/user/default/albumid/{$opts['album-id']}";
    $ch  = curl_init($albumUrl);
    $options = array(
            CURLOPT_SSL_VERIFYPEER=> false,
            CURLOPT_POST=> true,
            CURLOPT_RETURNTRANSFER=> true,
            CURLOPT_HEADER=> true,
            CURLOPT_FOLLOWLOCATION=> true,
            CURLOPT_POSTFIELDS=> $data,
            CURLOPT_HTTPHEADER=> $header
        );
    curl_setopt_array($ch, $options);
    $ret = curl_exec($ch);
    curl_close($ch);

    //header('Content-type: text/plain');
    //echo "\n\nret=$ret\n\n";
    $rr = explode("\n", $ret);
    $nn = count($rr);
    $ll = @json_decode(@json_encode(simplexml_load_string($rr[$nn-1])),1);
    return $ll['content']['@attributes']['src']."\n";

    //echo "\n\n" . print_r($header,true);
    //echo "\n\n@\n$data";
}

function loadConfig($file='.htpicasa.conf') {
    //First look for the file in the default location
    //(A user specified location or the current directory)
    if(!file_exists($file)) {
        $pwuid = posix_getpwuid(getmyuid());
        //If we can't find it, check the user's home directory
        if(!file_exists($pwuid['dir'] . '/' . $file)) {
            die("The config file $file could not be found.\n");
        }
    }

    $config = array();
    $rawConfig = file_get_contents($file);
    $lines = explode("\n", $rawConfig);

    foreach($lines as $line) {
        $fields = explode("=", $line);
        if(count($fields) == 2) {
            $config[trim($fields[0])] = trim($fields[1]);
        }
    }

    return $config;
}

function saveImage($base64img,$upload_dir){
    $base64img = str_replace('data:image/png;base64,', '', $base64img);
    $data = base64_decode($base64img);
    $file = $upload_dir . "/" . uniqid() . '.png';
    file_put_contents($file, $data);
    return $file;
}



/************************************************************/

$config = loadConfig();
define('FEED_URL', "https://picasaweb.google.com/data/feed/api/user/default"); //"default" uses the userId of the authenticating user
define('AUTH_HEADER', auth($config['username'], $config['password']));
$albumIDs = array();

if (isset($_POST["uploaded_file"]) && substr($_POST["uploaded_file"], 0, 21) == 'data:image/png;base64')
    $file = saveImage(utf8_decode($_POST["uploaded_file"]),$config['upload_dir']);


    if(isset($config['album'])) {
        $albumID = albumIDByName($config['album']);
    }else {
        if(count($albumIDs) == 0 ) {
            die("Please specify an album to upload to.");
        }
        $albumID = reset($albumIDs);
    }
echo uploadImage(array(
    'auth-header'=> AUTH_HEADER,
    'album-id'=> $albumID,
    'image'=> $file));
    unlink($file);

?>
