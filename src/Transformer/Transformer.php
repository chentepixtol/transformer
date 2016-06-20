<?php

namespace Transformer;

class Transformer
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->data;
    }

    /**
     * @param callable $fn
     * @return Transformer
     */
    public function map(callable $fn)
    {
        return new static(array_map($fn, $this->data));
    }

    /**
     * @param callable $fn
     * @return Transformer
     */
    public function filter(callable $fn)
    {
        return new static(array_filter($this->data, $fn));
    }

    /**
     * @param callable $fn
     * @param mixed $accumulative
     * @return Transformer
     */
    public function reduce(callable $fn, $accumulative)
    {
        foreach ($this->data as $item) {
            $accumulative = $fn($accumulative, $item);
        }

        return new static($accumulative);
    }

    /**
     * @param callable $fn
     * @return Transformer
     */
    public function partition(callable $fn)
    {
        $partition = [];
        foreach ($this->data as $item) {
            $partition[$fn($item)][] = $item;
        }

        return new static($partition);
    }
}