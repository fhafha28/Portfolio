<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\HtmlString;
use Nette\Utils\Html;

class Alert extends Component
{
    public $id;
    public $type;
    public $dismissible;
    protected $types = [
        "success",
        "danger",
        "warning",
        "info"
    ];

    protected $classes = ['alert '];

    /**
     * Create a new component instance.
     */
    public function __construct($type = "info", $dismissible=false)
    {
        //선언하는 위치 중요함.
        $this->type = $this->validType($type);
        $this->classes[]="alert-{$this->type}";

        //컴포넌트에서 dismissible을 선언한 경우
        if($dismissible){
            $this->classes[] = " alert-dismissible fade show";
        }

        $this->dismissible=$dismissible;
    }

    protected function validType($type){
        return in_array($type, $this->types)? $type : 'info';
    }
    //class scope 내에서 필요하니까 protected로 변경

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }

    public function link($text, $target = '#'){
        return new HtmlString("<a href=\"{$target}\" class=\"alert-link\">{$text}</a>");
    }

    public function icon($url=null){
        $this->classes[]= ' d-flex align-items-center';
//        어레이의 값을 이 값으로 대체. icon 있는 경우 div의 정렬방식 정의

        $icon = $url ?? asset("icons/icon-{$this->type}.svg");
        return new HtmlString("<img class='me-2' src='{$icon}'");
    }

    public function getClasses(){
        return join("", $this->classes);
    }
    //icon이 없는 경우 pure하게 'alert '만 컴포넌트 블레이드에 붙을 것


}
