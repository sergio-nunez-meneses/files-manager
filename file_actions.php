<?php

// track current working directory
if (!empty($_GET['dir'])) {
  $cwd = $_GET['dir'];
} else {
  $cwd = getcwd();
}

// set trash path
$trash_path = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'recycle_bin' . DIRECTORY_SEPARATOR;

/* FILE ACTIONS */
// create
if (isset($_POST['create'])) {
  $create_file = $_POST['create_file'];
  if(strpos($create_file, '.') === false) {
    mkdir($cwd . DIRECTORY_SEPARATOR . $create_file, 0777);
  } else {
    fopen($cwd . DIRECTORY_SEPARATOR . $create_file, 'a+');
  }
}
// check selected file
if (isset($_POST['selected'])) {
  session_start(); // keep track of all variables even after page refreshes
  // delete
  if (isset($_POST['delete'])) {
    $delete_file = $_POST['selected'];
    if (!in_array($delete_file, scandir($trash_path))) {
      rename($delete_file, $trash_path . basename($delete_file));
    }
  } elseif (isset($_POST['copy'])) { // copy
    $copy_file = $_POST['selected'];
    $_SESSION['copy_file'] = 'C' . $copy_file; // prepend C
  } elseif (isset($_POST['cut'])) { // cut
    $_SESSION['copy_file'] = ''; // clear $_SESSION['copy_file'] variable
    $cut_file = $_POST['selected'];
    $_SESSION['cut_file'] = $cut_file;
    rename($_SESSION['cut_file'], $trash_path . basename($_SESSION['cut_file']));
    $_SESSION['cut_file'] = 'X' . $_SESSION['cut_file'];
  } elseif (isset($_POST['paste'])) { // paste
    $paste_file = $_POST['selected'];
    $_SESSION['paste_path'] = $paste_file;
    echo "<br>paste: " . $_SESSION['paste_path'];
    if (substr($_SESSION['copy_file'], 0, 1) === 'C') { // copy & paste
      copy(substr($_SESSION['copy_file'], 1), $_SESSION['paste_path'] . DIRECTORY_SEPARATOR . basename(substr($_SESSION['copy_file'], 1)));
    } elseif (substr($_SESSION['cut_file'], 0, 1) === 'X') { // cut & paste
      rename($trash_path . basename(substr($_SESSION['cut_file'], 1)), $_SESSION['paste_path'] . DIRECTORY_SEPARATOR . basename(substr($_SESSION['cut_file'], 1)));
    }
  }
}

?>
