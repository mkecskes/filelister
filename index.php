<?php
if (isset($_GET["dir"])) {
    $dir = $_GET["dir"];
    $path = $dir."/";
    $t = $dir." - ";
} else {
    $dir = ".";
    $path = "";
    $t = "";
}

if (file_exists($dir) && is_dir($dir)) {
    $c = "<ul>";
    $filenames = scandir($dir);
    if($dir != ".") {
        if(substr($dir, 0, strrpos($dir, "/"))) {
            $c .= "<li class = \"up\"><a href = \"?dir=" . substr($dir, 0, strrpos($dir, "/")) . "\">..</a></li>";
        } else {
            $c .= "<li class = \"up\"><a href = \".\">..</a></li>";
        }
    }

    $d = opendir($dir);

    while ($filename = readdir($d)) {
        if (is_dir($path . $filename) && $filename != "." && $filename != ".." && $filename != "style") {
            $c .= "<li class = \"dir\"><a href = \"?dir={$path}{$filename}\">{$filename}</a></li>";
        }
    }

    rewinddir($d);
    while ($filename = readdir($d)) {
        if (!is_dir($path . $filename) && ($path != "" || $filename != "index.php")) {
            $c .= "<li class = \"";
            $ext = strtolower(end(explode(".", $filename)));

            switch($ext) {
                case "pdf":
                case "ps":
                case "djvu": $c .= "fpdf"; break;
                case "doc":
                case "docx":
                case "rtf":
                case "odt": $c .= "fdoc"; break;
                case "xls":
                case "xlsx":
                case "ods": $c .= "fxls"; break;
                case "csv": $c .= "fcsv"; break;
                case "ppt":
                case "pps": $c .= "fppt"; break;
                case "gif":
                case "jpg":
                case "jpeg":
                case "png":
                case "tif":
                case "bmp":
                case "tiff":
                case "svg": $c .= "fimage"; break;
                case "txt": $c .= "ftext"; break;
                case "htm":
                case "html": $c .= "fhtml"; break;
                case "php": $c .= "fphp"; break;
                case "mp3":
                case "ogg":
                case "aac":
                case "m4a":
                case "flac":
                case "ape":
                case "wv":
                case "wav": $c .= "fsound"; break;
                case "m3u":
                case "pls": $c .= "fplaylist"; break;
                case "avi":
                case "mkv":
                case "mp4":
                case "m4v":
                case "mov": $c .= "fvideo"; break;
                case "zip":
                case "rar":
                case "gz":
                case "bz2":
                case "xz":
                case "tar":
                case "7z": $c .= "fcompr"; break;
                case "exe": $c .= "fexe"; break;
                case "bat":
                case "sh":
                case "js": $c .= "fscript"; break;
                case "apk": $c .= "fapk"; break;
                case "swf": $c .= "fflash"; break;
                default: $c .= "fdefault";
            }

            $fs = filesize($path . $filename);

            if($fs < 1024) {
                $fs = $fs . " B";
            } elseif ($fs < 1048576) {
                $fs = round($fs / 1024, 2) . " kB";
            } else {
                $fs = round($fs / 1048576, 2) . " MB";
            }

            $c .= "\"><a href = \"{$path}{$filename}\">{$filename} <span class = \"filesize\">{$fs}</span></a></li>";
        }
    }
    closedir($d);
    $c .= "</ul>";
}

else {
    $t = "No such directory - ";
    $c = "<p>No such directory.</p>";
}
$t .= "Simple file lister";
$c .= "<p id = \"footer\">Simple file lister by kmcs | <a href = \"http://p.yusukekamiyamane.com/\">Fugue Icons</a> by Yusuke Kamiyamane</p>";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title><?php echo $t; ?></title>
<link rel="stylesheet" href="style/main.css" />
<link rel="icon" type="image/png" href="style/folder.png" />
</head>
<body>
<?php echo $c; ?>
</body>
</html>
