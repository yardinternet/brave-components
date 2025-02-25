<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Component;
use Illuminate\View\View;

class PatternContent extends Component
{
    public string $patternContent = '';

    /**
     * Create a new component instance.
     */
    public function __construct(public string $slug = '')
    {
        $this->patternContent = $this->getPatternContent();
    }

    public function getPatternContent(): string
    {
        $pattern = new \WP_Query([
            'post_type' => 'wp_block',
            'name' => $this->slug,
        ]);

        if (! $pattern->have_posts()) {
            return '';
        }

        $post = $pattern->posts[0];

        return apply_filters('the_content', $post->post_content);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Factory|string
    {
        if(empty($this->patternContent)) {
            return '';
        }

        return view('brave::components.pattern-content');
    }
}
