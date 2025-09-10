<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardCard extends Component
{
    public $title;
    public $color;
    public $icon;

    public function __construct($title, $color = 'primary', $icon = '')
    {
        $this->title = $title;
        $this->color = $color;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.dashboard-card');
    }
}
