<?php

namespace Tests1Doc;

use Carbon\Carbon;
use Exception;
use Predis\Client as Redis;
use Ulid\Ulid;

class AdvancedTests
{
    private $carbon;
    private $prefix = 'bull';
    public $redis;

    public function __construct(
        Carbon $carbon
    ) {
        $this->carbon = $carbon;
    }

    public function returnNow(
        string $timeZone = 'America/Sao_Paulo'
    ): string {
        return $this->carbon->now($timeZone);
    }

    public function returnAge(
        string $year,
        string $month,
        string $day
    ) {
        if ($month < 1 || $month > 12) {
            throw new Exception('Mês incorreto. (1 ~ 12)');
        }

        if ($day < 1 || $day > 31) {
            throw new Exception('Dia incorreto. (1 ~ 31)');
        }

        return $this->carbon->createFromDate($year, $month, $day)->age;
    }

    public function biricutidoDay(
        string $year = '',
        string $month = '',
        string $day = ''
    ) {
        $date = $this->carbon->now();
        if (
            !empty($year) &&
            !empty($month) &&
            !empty($day)
        ) {
            $date = $this->carbon->createFromDate($year, $month, $day);
        }

        if ($date->isWeekend()) {
            return "Biricutico's Day";
        }

        return 'Não é dia de tomar uma... mas não vai acontecer nada que você não queira?';
    }

    public function getCredential(
        string $origin,
        string $service
    ): ?string {
        try {
            $redis = $this->validateConnection();
            return $redis->get("token-{$origin}-{$service}");
        } catch (Exception $e) {
            return null;
        }
    }

    public function setCredential(
        string $origin,
        string $service,
        string $credential
    ): bool {
        try {
            $redis = $this->validateConnection();
            $redis->set("token-{$origin}-{$service}", $credential);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delCredential(
        string $origin,
        string $service
    ): bool {
        try {
            $redis = $this->validateConnection();
            $redis->del("token-{$origin}-{$service}");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function addQueue(
        string $queue,
        array $data,
        array $opts = [],
        string $name = 'process'
    ): string {
        $redis = $this->validateConnection();

        $redis
            ->getProfile()
            ->defineCommand('addjob', 'BullPublisher\RedisAddCommand');

        $token = $this->newUlid()->generate();
        $keyPrefix = sprintf('%s:%s:', $this->prefix, $queue);

        $options = $this->configQueue($opts);

        $delay = 0;
        if (isset($opts['delay'])) {
            $delay = $options['timestamp'] + $options['delay'];
        }

        $priority = 0;
        if (isset($opts['priority'])) {
            $priority = intval($opts['priority']);
        }

        $lifo = 'LPUSH';
        if (isset($opts['lifo'])) {
            $lifo = 'RPUSH';
        }

        return $redis->addjob(
            $keyPrefix . 'wait',
            $keyPrefix . 'paused',
            $keyPrefix . 'meta-paused',
            $keyPrefix . 'id',
            $keyPrefix . 'delayed',
            $keyPrefix . 'priority',
            $keyPrefix,
            $options['jobId'],
            $name,
            json_encode($data),
            json_encode($options),
            $options['timestamp'],
            $options['delay'],
            $delay,
            $priority,
            $lifo,
            $token
        );
    }

    public function configQueue(
        array $config
    ): array {
        $defaultConfig = [
            'attempts' => 3,
            'backoff' => 30000,
            'delay' => 0,
            'removeOnComplete' => 100,
            'jobId' => $this->newUlid()->generate(),
            'timestamp' => $this->getTimestamp(),
        ];

        return array_merge($defaultConfig, $config);
    }

    public function validateConnection(): Redis
    {
        if ($this->redis) {
            return $this->redis;
        }

        return $this->connectRedis();
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTimestamp(): int
    {
        return round(microtime(true) * 1000);
    }

    /**
     * @codeCoverageIgnore
     */
    public function connectRedis(): Redis
    {
        $defaultConfig = [
            'scheme' => 'tcp',
            'host' => 'localhost',
            'port' => 6379,
        ];

        $this->redis = new Redis($defaultConfig);
        return $this->redis;
    }

    /**
     * @codeCoverageIgnore
     */
    public function newUlid(): Ulid
    {
        return new Ulid();
    }

    /**
     * @codeCoverageIgnore
     */
    public function getEnvValue($config): string
    {
        return new env($config);
    }
}
