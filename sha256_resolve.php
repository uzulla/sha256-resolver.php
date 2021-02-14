<?php
// TTILE: SHA256 hash seed resolver (as a joke).
// AUTHOR: uzulla(Junichi ISHIDA) <zishida@gmail.com>
// LICENSE: MIT (https://opensource.org/licenses/MIT)
//
// ## requirement
// php>=7, need GMP extention
//
// ## how to use
// $ php sha256_seed_resolver.php fb8e20fc2e4c3f248c60c39bd652f3c1347298bb977b8b4d5903b85055620603
//
// sample hash:
// 1 => 6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b
// ab => fb8e20fc2e4c3f248c60c39bd652f3c1347298bb977b8b4d5903b85055620603
//
// also, generate your hash.
// ```
// <?php
// echo hash("sha256", "abcdef1");
// ```
//
// ## speed
// speed example @ mac mini (Core i7-8700B CPU @ 3.20GHz) + php7.4.9:
// `abcd` (4 chars) => 0.2 sec
// `abcde` (5 chars) => 2.6 sec
// `abcdef` (6 chars) => 41.3 sec
// `abcdef1` (7 chars) => 557 sec

if (!isset($argv[1])) die("please set target hash");
$hash = (string)$argv[1];

$i = gmp_init(0);
while (true) {
  $input = ltrim(bin2hex(gmp_export($i)), "0");
  if (hash('sha256', $input) === $hash) {
    echo "resolved! result is `{$input}`" . PHP_EOL;
    break;
  }
  $i = gmp_add($i, 1);
}
