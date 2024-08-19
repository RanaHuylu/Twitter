<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchResults extends Component
{
    public $posts;
    public $users;

    public function __construct($posts, $users)
    {
        $this->posts = $posts;
        $this->users = $users;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.search-results');
    }
}
