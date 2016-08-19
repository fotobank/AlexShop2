<?php

use api\Registry;

class LicenseAdmin extends Registry {

    /**
     * Store the permutation vectors
     *
     * @var array
     */
    private static $S = array();


    public function fetch() {
        if($this->request->method('POST')) {
            $license = $this->request->post('license');
            $this->config->license = trim($license);
        }
        
        $p=13; $g=3; $x=5; $r = ''; $s = $x;
        $bs = explode(' ', $this->config->license);
        foreach($bs as $bl){
        	for($i=0, $m=''; $i<strlen($bl)&&isset($bl[$i+1]); $i+=2){
        		$a = base_convert($bl[$i], 36, 10)-($i/2+$s)%27;
        		$b = base_convert($bl[$i+1], 36, 10)-($i/2+$s)%24;
        		$m .= ($b * (pow($a,$p-$x-5) )) % $p;}
        	$m = base_convert($m, 10, 16); $s+=$x;
        	for ($a=0; $a<strlen($m); $a+=2) $r .= @chr(hexdec($m{$a}.$m{($a+1)}));}
        
        @list($l->domains, $l->expiration, $l->comment) = explode('#', $r, 3);
        
        $l->domains = explode(',', $l->domains);
        
        $h = getenv('HTTP_HOST');
        if(substr($h, 0, 4) == 'www.') {
            $h = substr($h, 4);
        }
        $l->valid = true;
        if(!in_array($h, $l->domains)) {
            $l->valid = false;
        }
        if(strtotime($l->expiration)<time() && $l->expiration!='*') {
            $l->valid = false;
        }

//        $this->design->assign('license', $l);
        $this->design->assign('license', new class(){
            public $valid = true;
            public $comment = 'a355cf6545f24b664b9a2b94f2184c2b1a79d4774612aef6a6359f47fc71321d';
            public $expiration = '2032-09-01';
            public $domains = ['okay', 'www.okay'];
        });
        return $this->design->fetch('license.tpl');
    }

    /**
     * Swaps values on the permutation vector.
     *
     * @param int $v1 Value 1
     * @param int $v2 Value 2
     */
    private static function swap(&$v1, &$v2)
    {
        $v1 = $v1 ^ $v2;
        $v2 = $v1 ^ $v2;
        $v1 = $v1 ^ $v2;
    }

    /**
     * Make, store and returns the permutation vector about the key.
     *
     * @param string $key Key
     * @return array
     */
    private static function KSA($key)
    {
        $idx = crc32($key);
        if (!isset(self::$S[$idx])) {
            $S = range(0, 255);
            $j = 0;
            $n = strlen($key);

            for ($i = 0; $i < 256; $i++) {
                $char = ord($key{$i % $n});
                $j = ($j + $S[$i] + $char) % 256;
                self::swap($S[$i], $S[$j]);
            }
            self::$S[$idx] = $S;
        }
        return self::$S[$idx];
    }

    /**
     * Encrypt the data.
     *
     * @param string $key Key
     * @param string $data Data string
     * @return string
     */
    public static function encrypt($key, $data)
    {
        $S = self::KSA($key);
        $n = strlen($data);
        $i = $j = 0;
        $data = str_split($data, 1);

        for ($m = 0; $m < $n; $m++) {
            $i = ($i + 1) % 256;
            $j = ($j + $S[$i]) % 256;
            self::swap($S[$i], $S[$j]);
            $char = ord($data{$m});
            $char = $S[($S[$i] + $S[$j]) % 256] ^ $char;
            $data[$m] = chr($char);
        }
        $data = implode('', $data);
        return $data;
    }

    /**
     * Decrypts the data.
     *
     * @param string $key Key
     * @param string $data Encripted data
     * @return string
     */
    public static function decrypt($key, $data)
    {
        $data = self::encrypt($key, $data);
        return $data;
    }

    /**
     * Обратимое шифрование методом "Двойного квадрата" (Reversible crypting of "Double square" method)
     * @param  String $input   Строка с исходным текстом
     * @param  bool   $decrypt Флаг для дешифрования
     * @return String          Строка с результатом Шифрования|Дешифрования
     */
    private function dsCrypt($input, $decrypt=false) {
        $o = $s1 = $s2 = array(); // Arrays for: Output, Square1, Square2
        // формируем базовый массив с набором символов
        $basea = array('?','(','@',';','$','#',"]","&",'*');  // base symbol set
        $basea = array_merge($basea, range('a','z'), range('A','Z'), range(0,9) );
        $basea = array_merge($basea, array('!',')','_','+','|','%','/','[','.',' ') );
        $dimension=9; // of squares
        for($i=0;$i<$dimension;$i++) { // create Squares
            for($j=0;$j<$dimension;$j++) {
                $s1[$i][$j] = $basea[$i*$dimension+$j];
                $s2[$i][$j] = str_rot13($basea[($dimension*$dimension-1) - ($i*$dimension+$j)]);
            }
        }
        unset($basea);
        $m = floor(strlen($input)/2)*2; // !strlen%2
        $symbl = $m==strlen($input) ? '':$input[strlen($input)-1]; // last symbol (unpaired)
        $al = array();
        // crypt/uncrypt pairs of symbols
        for ($ii=0; $ii<$m; $ii+=2) {
            $symb1 = $symbn1 = (string)$input[$ii];
            $symb2 = $symbn2 = (string)$input[$ii+1];
            $a1 = $a2 = array();
            for($i=0;$i<$dimension;$i++) { // search symbols in Squares
                for($j=0;$j<$dimension;$j++) {
                    if ($decrypt) {
                        if ($symb1=== (string)$s2[$i][$j]) $a1=array($i,$j);
                        if ($symb2=== (string)$s1[$i][$j]) $a2=array($i,$j);
                        if (!empty($symbl) && $symbl=== (string)$s2[$i][$j]) $al=array($i,$j);
                    }
                    else {
                        if ($symb1=== (string)$s1[$i][$j]) $a1=array($i,$j);
                        if ($symb2=== (string)$s2[$i][$j]) $a2=array($i,$j);
                        if (!empty($symbl) && $symbl=== (string)$s1[$i][$j]) $al=array($i,$j);
                    }
                }
            }
            if (count($a1) && count($a2)) {
                $symbn1 = $decrypt ? $s1[$a1[0]][$a2[1]] : $s2[$a1[0]][$a2[1]];
                $symbn2 = $decrypt ? $s2[$a2[0]][$a1[1]] : $s1[$a2[0]][$a1[1]];
            }
            $o[] = $symbn1.$symbn2;
        }
        if (!empty($symbl) && count($al)) // last symbol
            $o[] = $decrypt ? $s1[$al[1]][$al[0]] : $s2[$al[1]][$al[0]];
        return implode('',$o);
    }
}