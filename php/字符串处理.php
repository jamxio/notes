<?php
/*
 * substr();和strlen();对utf的每个字符的长度都并不是1，
 * 例如每个utf-8bm4的都是3
 * 所以要用mb_substr();和mb_strlen();
 * 可是str_pad没有mb_*，应该怎么办
 */
echo substr('abcdef',2,3).PHP_EOL;
var_dump(substr('啊波次的额佛',2,3));
var_dump(substr('啊波次的额佛',3,3));
print(mb_substr('啊波次的额佛',2,3).PHP_EOL);
print_r(str_pad('我',5,'-').PHP_EOL);
print str_pad('wo',5,'-').PHP_EOL;

//solution
$mbStrPad = function ($input,$pad_length,$pad_string='*'){
    return str_repeat($pad_string,$pad_length-mb_strlen($input)).$input;
};
echo $mbStrPad('我','5','-').PHP_EOL;
echo $mbStrPad('wo','5','-');