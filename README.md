# sha256 resolver

これは教育目的（あるいは暖房）のためのプログラムです。

sha256のハッシュ値から、元の値（あるいはコリジョン値）を力技で求めます。

「SHA256を『戻す』のは現実的ではない」＆「短い入力ではSHA256であっても無力」

## requirement

GMP and other, please see head of code.

## how to use

```
# single(simple) version
$ time php sha256_resolve.php fb8e20fc2e4c3f248c60c39bd652f3c1347298bb977b8b4d5903b85055620603
# fork version
$ time php sha256_resolve_fork.php fb8e20fc2e4c3f248c60c39bd652f3c1347298bb977b8b4d5903b85055620603 8
```

## sample hash

```
$ php -a
Interactive shell

php > echo hash("sha256", "a");
ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb
php > echo hash("sha256", "ab");
fb8e20fc2e4c3f248c60c39bd652f3c1347298bb977b8b4d5903b85055620603
php > echo hash("sha256", "abc");
ba7816bf8f01cfea414140de5dae2223b00361a396177a9cb410ff61f20015ad
php > echo hash("sha256", "abcd");
88d4266fd4e6338d13b845fcf289579d209c897823b9217da3e161936f031589
php > echo hash("sha256", "abcde");
36bbe50ed96841d10443bcb670d6554f0a34b761be67ec9c4a8ad2c0c44ca42c
php > echo hash("sha256", "abcdef");
bef57ec7f53a6d40beb640a780a639c83bc29ac8a9816f1fc6c5c6dcd93c4721
php > echo hash("sha256", "abcdef1");
ac9f830ae6cf2299ba293dd4cec3be0d87a88e6a8fbfe5015de6fffd11d79b6e
```

## sample result

- Thinkpad X13 (AMD Ryzen 7 PRO 4750U) 16 worker. Linux + PHP 8.0.2 `a` => 0m0.102s
- Thinkpad X13 (AMD Ryzen 7 PRO 4750U) 16 worker. Linux + PHP 8.0.2 `ab` => 0m0.108s
- Thinkpad X13 (AMD Ryzen 7 PRO 4750U) 16 worker. Linux + PHP 8.0.2 `abc` => 0m0.124s
- Thinkpad X13 (AMD Ryzen 7 PRO 4750U) 16 worker. Linux + PHP 8.0.2 `abcd` => 0m0.529s
- Thinkpad X13 (AMD Ryzen 7 PRO 4750U) 16 worker. Linux + PHP 8.0.2 `abcde` => 0m7.334s
- Thinkpad X13 (AMD Ryzen 7 PRO 4750U) 16 worker. Linux + PHP 8.0.2 `abcdef` => 0m3.159s
- Thinkpad X13 (AMD Ryzen 7 PRO 4750U) 16 worker. Linux + PHP 8.0.2 `abcdef1` => 2m0.772s
- Mac mini 2018 (matsu) 16 worker. macOS catalina + PHP7.4.9 `abcdef` => 0m3.685s
- Mac mini 2018 (matsu) 16 worker. macOS catalina + PHP7.4.9 `abcdef1` => 2m28.340s
- Macbook Pro 2020 M1 8 worker. macOS Big Sur + PHP ([php-src:8ffc20](https://github.com/php/php-src/tree/8ffc20ace6c8a59b30aea53e2100aa26e4f1f3ee)) `abc` => 0m021s
- Macbook Pro 2020 M1 8 worker. macOS Big Sur + PHP ([php-src:8ffc20](https://github.com/php/php-src/tree/8ffc20ace6c8a59b30aea53e2100aa26e4f1f3ee)) `abcd` => 0m061s
- Macbook Pro 2020 M1 8 worker. macOS Big Sur + PHP ([php-src:8ffc20](https://github.com/php/php-src/tree/8ffc20ace6c8a59b30aea53e2100aa26e4f1f3ee)) `abcde` => 0m626s
- Macbook Pro 2020 M1 8 worker. macOS Big Sur + PHP ([php-src:8ffc20](https://github.com/php/php-src/tree/8ffc20ace6c8a59b30aea53e2100aa26e4f1f3ee)) `abcdef` => 0m14.065s
- Macbook Pro 2020 M1 8 worker. macOS Big Sur + PHP ([php-src:8ffc20](https://github.com/php/php-src/tree/8ffc20ace6c8a59b30aea53e2100aa26e4f1f3ee)) `abcdef1` => 3m17.91s
