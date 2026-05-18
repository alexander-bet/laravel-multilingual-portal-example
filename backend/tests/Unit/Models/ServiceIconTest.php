<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Modules\Services\Models\Service;
use Tests\TestCase;

class ServiceIconTest extends TestCase
{
    public function test_icon_attribute_decodes_html_entities(): void
    {
        $service = new Service(['icon' => '&lt;svg&gt;&lt;/svg&gt;']);

        $this->assertSame('<svg></svg>', $service->icon);
    }

    public function test_icon_attribute_returns_null_when_value_is_null(): void
    {
        $service = new Service(['icon' => null]);

        $this->assertNull($service->icon);
    }

    public function test_icon_attribute_returns_null_for_empty_string(): void
    {
        $service = new Service(['icon' => '']);

        $this->assertNull($service->icon);
    }

    public function test_icon_attribute_returns_plain_svg_unchanged(): void
    {
        $svg     = '<svg xmlns="http://www.w3.org/2000/svg"><path d="M0 0"/></svg>';
        $service = new Service(['icon' => $svg]);

        $this->assertSame($svg, $service->icon);
    }

    public function test_icon_attribute_decodes_nested_html_entities(): void
    {
        $service = new Service(['icon' => '&lt;svg&gt;&lt;path d=&quot;M0 0&quot;/&gt;&lt;/svg&gt;']);

        $this->assertSame('<svg><path d="M0 0"/></svg>', $service->icon);
    }
}
