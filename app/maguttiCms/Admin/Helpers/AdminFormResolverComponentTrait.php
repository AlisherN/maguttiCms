<?php

namespace App\maguttiCms\Admin\Helpers;

use App\maguttiCms\Admin\AdminFormSelect;
use App\maguttiCms\Admin\Decorators\AdminForm\ViewComponent;
use App\maguttiCms\Admin\Facades\AdminFormImageRelation;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * Trait AdminListComponentTrait
 * @package App\maguttiCms\Admin\Decorators
 */
trait AdminFormResolverComponentTrait
{





    function renderComponent($value, $key,$field_properties,$locale){

        if (data_get($this->property, 'hidden') && $this->property['type'] != 'relation') {
            return  Form::hidden($key, $value, $field_properties);
        }

        if ($this->hasComponent($this->property['type'],$key)) {
            return  $this->makeComponent($key, $value, $locale, $field_properties);
        }
        if ($this->property['type'] == 'relation_image') {
            return  AdminFormImageRelation::setProperty($this->property)->get($key, $value);
        }
        if ($this->property['type'] == 'select' && is_array($this->property['select_data'])) {
            return AdminFormSelect::withOptions($this->property['select_data'])->withName($key)->withSelected($value ?: '')->render();
        }
    }





    /**
     * @param $type
     * @param $key
     * @return bool
     */
    function hasComponent($type, $key)
    {
        if ($this->componentHasView($type, $key)) return true;
        if ($this->componentClassExist($type)) return true;
        if ($this->relationComponentClassExist($type)) return true;
        return false;
    }


    /**
     * @param $key
     * @param $value
     * @param $locale
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function makeComponent($key, $value, $locale)
    {
        if ($this->componentClassExist($this->property['type'])) {
            $componentClassName = $this->resolveComponentClassNamespace($this->property['type']);
            return (new $componentClassName($this))->render($key, $value, $locale);
        }
        if ($this->relationComponentClassExist($this->property['type'])) {
            $componentClassName = $this->resolveRelationComponentClassNamespace($this->property['type']);
            return (new $componentClassName($this))->render($key, $value);
        }
        if ($this->componentHasView($this->property['type'], $key)) {
            return (new ViewComponent($this))->render($key, $value,$locale);
        }
        return false;
    }


    function resolveComponentClassNamespace($type)
    {
        return "App\maguttiCms\Admin\Decorators\AdminForm\\" . ucfirst(Str::camel($type)) . "Component";
    }

    function resolveRelationComponentClassNamespace($type)
    {
        return "App\maguttiCms\Admin\Decorators\AdminForm\\" . ucfirst(Str::camel($type)) . "SelectComponent";
    }

    function componentClassExist($type)
    {
        return class_exists($this->resolveComponentClassNamespace($type));
    }

    function relationComponentClassExist($type)
    {
        return class_exists($this->resolveRelationComponentClassNamespace($type));
    }

    function componentHasView($type, $key)
    {
        if (view()->exists('admin.inputs.' . $type)) return true;
        if (view()->exists('admin.inputs.' . $key)) return true;
        return false;
    }
}