<?PHP

namespace App\Modules\Mobile\Facade;

class Mobile extends \Illuminate\Support\Facades\Facade
{
    
    public static function getFacadeAccessor(){
        return 'mobile';
    }
    
}