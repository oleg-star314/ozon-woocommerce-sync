<?php
use PHPUnit\Framework\TestCase;
use OzonSync\Services\AttributeMapper;

require_once __DIR__ . '/../vendor/autoload.php';

class AttributeMapperTest extends TestCase
{
    public function testMapConvertsAttributes()
    {
        $json = file_get_contents(__DIR__ . '/fixtures/product_attributes.json');
        $data = json_decode($json, true);
        $mapper = new AttributeMapper();
        $mapped = $mapper->map($data['items']);
        $this->assertEquals(['Red'], $mapped['pa_color']);
        $this->assertEquals(['L'], $mapped['pa_size']);
    }
}
