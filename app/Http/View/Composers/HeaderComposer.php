<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view)
    {
        $view->with('title', 'Judul Halaman');
    }
}