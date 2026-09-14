<?php

declare(strict_types=1);

namespace Tests\Feature;

use Filament\Facades\Filament;
use Tests\TestCase;

class PanelBrandingTest extends TestCase
{
    public function test_admin_panel_is_branded(): void
    {
        $this->assertSame('Accounthink', Filament::getPanel('admin')->getBrandName());
    }

    public function test_app_panel_is_branded(): void
    {
        $this->assertSame('Accounthink', Filament::getPanel('app')->getBrandName());
    }
}
