<?php

namespace Transformer\Tests;

use Transformer\Transformer;

function data ($data) {
    return new Transformer($data);
}

class TransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreation()
    {
        $transformer = data(array('param1' => 1));
        $this->assertTrue($transformer instanceof Transformer);
        $this->assertEquals(array('param1' => 1), $transformer->get());
    }

    public function testMap()
    {
        $transformer = data(array(
            array(
                'name' => 'linux',
                'created_by' => 'Linus Torvalds'
            ),
            array(
                'name' => 'mac os',
                'created_by' => 'apple inc'
            ),
            array(
                'name' => 'windows',
                'created_by' => 'microsoft'
            )
        ));

        $this->assertEquals(array('linux', 'mac os', 'windows'), $transformer->map(function ($item) {
            return $item['name'];
        })->get());
    }

    public function testFilter()
    {
        $transformer = data(array(
            array(
                'name' => 'linux',
                'created_by' => 'Linus Torvalds',
                'unix_like' => true,
            ),
            array(
                'name' => 'mac os',
                'created_by' => 'apple inc',
                'unix_like' => true
            ),
            array(
                'name' => 'windows',
                'created_by' => 'microsoft',
                'unix_like' => false,
            )
        ));

        $this->assertEquals(array('linux', 'mac os'), $transformer->filter(function($item) {
            return true == $item['unix_like'];
        })->map(function ($item) {
            return $item['name'];
        })->get());
    }

    public function testReduce()
    {
        $transformer = data(array(
            array(
                'name' => 'linux',
                'created_by' => 'Linus Torvalds',
                'unix_like' => true,
            ),
            array(
                'name' => 'mac os',
                'created_by' => 'apple inc',
                'unix_like' => true
            ),
            array(
                'name' => 'windows',
                'created_by' => 'microsoft',
                'unix_like' => false,
            )
        ));

        $this->assertEquals(array(
            'unix_like' => 2,
            'others' => 1,
            ), $transformer->reduce(function($summary, $item) {
            $summary[$item['unix_like'] ? 'unix_like' : 'others']++;
            return $summary;
        }, [
            'unix_like' => 0,
            'others' => 0,
        ])->get());
    }

    public function testPartition()
    {
        $transformer = data(array(
            array(
                'name' => 'ubuntu',
                'based' => 'linux',
            ),
            array(
                'name' => 'red hat',
                'based' => 'linux',
            ),
            array(
                'name' => 'windows 98',
                'based' => 'ms dos'
            )
        ));

        $this->assertEquals(array(
            'linux' => array(
                array(
                    'name' => 'ubuntu',
                    'based' => 'linux',
                ),
                array(
                    'name' => 'red hat',
                    'based' => 'linux',
                )
            ),
            'ms dos' => array(
                array(
                    'name' => 'windows 98',
                    'based' => 'ms dos'
                )
            ),
        ), $transformer->partition(function($item) {
            return $item['based'];
        })->get());
    }
}