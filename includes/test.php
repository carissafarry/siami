<?php
function
$kamus = new Kamus();
$kamus->tambah(‘big’, [‘large’, ‘great’]);
$kamus->tambah(‘big’, [‘huge’, ‘fat’]);
$kamus->tambah(‘huge’, [‘enormous’, ‘gigantic’]);

$kamus->ambilSinonim(‘big’);