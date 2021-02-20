<?php
// TTILE: SHA256 hash seed resolver (as a joke) using fork.
// AUTHOR: uzulla(Junichi ISHIDA) <zishida@gmail.com>
// LICENSE: MIT (https://opensource.org/licenses/MIT)

// requirement:
// ext-pcntl, ext-shmop

// ex:
// $ time php ./sha256_resolve_fork_short.php 88d4266fd4e6338d13b845fcf289579d209c897823b9217da3e161936f031589 8

if (!isset($argv[1])) die("please set target hash");
$hash = (string)$argv[1];

if (!isset($argv[2])) die("please set worker num");
$worker_num = (int)$argv[2];

$round = 0;
$master_tick = 0;
$tick_window = 1000000; // try at once round.

$shm_key = ftok(__FILE__, 't');
$shm_id = shmop_open($shm_key, "c", 0644, 1024);
shmop_write($shm_id, add_null_byte_to_str((string)$master_tick), 0);
$pids = [];

while (true) {
  echo "round: {$round}" . PHP_EOL;

  for ($i = 0; $i < $worker_num; $i++) {
    $pid = pcntl_fork();
    if ($pid == -1)
      die('Could not fork');

    if ($pid) {
      $pids[] = $pid;
    } else {
      $child_tick = readNumFromShm($shm_id);
      $child_tick_max = $child_tick + $tick_window;
      writeNumToShm($shm_id, $child_tick_max);
      echo "{$child_tick} to {$child_tick_max}" . PHP_EOL;

      while ($child_tick <= $child_tick_max) {
        if (hash('sha256', dechex($child_tick)) === $hash) {
          echo "resolved! result is `".dechex($child_tick)."`" . PHP_EOL;
          exit(0);
        }
        $child_tick++;
      }
      exit(-1);
    }
  }

  foreach ($pids as $idx => $pid) {
    $res = pcntl_waitpid($pid, $status);
    if (pcntl_wifexited($status)) {
      unset($pids[$idx]);
      $status = pcntl_wexitstatus($status);
      if ($status == 0) {
        exit; // FINISH!!!
      }
    }
    usleep(10);
  }

  $round++;
  echo $round . PHP_EOL;
}

function str_from_mem(&$value):string
{
  // cut after null-byte.
  $i = strpos($value, "\0");
  if ($i === false) {
    return $value;
  }
  $result =  substr($value, 0, $i);
  return $result;
}

function add_null_byte_to_str($value)
{
  // add nullbyte
  return "$value\0";
}

function writeNumToShm($shm_id, $num)
{
  shmop_write($shm_id, add_null_byte_to_str((string)$num), 0);
}

function readNumFromShm($shm_id)
{
  return (int)(shmop_read($shm_id, 0, 1024));
}
