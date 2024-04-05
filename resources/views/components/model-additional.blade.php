
@props(['model', 'crud', 'new_line'])

<div class="model-additional">
                
    <h4>{{ __('Дополнительная информация') }}</h4>
    
    @php
        $new_line = $new_line ?? false;
        
        if ($new_line) echo '<div class="data">';

        foreach ($model->getAttributes() as $key => $val){
            
            $key_trans = trans('crud.'.$crud .'.attributes.'.$key);
            $val = $val ?? 'NULL';
            $val = $new_line ? '<p>'.$val.'</p>' : '<span>'.$val.'</span>';
            echo '<div class="attr">
                    <b>'.$key_trans.'</b>
                    '.$val.'
                </div>';
        }
        if ($new_line) echo '</div>';
    @endphp
</div>