<?php
// TTILE: SHA256 hash seed resolver without gmp (as a joke).
// AUTHOR: uzulla(Junichi ISHIDA) <zishida@gmail.com>
// LICENSE: MIT (https://opensource.org/licenses/MIT)
//
// ## requirement
// php>=7
//
// ## IMPORTANT
// The code will be overflow when $i value overflow PHP_INT_MAX. this is sample.
// php > echo dechex(PHP_INT_MAX);
// 7fffffffffffffff

if (!isset($argv[1])) die("please set target hash");
$hash = (string)$argv[1];

$i = 0;
while (hash('sha256', dechex($i)) !== $hash) {
  $i++;
}
echo "resolved!(?) result is `". dechex($i) ."`" . PHP_EOL;

