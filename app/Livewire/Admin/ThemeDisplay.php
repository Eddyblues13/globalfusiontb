<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class ThemeDisplay extends Component
{
    public function render()
    {
        return view('livewire.admin.theme-display');
    }

    public function setTheme($theme)
    {

        Setting::where('id', '1')
            ->update([
                'website_theme' => $theme,
            ]);
    }
}
