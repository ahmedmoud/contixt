<?php
namespace App\Modules\SEOAgent;


class SEOAgent
{
    // public $text, $title, $keyword;
    private $the_type = false;
    public function fetchReport($post, $count = false ){
       
        $output = $this->analyse($post);

        if( $count ){ 
            $problems = 0;
            $flattened = array_flatten($output);
            foreach( $flattened as $fl ){
                if( $fl ){
                    $problems++;
                }
            }
            return $problems;
        }

        $out = '';
        $before = '<li>';
        $after = '</li>';
        
        foreach( $output as $state ){
            if( !$state ) continue; 
            if( is_array($state) ){
                foreach( $state as $stat ){  $out .= $before.$stat.$after; }
            }else{
                $out .= $before.$state.$after;
            }
        }
        if( !$out ) return false;
       return '<ul>'.$out.'</ul>';
    }

    private function analyse( $post ){

        $this->the_type = $post->type;

        if( !$post->focuskw ){  return ['الكلمة الاساسية غير موجودة']; }
        $this->text = $post->content;
        $this->title = $post->title;

        $this->keyword = str_replace('-', ' ', urldecode($post->focuskw) );
        $this->metaDesc = $post->excerpt;

        $output = Collect();
        $output->kwDenisty = $this->kwDenisty();
        $countText = $this->countText();
        if( $countText ){ $output->countText = $countText; }
        $output->title = $this->Title();
    
        $output->metaDesc  = $this->metaDes();
        $output->images    = $this->Images();
        $output->headings  = $this->Headings();
        $output->OutboundLinks   = $this->ahrefs();

        $output =  (array)$output;
        return $output;

    }


    private function getHTML(){
        $html =  str_get_html( $this->text );
        return $html;
        
    }

    public function ahrefs(){
        $html = $this->getHTML();
        $internals = $outers = 0;
        $msg = [];
        if( $html && $html->find('a') ){
            foreach( $html->find('a') as $key=>$a ){
                $href = $a->href;
                $href = trim($href);
                if( $a->href && $href && !empty($href) ){
                if( strpos(strtolower($href), 'setaat.com') !== false ){ 
                    $internals++;
                }else{
                    if( $a->rel ){
                        $type = strtolower($a->rel) == 'dofollow' ? 'dofollow' : 'nofollow';
                    }else{
                        $type = 'dofollow';
                    }
                    if( $type == 'dofollow' ){
                        $msg[] = " رابط خارجي : $a->plaintext <br/> الرابط: $a->href ";
                    }
                    $outers++;
                }
            }
            }
        }
        if( $internals < 2 ){
$msg[] = 'الروابط الداخلية أقل من 2 ، الحالي: '.$internals;
}
      
        return count($msg) > 0 ? implode('<br/>', $msg) : '';

    }

    private function Headings(){
        $html = $this->getHTML();
        $m = 0; $n = 0; $msg = [];
        if( $html && $html->find('h2,h3,h4') ){
        foreach( $html->find('h2,h3,h4') as $s){
            $txt = $s->plaintext;
            if( !str_contains($txt, $this->keyword ) ){ $m++; }else{ $n++; }
        }
        }

        if( !$n || $n < 1 ){ return 'لم يتم استخدام الكلمة الاساسية في اي من العناوين مثل h2'; }
        return false;
    }
    private function Title(){
        if( !str_contains( $this->title, $this->keyword ) ){
            return 'الكلمة الاساسية لم يتم استخدمها في العنوان';
        }
        return false;
    }

    private function paragraph(){
        $html = $this->getHTML();
        $p = $html->find('p');
        return $p;
    }

    private function firstParagraph(){
        $p = $this->paragraph();
        if( !$p ) return 'المحتوى لا يحتوى على وسوم براجراف p';

        if( $p[0] ){
            $p = $p[0];
            if( !str_contains( $this->title, $this->keyword ) ){
                return 'الكلمة الاساسية لم يتم استخدمها في اول براجراف p';
            }
            return true;
        }
        return 'المحتوى لا يحتوى على وسوم براجراف p';
    }

    private function Images(){ 

        $msg = [];
        $html = $this->getHTML();
        $s = 0;
        if( $html && $html->find('img') ){
            foreach( $html->find('img') as $key=>$img ){
                if( $this->the_type == 'post' && ( !$img->alt || empty($img->alt) ) ){
                    $msg[] = 'الصورة '.++$key.' : لا تحتوى على ALT. ';
                }elseif( str_contains( $img->alt, $this->keyword ) ){
                    $s++;
                }
                
                
            }
        }
        if( $s == 0  && $this->the_type == 'post' ){
            $msg[] = ' ALT للصورة  : لا يحتوي على الكلمة الاساسية';
        }
        return $msg;
    }

    private function countText(){
        $count = $this->TextLength();
        return  $count < 150 ? 'لا يجب ان يقل المحتوى عن 200 كلمة ، الحالي '.$count : false;
    }
    public function TextLength($text = false ){
        
        $text = $text ? $text : $this->text;
        $text = strip_tags($text);
        $text = str_replace("\n", ' ', $text );
        $text = str_replace("\r", ' ', $text );
        $text = str_replace("&nbsp;", ' ', $text);
        $text = html_entity_decode($text);
        $text = str_replace(".", ' ', $text );
        $text = str_replace("،", ' ', $text );
        $text = preg_replace('!\s+!', ' ', $text );
        $text = trim($text);
        $text = explode(' ', $text);
        $text = array_map('trim',$text);
        $text = array_filter($text);
        
        $count = count($text);
        return $count;
    }
    private function countTitle(){
        $text = preg_replace('!\s+!', ' ', $this->title);
        return strlen($text);
    }

    private function txtCheck($text){
        $text = trim($text);
        $text = preg_replace('!\s+!', ' ', $text );
        if( empty($text) ) return false;
        return strlen( $text );
    }
    private function txtLength($text){
        $text = trim($text);
        $text = preg_replace('!\s+!', ' ', $text );
        if( empty($text) ) return false;
        $text = explode(' ', $text);
        return count( $text );
    }

    private function metaDes(){
        $length = $this->txtCheck( $this->metaDesc ) / 2;
        $metaDescriptionLengthMin = 150;
        $metaDescriptionLengthMax = 300;
        $msg = [];
        if( !str_contains($this->metaDesc, $this->keyword) ){
            $msg[] = 'الكلمة الاساسية غير موجوده في الوصف القصير.';
        }
        if( $length < $metaDescriptionLengthMin ){
            $diff = $metaDescriptionLengthMin - $length;
            $msg[] = 'الوصف القصير لا يجب أن يقل عن '.$metaDescriptionLengthMin.' حرف ، باقي لك '.$diff.' حرف.';
        }elseif( $length > $metaDescriptionLengthMax ){
            $msg[] = 'الوصف القصير لا يجب ان يزيد عن '.$metaDescriptionLengthMax.' ، الحالي '.$length;
        }
        return count($msg) > 0 ? $msg : false;
    }

    private function kwDenisty(){
        $word_count = $this->TextLength();
        $keyword = $this->keyword;
        $keyword_count = preg_match_all("#{$keyword}#si", $this->text , $matches);
        //$keyword_count = count($matches);
        $word_count = $word_count == 0 ? 1 : $word_count;
        $density = $keyword_count / $word_count * 1000;
        $density = number_format($density, 5);
   

        return $density < 0.005 ? 'كثافة الكلمة الاساسية لا يجب ان تقل عن 0.5 %، الحالي '.number_format($density, 2 ).'للالف'." - عدد الكلمات $keyword_count" : false;    }

}