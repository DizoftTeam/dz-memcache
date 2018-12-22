<?php
declare(strict_types=1);

namespace dz\memcache;

/**
 * Класс для работы с MemCache
 *
 * @package dz\memcache
 */
class MemCache extends \yii\caching\MemCache
{
    private $isCacheAvailable = true;

    /**
     * @param string $key
     * @return false|mixed
     */
    protected function getValue($key)
    {
        return $this->processedOnCache(function () use ($key) {
            return parent::getValue($key);
        }, false);
    }

    /**
     * @param array $keys
     * @return array|mixed
     */
    protected function getValues($keys)
    {
        return $this->processedOnCache(function () use ($keys) {
            return parent::getValues($keys);
        }, []);
    }

    protected function setValue($key, $value, $duration)
    {
        return $this->processedOnCache(function () use ($key, $value, $duration) {
            return parent::setValue($key, $value, $duration);
        }, false);
    }

    /**
     * @param array $data
     * @param int $duration
     * @return array|mixed
     */
    protected function setValues($data, $duration)
    {
        return $this->processedOnCache(function () use ($data, $duration) {
            return parent::setValues($data, $duration);
        }, []);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $duration
     * @return bool|mixed
     */
    protected function addValue($key, $value, $duration)
    {
        return $this->processedOnCache(function () use ($key, $value, $duration) {
            return parent::addValue($key, $value, $duration);
        }, false);
    }

    /**
     * @param string $key
     * @return bool|mixed
     */
    protected function deleteValue($key)
    {
        return $this->processedOnCache(function () use ($key) {
            return parent::deleteValue($key);
        }, false);
    }

    /**
     * @return bool|mixed
     */
    protected function flushValues()
    {
        return $this->processedOnCache(function () {
            return parent::flushValues();
        }, false);
    }


    /**
     * Выполняет действия над MemCache, переданные в $parentFunction
     * и ожидает возврата $defaultValue
     *
     * В случае неудачи вернет []|false (кэш не доступен)
     *
     * @param callable $parentFunction
     * @param $defaultValue
     * @return mixed
     */
    private function processedOnCache(callable $parentFunction, $defaultValue)
    {
        $result = $defaultValue;

        if ($this->isCacheAvailable) {
            try {
                $result = $parentFunction();
            } catch (\Exception $e) {
                $this->isCacheAvailable = false;
            }
        }

        return $result;
    }
}
