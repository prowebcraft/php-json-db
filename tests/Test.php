<?php
/**
 * Created by PhpStorm.
 * User: Andrey Mistulov
 * Company: Aristos
 * Date: 19.06.2019
 * Time: 11:06
 */

use PHPUnit\Framework\TestCase;

class Test extends TestCase
{

    /**
     * Test general methods
     */
    public function testParams()
    {

        $data = [
            'car' => [
                'model' => 'X',
                'vendor' => 'Tesla',
                'hp' => '999',
                'features' => [
                    'abs', 'eps', 'cruise'
                ]
            ],
            'house' => [
                'city' => 'Moscow',
                'street' => 'Kremlin 1-1',
                'price' => '900000000'
            ],
            'girls' => null
        ];
        $db = new \Prowebcraft\JsonDb();
        $db->clear();
        $db->setData($data);
        $db->save();

        //Reload from file
        $db = new \Prowebcraft\JsonDb();

        $this->assertNull($db->get('foo.bar'));
        $this->assertEquals('default', $db->get('foo.bar', 'default'));
        $this->assertEquals('Moscow', $db->get('house.city'));
        $this->assertInternalType('array', $db->get('car.features'));

        $stack = [];
        $this->assertSame(0, count($stack));

        array_push($stack, 'foo');
        $this->assertSame('foo', $stack[count($stack)-1]);
        $this->assertSame(1, count($stack));

        $this->assertSame('foo', array_pop($stack));
        $this->assertSame(0, count($stack));
    }

}
