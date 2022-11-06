<?php
namespace App\Modules\Traits;

trait HaveAdminButtonsForms{
    public function ActivationForm($disableText ='Disable', $enableText = 'Enable'){
        $output = '';
        $output .= '<form action="'. $this->updateUrl() .'" style="display: inline;" method="post">';
        $output .= csrf_field();
        $output .= '<input type="hidden" name="_method" value="PUT">';
        $output .= '<input type="hidden" name="status" value="'.($this->status == 1 ? 0 : 1). '">';
        $output .= '<button type="submit" class="btn ';
        if($this->status){
            $output .= 'btn-warning';
        }else{
            $output .= 'btn-success';
        }
        $output .= '">';
        if($this->status){
            $output .= $disableText;
        }else{
            $output .= $enableText;
        }
        $output .= '</button>';
        $output .= '</form>';
        return $output;
    }

    public function deletionForm($text='Delete'){
        $output = '';
        $output .= '<form action="' . $this->deleteUrl() . '" style="display: inline;" method="post">';
        $output .= csrf_field();
        $output .= '<input type="hidden" name="_method" value="DELETE" />';
        $output .= '<button type="submit" class="btn btn-danger">';
        $output .= $text;
        $output .= '</button></form>';

        return $output;
    }
}
