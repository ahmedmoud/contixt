<?php


namespace App\Modules\Facades\Http;

class Http
{
    public function GenerateSlug($model='null', $text, $slugColumn ='slug')
    {
        $slug = str_replace(' ', '-', $text);
        $slugExists = $model::where($slugColumn, $slug)->count();
        if ($slugExists) {
            $slugExists = $model::where($slugColumn, 'REGEXP', $slug.'\-\d+')->orderBy('created_at', 'DESC')->first();
            if ($slugExists) {
                $ExistingSlug = explode('-', $slugExists->slug);
                $lastNumber = $ExistingSlug[count($ExistingSlug) - 1] + 1;
                $slug = $slug . '-'. $lastNumber;
                return $slug;
            } else {
                $slug = $slug . '-'. 1;
                return $slug;
            }
        } else {
            return $slug;
        }
    }

    /**
     * Extract Variables from Link using Laravel Routing Variable Stamp
     * @param string $link Link To Extract the variable from
     * @param string|array|object $val The Value of Variable
     * @param integer $type 1 for Get the Full Final Link 2 for Get The Variable name
     * @return string|array
     */
    public function ExtractLinkVars($link, $val=null, $type=1)
    {
        @preg_match_all('/{(\w+)\??}/', $link, $match);
        if ($type == 1) {
            if (is_string($val)) {
                $vals = [];
                foreach($match[0] as $key => $value) {
                    $vals[] = $match[0][$key];
                }
                return @str_replace($vals, $val, $link);
            } else {
                $old = [];
                $new = [];
                foreach($match[0] as $key => $value){
                    $old[] = $match[0][$key];
                    $new[] = $val[$match[1][$key]];
                }
                return @str_replace($old, $new, $link);

            }
        } else {
            return @$match[1] ?? $match;
            // return $match;
        }
    }
}
