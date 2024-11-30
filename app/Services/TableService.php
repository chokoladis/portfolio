<?php

namespace App\Services;

class TableService {

    public array $fieldsName;

    function __construct($model) {
        $this->fieldsName = $model->tableFields;
    }

    public function getTable($collection)
    {
//        todo check model
        $html = $this->getHead();
        $html .= $this->getBody($collection);

        return $html;
    }

    public function getHead()
    {
        $html = '<table class="uk-table"><thead><tr>';

        foreach ($this->fieldsName as $field) {
            $html .= '<th>'.$field.'</th>';
        }

        $html .= '</tr></thead>';

        return $html;
    }

    public function getBody($collection)
    {
        $html = '<tbody>';

        foreach ($collection as $item) {

            $html .= '<tr>';

            $attributes = $item->getAttributes();

            foreach ($attributes as $key => $value) {
                if (in_array($key, $this->fieldsName)) {
                    if (str_contains($key, '_src')){ //is_image
                        $html .= '<td><img src="'.$value.'"/></td>';
                    } else {
                        $html .= '<td>'.$value.'</td>';
                    }
                }
            }

            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }
}
