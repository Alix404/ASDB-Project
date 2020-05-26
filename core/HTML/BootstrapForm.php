<?php

namespace Core\HTML;

class BootstrapForm extends Form
{
    public function input($name, $label, $option = [])
    {
        $type = isset($option['type']) ? $option['type'] : 'text';
        $labelnorm = '<label for="' . $name . '">' . $label . '</label>';
        $required = isset($option["required"]) ? 'required' : '';
        if ($type === 'textarea') {
            $input = '<textarea class="form-control" id="' . $name . '" name="' . $name .  $required .'">' . $this->getValue($name) .'</textarea>';
        } elseif ($type === 'checkbox') {
            $labelcheck = '<label class="form-check-label" for="' . $name . '">' . $label . '</label>';
            $input = '<input type="checkbox" class="form-check-input" name="'. $name .'" id="' . $name . '"value="1" />';
            return $this->surround($input . $labelcheck, true);
        } else {
            $input = '<input class="form-control" id="' . $name . '" type="' . $type . '" name="' . $name . '" value="' . $this->getValue($name) . '"' . $required . ' />';
        }
        return $this->surround($labelnorm . $input);
    }

    protected function surround($html, $isCheckbox = false)
    {
        if ($isCheckbox) {
            return "<div class='form-check'>{$html}</div>";
        } else {
            return "<div class=\"form-group\">{$html}</div>";
        }
    }

    public function submit()
    {
        return $this->surround('<button type="submit" class="btn btn-primary">Envoyer</button>');
    }

    public function select($name, $label, $options)
    {

        $label = '<label>' . $label . '</label>';
        $input = '<select class="form-control" name="' . $name . '">';
        foreach ($options as $k => $v) {
            $attributes = '';
            if ($k == $this->getValue($name)) {
                $attributes = ' selected';
            }
            $input .= "<option value='$k' $attributes>$v</option>";
        }
        $input .= '</select>';
        return $this->surround($label . $input);
    }

    public function link($location, $linkMsg)
    {
        $location = "index.php?p=$location";
        $link = '<a class="form-link" href="' . $location . '">' . $linkMsg . '</a>';
        return $this->surround($link);
    }

}