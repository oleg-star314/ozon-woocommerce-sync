<?php
namespace OzonSync\Services;

class AttributeMapper
{
    public function map(array $ozonAttributes): array
    {
        $mapped = [];
        foreach ($ozonAttributes as $attr) {
            $slug = $this->slugify($attr['name'] ?? '');
            $value = $attr['value'] ?? null;
            if (empty($slug) || $value === null) {
                continue;
            }
            if (($attr['type'] ?? '') === 'dictionary' && is_array($value)) {
                $values = array_map(fn($v) => $v['value'] ?? '', $value);
            } elseif (is_array($value)) {
                $values = $value;
            } else {
                $values = [$value];
            }
            $mapped[$slug] = array_values(array_filter($values, fn($v) => $v !== ''));
        }
        return $mapped;
    }

    private function slugify(string $name): string
    {
        $slug = strtolower($name);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        return 'pa_' . trim($slug, '-');
    }
}
