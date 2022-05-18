<?php

class Kamus
{
    protected $kata = [];

    public function tambah(string $kata, array $sinonim): void
    {
        if (isset($this->kata[$kata])) {
            $this->kata[$kata][] = $sinonim;
            return;
        }

        $this->kata[$kata] = $sinonim;
    }

    public function ambilSinonim(string $kata)
    {
        $result = 0;
        if (in_array($kata, array_keys($this->kata))) {
            return ($this->kata[$kata]);
        } else {
            foreach ($this->kata as $kata_element) {
                $kata_ditemukan = array_search($kata, $kata_element);
                if (!empty($kata_ditemukan)) {
                    $result = 1;
                    return $kata_ditemukan;
                }
            }
        }
        if ($result === 0) {
            print_r(null);
        }
    }
}

$kamus = new Kamus();
$kamus->tambah('big', ['large', 'great']);
$kamus->tambah('big', ['huge', 'fat']);
$kamus->tambah('huge', ['enormous', 'gigantic']);

print_r($kamus->ambilSinonim('big'));
print_r($kamus->ambilSinonim('huge'));
print_r($kamus->ambilSinonim('gigantic'));
print_r($kamus->ambilSinonim('colossal'));



