<?PHP

namespace App\Modules\Ads\Facade;

class Ads extends \Illuminate\Support\Facades\Facade
{
    
    public static function getFacadeAccessor(){
        return 'ads';
    }
    
}