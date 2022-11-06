<?php
namespace App\Http\Controllers;

set_time_limit(9999999999);

use Image;
use DB;

class GenerateController extends Controller
{
    public function index(){
        $loop = DB::table('media')->select('id','url')->where('url','not like','%tiny%')->get();
        //dd($loop);
        $sizes = [ 'tiny','small','medium','max' ];
        foreach( $loop as $img ){
            $ob = $img;
            $img = json_decode($img->url);
             $img = $img->uploaded;
             $img = str_replace('\\', '', $img);
             // $clearImg = explode('/', $img);
             // $clearImg = trim(end($clearImg));
             $output = array();
             foreach( $sizes as $size ){
                 $path = 'output/'.$size.'_'.$img;
                 if( file_exists($path) ){
                     $output[$size] = $size.'_'.$img;
                 }
                 
             }
            if( count($output) <= 0 ){
                file_put_contents('all.txt', $ob->id."\n", FILE_APPEND );
                continue;
            }
           $output = json_encode($output);

           $update = DB::table('media')->where('id', $ob->id)->update([ 'url' => $output ]);
            echo $update.'   :::  '.$ob->id.'<br/>';
        
        }

    }
    public function indexx(){

        $files = scandir('media');
        unset($files[0]); unset($files[1]);
        
        foreach( $files as $file ){
        $ext = explode('.', $file);
        $ext = trim(end($ext));
        if( !in_array($ext, ['jpg','png','gif']) ){
        
            echo $file."\n";
        }
        continue;
        $file = $filename = trim($file);
        $path = 'media/'.$file;
        if( !file_exists('output/tiny_'.$filename) ){
            dd($filename);
        }
        $sizes = [
            'tiny' => [100, 55],
            'small'=> [167, 106],
            'medium'=>[318, 235],
            'max'=>[750, 750]
        ];
        $sizes = array_reverse($sizes);
        $c = 0;
        $output = array();

        $image_resize = Image::make($path);
        if( $image_resize->width() > 750 ){
            $imgName = 'output/org_'.$filename;
            $image_resize->resize( $image_resize->width(), $image_resize->height() );
            $image_resize->save(public_path($imgName));
            $output['uploaded'] = $imgName;
        }
        foreach( $sizes as $key=>$size ){
            $image_resize = Image::make($path);

            if( $image_resize->width() < $size[0] ) continue;

            if( $key == 'tiny' || $key == 'samll' ){
                $image_resize->resize($size[0] , $size[1]);
            }else{

                $image_resize->resize($size[0] , null, function ($constraint) {
                    $constraint->aspectRatio();
                });
           }

            $imgName = 'output/' .$key.'_'.$filename;
            $output[$key] = $imgName;
            $image_resize->save($imgName);
            
            
            $c++;
        }

        $output = json_encode($output);
        file_put_contents('output.txt', trim($filename).' ::: '. $output."\n" );
        
        
        }

        die('done');






        /*
        $order = file_get_contents('order.txt');
        $new_order = $order + 1;
        file_put_contents('order.txt', $new_order);

        $loop = DB::table('media')->select('url')->get();
        
       foreach( $loop as $img ){

            $img = json_decode($img->url);
            $img = $img->uploaded;
            $img = str_replace('\\', '', $img);
            $clearImg = explode('/', $img);
            $clearImg = trim(end($clearImg));

            $ImgPath = "../wp-content/".$img;
            
            $mediaPath = "media/".$clearImg;

            copy($ImgPath, $mediaPath);
            
            sleep(2);
        }
*/

    }
}
