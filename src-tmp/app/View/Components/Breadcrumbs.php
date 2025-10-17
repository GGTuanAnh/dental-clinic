<?php
namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Breadcrumbs extends Component
{
    /** @var array<int,array{label:string,url:?string,icon?:string}> */
    public array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function render(): View
    {
        return view('components.breadcrumbs');
    }
}
