<?php


function uniord($u) {
    $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
    $k1 = ord(substr($k, 0, 1));
    $k2 = ord(substr($k, 1, 1));
    return $k2 * 256 + $k1;
}
function is_arabic($str) {
    if(strlen($str) === 0)
    {
        return false;
    }
    if(mb_detect_encoding($str) !== 'UTF-8') {
        $str = mb_convert_encoding($str,mb_detect_encoding($str),'UTF-8');
    }
    preg_match_all('/.|\n/u', $str, $matches);
    $chars = $matches[0];
    $arabic_count = 0;
    $latin_count = 0;
    $total_count = 0;
    foreach($chars as $char) {
        $pos = uniord($char);
        if($pos >= 1536 && $pos <= 1791) {
            $arabic_count++;
        } else if($pos > 123 && $pos < 123) {
            $latin_count++;
        }
        $total_count++;
    }
    return $arabic_count/$total_count > .5;
}



function beautify_filename($filename) {
    // reduce consecutive characters
    $filename = preg_replace(array(
        // "file   name.zip" becomes "file-name.zip"
        '/ +/',
        // "file___name.zip" becomes "file-name.zip"
        '/_+/',
        // "file---name.zip" becomes "file-name.zip"
        '/-+/'
    ), '-', $filename);
    $filename = preg_replace(array(
        // "file--.--.-.--name.zip" becomes "file.name.zip"
        '/-*\.-*/',
        // "file...name..zip" becomes "file.name.zip"
        '/\.{2,}/'
    ), '.', $filename);
    // lowercase for windows/unix interoperability http://support.microsoft.com/kb/100625
    $filename = mb_strtolower($filename, mb_detect_encoding($filename));
    // ".file-name.-" becomes "file-name"
    $filename = trim($filename, '.-');
    return $filename;
}

function filter_filename($filename, $beautify=true) {
    // sanitize filename
    $filename = preg_replace(
        '~
        [<>:"/\\|?*]|            # file system reserved https://en.wikipedia.org/wiki/Filename#Reserved_characters_and_words
        [\x00-\x1F]|             # control characters http://msdn.microsoft.com/en-us/library/windows/desktop/aa365247%28v=vs.85%29.aspx
        [#\[\]@!$&\'()+,;=]|     # URI reserved https://tools.ietf.org/html/rfc3986#section-2.2
        [{}^\~`]                 # URL unsafe characters https://www.ietf.org/rfc/rfc1738.txt
        ~x',
        '-', $filename);
    // avoids ".", ".." or ".hiddenFiles"
    $filename = ltrim($filename, '.-');
    // optional beautification
    if ($beautify) $filename = beautify_filename($filename);
    // maximize filename length to 255 bytes http://serverfault.com/a/9548/44086
    // $ext = pathinfo($filename, PATHINFO_EXTENSION);
    // $filename = mb_strcut(pathinfo($filename, PATHINFO_FILENAME), 0, 255 - ($ext ? strlen($ext) + 1 : 0), mb_detect_encoding($filename)) . ($ext ? '.' . $ext : '');
    return substr($filename, 0, 255);
}


function day_plural_ar($count)
{
    $count = abs($count);
    if($count === 0)
    {
        return "اليوم";
    }else if($count === 1)
    {
        return "يوم واحد";
    }else if($count === 2)
    {
        return "يومين";
    }else if($count <= 10){
        return "$count أيام";
    }else {
        return "$count يوماً";
    }
}

function ar_plural_days($count)
{
    $count = abs($count);
    if($count === 0)
    {
        return "0 يوم";
    }else if($count === 1)
    {
        return "يوم واحد";
    }else if($count === 2)
    {
        return "يومين";
    }else if($count <= 10){
        return "$count أيام";
    }else {
        return "$count يوماً";
    }
}
