<?php

// included files
include 'header.php';
include 'init_directory.php';
include 'directory_variables.php';
include 'file_actions.php';

// set current working directory or change it on folder click
if (!empty($_GET['dir'])) $dir = $_GET['dir'];
else $dir = $init_dir;
chdir($dir);

// breadcrumb navigation
$breadcrumb_menu = explode(DIRECTORY_SEPARATOR, getcwd());
$path_accum = '';
$is_home = false;

echo "<header>";
echo "<div class=\"breadcrumb-container\">";
echo "<table>";
echo "<tr>";
foreach ($breadcrumb_menu as $item) { // iterate over root directory
  $path_accum .= $item . DIRECTORY_SEPARATOR; // recursive path increment
  if ($item === $home_dir) {
    $is_home = true;
  }
  if ($is_home) {
    echo "<td><a href=\"?dir=$path_accum\" title=\"$path_accum\">$item</a></td>";
  }
}
echo "</tr>";
echo "</table>";
echo "</div>";
echo "</header>";

// current directory's content
echo "<main>";
echo "<div class=\"content-container\">";
echo "<form method=\"post\" enctype=\"application/x-www-form-urlencoded\">";

// get current directory's content
$cwd = scandir($dir);
// format url to open files
$url = str_replace(dirname(realpath(__DIR__)), $base_url, $dir);

echo "<table>";
// check current working directory
if (!is_dir($dir)) die ("Cannot open directory: $dir");
// iterate over current directory
foreach ($cwd as $file) {
  // format path to move through directories
  $path = $dir . DIRECTORY_SEPARATOR . $file;

  // skip '.', '..' and '.git'
  if ($file == '.' || $file == '..' || $file == '.git') continue;
  // check whether $file is a directory or a file
  if (is_dir($path)) {
    echo "<tr>";
    echo "<td>";
    echo '<i class="fa fa-folder-o"></i><a href="?dir='. urlencode($path) . '" title="' . $path .'">' . $file .'</a></td>';
    echo "<td><input type=\"checkbox\" name=\"selected\" value=\"$path\"></td>";
    echo "</tr>";
  } else {
    echo "<tr>";
    echo "<td><i class=\"fa fa-file\"></i><a class=\"file\" href=\"${url}/${file}\" title=\"${url}/${file}\">$file</a></td>";
    echo "<td><input type=\"checkbox\" name=\"selected\" value=\"$path\"></td>";
    echo "</tr>";
  }
}
echo "</table>";

// file actions form: create, copy, cut, paste and delete
echo "<input type=\"text\" name=\"create_file\" placeholder=\"file name\">";
echo "<button type=\"submit\" name=\"create\">create</button>";
echo "<button type=\"submit\" name=\"delete\">delete</button>";
echo "<button type=\"submit\" name=\"copy\">copy</button>";
echo "<button type=\"submit\" name=\"cut\">cut</button>";
echo "<button type=\"submit\" name=\"paste\">paste</button>";
echo "</form>";
echo "</div>"; // end div content-container
echo "</main>";

include 'footer.php';

?>
