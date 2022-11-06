<?PHP

namespace App\Modules\UPerm\Facade;

class UPerm extends \Illuminate\Support\Facades\Facade
{
    
    public static function getFacadeAccessor(){
        return 'uperm';
    }
    
}