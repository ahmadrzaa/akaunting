<?php

namespace App\View\Components\Table;

use App\Abstracts\View\Component;

class Td extends Component
{
    public $class;

    public $override;

    public $kind;
    public $hiddenMobile;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $class = '', string $override = '', string $kind = '', bool $hiddenMobile = false,
    ) {
        $this->override = $this->getOverride($override);

        $this->kind = $kind;
        $this->hiddenMobile = $hiddenMobile;
        $this->class = $this->getClass($class);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.table.td');
    }

    protected function getOverride($override)
    {
        return explode(',', $override);
    }

    protected function getClass($class)
    {
        if (in_array('class', $this->override)) {
            return $class;
        }

        if ($this->hiddenMobile) {
            $class = $class . ' ' . 'hidden sm:table-cell';
        }

        $default = 'py-4 whitespace-nowrap text-sm font-normal text-black truncate';

        switch ($this->kind) {
            case 'amount':
                $default = $class . ' ltr:pl-6 rtl:pr-6 ltr:text-right rtl:text-left ' . $default;
                break;
            case 'right':
                $default = $class . ' ltr:pl-6 rtl:pr-6 ltr:text-right rtl:text-left ' . $default;
                break;
            case 'bulkaction':
                $default = $class . 'ltr:pr-6 rtl:pl-6 hidden sm:table-cell';
                break;
            case 'action':
                $default = 'p-0';
                break;
            case 'cursor-none':
                $default = $class . ' cursor-default ' . $default;
            break;
            default:
                $default = $class . ' ltr:pr-6 rtl:pl-6 ltr:text-left rtl:text-right cursor-pointer ' . $default;
        }

        return $default;
    }
}
