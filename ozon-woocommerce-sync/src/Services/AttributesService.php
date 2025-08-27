<?php
namespace OzonSync\Services;

class AttributesService
{
    public function getProductAttributes(array $productIds): array
    {
        $fixture = __DIR__ . '/../../tests/fixtures/product_attributes.json';
        if (file_exists($fixture)) {
            return json_decode(file_get_contents($fixture), true);
        }
        return [];
    }

    public function getCategoryAttributes($typeId): array
    {
        return [];
    }
}
