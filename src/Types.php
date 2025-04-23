<?php

declare(strict_types=1);

namespace Workbunny\PJson;

use ArrayAccess;
use Countable;
use Error;
use FFI;
use FFI\CData;
use FFI\CType;
use Iterator;

class Types implements ArrayAccess, Iterator, Countable
{

    /**
     * 储存CData或PHP类型数据
     *  1. CData JSON_ARRAY
     *  2. CData JSON_OBJECT
     *  3. CData JSON_VALUE
     *  4. PHPData
     *
     * @var CData|null
     */
    protected ?CData $data;

    /**
     * CData类型
     *
     * @var Type|null
     */
    protected ?Type $type;

    /** @var int  */
    protected int $offset = 0;

    /** @var array<int, string>  */
    protected array $offsetMapping = [];

    /** @var int  */
    protected int $count = -1;

    /**
     * @param mixed $data
     * @throws Error
     */
    public function __construct(mixed $data = null)
    {
        $this->data = $this->p2c($data);
        $this->type = Type::tryFrom(PJson::json_value_get_type($this->data));
        if ($this->type === Type::err) {
            throw new Error('json value type error');
        }
    }

    /**
     * PHPData to CData
     *
     * @param mixed $data
     * @return CData
     */
    public function p2c(mixed $data): CData
    {
        if ($data instanceof CData) {
            return $data;
        }
        return match ($type = gettype($data)) {
            'NULL'      => PJson::json_value_init_null(),
            'string'    => PJson::json_value_init_string($data),
            'integer',
            'double'    => PJson::json_value_init_number((float)$data),
            'boolean'   => PJson::json_value_init_boolean($data),
            'array'     => call_user_func(function () use ($data) {
                // list
                if (array_is_list($data)){
                    $jsonArray = Pjson::json_value_get_array($jsonValue = PJson::json_value_init_array());
                    foreach ($data as $value) {
                        Pjson::json_array_append_value($jsonArray, $this->p2c($value));
                    }
                } else { // map
                    $jsonObject = Pjson::json_value_get_object($jsonValue = PJson::json_value_init_object());
                    foreach ($data as $key => $value) {
                        Pjson::json_object_set_value($jsonObject, (string)$key, $this->p2c($value));
                    }
                }
                return $jsonValue;
            }),
            'object'    => call_user_func(function () use ($data) {
                // 可迭代对象
                if (is_iterable($data)) {
                    $jsonObject = Pjson::json_value_get_object($jsonValue = PJson::json_value_init_object());
                    foreach ($data as $key => $value) {
                        Pjson::json_object_set_value($jsonObject, (string)$key, $this->p2c($value));
                    }
                    return $jsonValue;
                }
                // 其他
                return PJson::json_value_init_string("PHPData<object> {}");
            }),
            default     => PJson::json_value_init_string("PHPData<$type> {}"),
        };
    }

    /**
     * PHPData to CData
     *
     * @param CData $CData
     * @param CType|null $CType
     * @return CData
     */
    public function c2p(CData $CData, ?CType $CType = null): mixed
    {
        $CType = $CType ?: FFI::typeof($CData);
        return match ($CType->getKind()) {
            CType::TYPE_CHAR        => FFI::string($CData),
            CType::TYPE_POINTER     => call_user_func(function () use ($CData, $CType) {
                return $this->c2p($CData, $CType->getPointerType());
            }),
            CType::TYPE_ENUM        => $CType->getEnumKind(),
            CType::TYPE_VOID        => null,
            CType::TYPE_FUNC        => 'CData<function>{}',
//            CType::TYPE_ARRAY,
//            CType::TYPE_STRUCT, // todo
            default                 => $CData
        };
    }

    /**
     * @param bool $pretty
     * @return mixed
     */
    public function serialize(bool $pretty = false): mixed
    {
        return $this->c2p($pretty
            ? PJson::json_serialize_to_string_pretty($this->data)
            : PJson::json_serialize_to_string($this->data)
        );
    }

    /**
     * 获取数据类型
     *
     * @return Type|null
     */
    public function type(): ?Type
    {
        return $this->type;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return match ($this->type) {
            Type::obj => (bool)Pjson::json_object_has_value(PJson::json_value_get_object($this->data), $offset),
            Type::arr => ($offset !== null),
            default => ($offset === null and isset($this->data)),
        };
    }

    /**
     * @param mixed $offset
     * @return mixed|Types
     */
    public function offsetGet(mixed $offset): mixed
    {
        try {
            if (!$this->offsetExists($offset)) {
                $offset = is_null($offset) ? 'NULL' : $offset;
                throw new Error("Types type '{$this->type?->name}' not exists key '$offset'");
            }
            $result = match ($this->type) {
                // 对象:
                Type::obj => new Types(PJson::json_object_get_value(PJson::json_value_get_object($this->data), $offset)),
                // 数组:
                Type::arr => new Types(PJson::json_array_get_value(PJson::json_value_get_array($this->data), $offset)),

                Type::str   => PJson::json_value_get_string($this->data),
                Type::num   => PJson::json_value_get_number($this->data),
                Type::bool  => (bool)PJson::json_value_get_boolean($this->data),
                Type::null  => null,
                default     => throw new Error('Types error', -1),
            };
            if (
                ($result instanceof Types) and
                !in_array($result->type(), [Type::obj, Type::arr])
            ) {
                $result = $result->offsetGet(null);
            }
            return $result;
        } catch (Error $error) {
            throw $error;
        } catch (\Throwable $throwable) {
            throw new Error($throwable->getMessage(), $throwable->getCode(), $throwable);
        }
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        try {
            if ($this->offsetExists($offset)) {
                $this->offsetUnset($offset);
            }
            $value = $this->p2c($value);
            match ($this->type) {
                // 对象:
                Type::obj   => PJson::json_object_set_value(PJson::json_value_get_object($this->data), $offset, $value),
                // 数组:
                Type::arr   => PJson::json_array_append_value(PJson::json_value_get_array($this->data), $value),
                Type::err   => throw new Error('Types error', -1),
                default     => $this->data = $value,
            };
        } catch (Error $error) {
            throw $error;
        } catch (\Throwable $throwable) {
            throw new Error($throwable->getMessage(), $throwable->getCode(), $throwable);
        }
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        if (!$this->offsetExists($offset)) {
            $offset = is_null($offset) ? 'NULL' : $offset;
            throw new Error("Types type '{$this->type?->name}' not exists key '$offset'");
        }
        switch ($this->type) {
            case Type::obj:
                Pjson::json_object_remove(PJson::json_value_get_object($this->data), $offset);
                break;
            case Type::arr:
                Pjson::json_array_remove(PJson::json_value_get_array($this->data), $offset);
                break;
            default:
                $this->data = null;
                $this->type = null;
                break;
        }
    }

    /** @inheritdoc  */
    public function current(): mixed
    {
        if ($this->type === Type::obj) {
            $this->offsetMapping[$this->offset] ??= PJson::json_object_get_name(PJson::json_value_get_object($this->data), $this->offset);
            return $this->offsetGet($this->offsetMapping[$this->offset]);
        }
        return $this->offsetGet($this->offset);
    }

    /** @inheritdoc  */
    public function next(): void
    {
        $this->offset ++;
    }

    /** @inheritdoc  */
    public function key(): mixed
    {
        return match ($this->type) {
            Type::obj => ($this->offsetMapping[$this->offset] ??= PJson::json_object_get_name(PJson::json_value_get_object($this->data), $this->offset)),
            Type::arr => $this->offset,
            default   => null,
        };
    }

    /** @inheritdoc  */
    public function valid(): bool
    {
        return $this->count() > $this->offset;
    }

    /** @inheritdoc  */
    public function rewind(): void
    {
        $this->offset = 0;
    }

    /** @inheritdoc  */
    public function count(): int
    {
        if ($this->count < 0) {
            $this->count = match ($this->type) {
                Type::obj => PJson::json_object_get_count(PJson::json_value_get_object($this->data)),
                Type::arr => PJson::json_array_get_count(PJson::json_value_get_array($this->data)),
                default   => 0,
            };
        }
        return $this->count;
    }
}
