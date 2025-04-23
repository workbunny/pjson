<?php

declare(strict_types=1);

namespace Workbunny\PJson;

use ArrayAccess;
use Error;
use FFI;
use FFI\CData;
use FFI\CType;

class Types implements ArrayAccess
{

    /**
     * 储存CData或PHP类型数据
     *  1. CData JSON_ARRAY
     *  2. CData JSON_OBJECT
     *  3. CData JSON_VALUE
     *  4. PHPData
     *
     * @var mixed|null
     */
    protected mixed $data;

    /**
     * CData类型
     *
     * @var Type|null
     */
    protected ?Type $type;

    /**
     * @param mixed $data
     * @throws Error
     */
    public function __construct(mixed $data = null)
    {
        $data = $this->p2c($data);
        $this->type = Type::tryFrom(PJson::json_value_get_type($data));
        if ($this->type === Type::err) {
            throw new Error('json value type error');
        }
        $this->data = match ($this->type) {
            Type::obj   => Pjson::json_value_get_object($data),
            Type::arr   => Pjson::json_value_get_array($data),
            default     => $data
        };
    }

    /**
     * PHPData to CData
     *
     * @param mixed $data
     * @return CData
     */
    public function p2c(mixed $data): CData
    {
        return match ($type = gettype($data)) {
            'NULL'      => PJson::json_value_init_null(),
            'string'    => PJson::json_value_init_string($data),
            'integer',
            'double'    => PJson::json_value_init_number((float)$data),
            'boolean'   => PJson::json_value_init_boolean($data),
            'array'     => call_user_func(function () use ($data) {
                if (array_is_list($data)){
                    $jsonArray = Pjson::json_value_get_array($jsonValue = PJson::json_value_init_array());
                    foreach ($data as $value) {
                        Pjson::json_array_append_value($jsonArray, $this->p2c($value));
                    }
                    return $jsonValue;
                } else {
                    $jsonObject = Pjson::json_value_get_object($jsonValue = PJson::json_value_init_object());
                    foreach ($data as $key => $value) {
                        Pjson::json_object_set_value($jsonObject, (string)$key, $this->p2c($value));
                    }
                }
                return $jsonValue;
            }),
            'object'    => call_user_func(function () use ($data) {
                return ($data instanceof CData) ? $data : PJson::json_value_init_string("PHPData<object> {}");
            }),
            default     => PJson::json_value_init_string("PHPData<$type> {}"),
        };
    }

    /**
     * PHPData to CData
     *
     * @param mixed $data
     * @return CData
     */
    public function c2p(CData $data): mixed
    {
        return match (FFI::typeof($data)->getKind()) {
            CType::TYPE_CHAR,
            CType::TYPE_POINTER => FFI::string($data),
            default     => $data,
        };
    }

    /**
     * @return mixed
     */
    public function serialize(): mixed
    {
        return $this->c2p(PJson::json_serialize_to_string($this->data));
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
        switch ($this->type) {
            case Type::obj:
                return (bool)Pjson::json_object_has_value($this->data, $offset);
            case Type::arr:
                return true;
            default:
                if ($offset !== null) {
                    return false;
                }
                return isset($this->data);
        }
    }

    /**
     * @param mixed $offset
     * @return mixed|Types
     */
    public function offsetGet(mixed $offset): mixed
    {
        try {
            if (!$this->offsetExists($offset)) {
                throw new Error("Types type '{$this->type?->name}' not exists key '$offset'");
            }
            $result = match ($this->type) {
                // 对象:
                Type::obj => new Types(PJson::json_object_get_value($this->data, $offset)),
                // 数组:
                Type::arr => new Types(PJson::json_array_get_value($this->data, $offset)),

                Type::str   => PJson::json_value_get_string($this->data),
                Type::num   => PJson::json_value_get_number($this->data),
                Type::bool  => PJson::json_value_get_boolean($this->data),
                Type::null  => null,
                null        => $this->data,
                default     => throw new Error('Types error', -1),
            };
            if (
                $result instanceof Types and
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

    public function offsetSet(mixed $offset, mixed $value): void
    {
        try {
            if ($this->offsetExists($offset)) {
                $this->offsetUnset($offset);
            }
            switch ($this->type) {
                case Type::obj:

            }
            match ($this->type) {
                // PHPData
                null => call_user_func(function () use ($offset, $value) {
                    switch ($t = gettype($this->data)) {
                        case 'array':
                            $this->data[$offset] = $value;
                            break;
                        case 'object':
                            $this->data->$offset = $value;
                            break;
                        case 'string':
                            if (is_int($offset)) {
                                $this->data[] = $value;
                                break;
                            }
                            throw new Error("Types type 'PHPData->string' not exists key '$offset'", -1);
                        default:
                            throw new Error("Types type 'PHPData->$t' not exists key '$offset'", -1);
                    }
                }),
                // 对象:
                Type::obj => new Types(PJson::json_object_get_value($this->data, $offset)),
                // 数组:
                Type::arr => new Types(PJson::json_array_get_value($this->data, $offset)),

                Type::str   => PJson::json_value_get_string($this->data),
                Type::num   => PJson::json_value_get_number($this->data),
                Type::bool  => PJson::json_value_get_boolean($this->data),
                Type::null  => null,
                default     => throw new Error('Types error', -1),
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
            throw new Error("Types type '{$this->type?->name}' not exists key '$offset'");
        }
        switch ($this->type) {
            case Type::obj:

                Pjson::json_object_remove($this->data, $offset);
                break;
            case Type::arr:
                Pjson::json_array_remove($this->data, $offset);
                break;
            default:
                $this->data = null;
                break;
        }
    }
}
