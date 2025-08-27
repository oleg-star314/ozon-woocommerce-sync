<?php
namespace OzonSync\Repository;

class ProductRepository
{
    public function ensureProductBySKU(string $sku, ?string $ozonProductId): int
    {
        if (function_exists('wc_get_product_id_by_sku')) {
            $id = wc_get_product_id_by_sku($sku);
            if ($id) {
                return $id;
            }
        }
        return 0;
    }

    public function setAttributes(int $productId, array $attributes): void
    {
        if (function_exists('update_post_meta')) {
            update_post_meta($productId, '_product_attributes', $attributes);
        }
    }
}
