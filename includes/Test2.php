<?php

namespace app\includes;

//use PHPUnit\Framework\TestCase;
use app\includes\Kamus;

//class Test2 extends TestCase
//class Test2
//{
//    public function main()
//    {
//        $kamus = new Kamus();
//        $kamus->tambah(‘big’, [‘large’, ‘great’]);
//        $kamus->tambah(‘big’, [‘huge’, ‘fat’]);
//        $kamus->tambah(‘huge’, [‘enormous’, ‘gigantic’]);
//
//        $kamus->ambilSinonim(‘big’);
//    }
//}
$kamus = new Kamus();
$kamus->tambah(‘big’, [‘large’, ‘great’]);
$kamus->tambah(‘big’, [‘huge’, ‘fat’]);
$kamus->tambah(‘huge’, [‘enormous’, ‘gigantic’]);

$kamus->ambilSinonim(‘big’);