<?PHP

namespace App\Modules\UPerm;
use Auth;
use App\Post;

class UPerm {
    
    // Post Control
    
    public function PostCreate(){
        return ( $this->PostPublish() || $this->PostPending() )? true : false;
            
    }
    
    public function PostPublish(){
        return Auth::user()->hasPermission('create_publish','posts');
    }
    
    public function PostPending(){
        return Auth::user()->hasPermission('create_pending','posts');
    }

    public function PostReviewB4Publish(){
        return Auth::user()->hasPermission('create_PostReviewB4Publish','posts');
    }

    
    public function PostStatus(){
        
        $status = [3];
        
        if( Auth::user()->hasPermission('create_pending','posts') ) 
        $status[] = 2;

        if( Auth::user()->hasPermission('create_PostReviewB4Publish','posts') ) 
        $status[] = 4;
        
        if( Auth::user()->hasPermission('create_publish','posts') ) 
        $status[] = 1;
        
        return $status;
        
    }
    
    
    
    
    
    public function PostEdit($postID){
       $postOwner =  $this->postOwner($postID);
     
       if( intval($postOwner[0]) == intval(Auth::user()->id) ){
           return $this->PostOwnerUpdate();
       }
            return $this->PostOtherUpdate();
            
    }
    
    public function PostOwnerUpdate(){
        
        return Auth::user()->hasPermission('owner_update','posts');
    }
    public function PostOtherUpdate(){
        return Auth::user()->hasPermission('other_update','posts');
    }
    
    public function PostRemove($postID){
        $postOwner =  $this->postOwner($postID);
        if( $postOwner == Auth::user()->id ){
            return $this->PostOwnerRemove();
        }
             return $this->PostOtherRemove();
             
     }

    public function PostOwnerRemove(){
        
        return Auth::user()->hasPermission('owner_remove','posts');
    }
    public function PostOtherRemove(){
        return Auth::user()->hasPermission('other_remove','posts');
    }
    
    
    public function postOwner($ID){
        return Post::where('id', $ID)->select('user_id')->limit(1)->pluck('user_id')->toArray();
    }


    public function OthersPostsViews(){
        
        return Auth::user()->hasPermission('view','others_posts');
    }    
    
    // ROles and Permissions
    public function ControlRolesPermissions(){
        return $this->HasPerm('control', 'roles');
    }
    

    // Categories
    public function ViewCategories(){
        if( $this->HasPerm('view','categories') ){ return true; }
        if( $this->CreateCategories() ){ return true; }
        if( $this->EditCategories() ){ return true; }
        if( $this->RemoveCategories() ){ return true; }

        return false;
    }

    public function CreateCategories(){
        return $this->HasPerm('create','categories');
    }

    public function EditCategories(){
        return  $this->HasPerm('update','categories');
    }

    public function RemoveCategories(){
        return $this->HasPerm('delete','categories');
    }

    public function ControlCompetition(){
        return $this->HasPerm('control','competitions');
    }
    public function ControlResala(){
        return $this->HasPerm('control','resala');
    }
    public function PublishResala(){
        return $this->HasPerm('publish','resala');
    }
    
    
    

    

    // Settings

    public function ControlSettings(){
        return $this->HasPerm('control','settings');
    }

    // Users
    public function ControlUsers(){
        return $this->HasPerm('control','users');
    }


    public function ControlAds(){
        return $this->HasPerm('control','ads');
    }



    public function ControlComments(){
        return $this->HasPerm('control','comments');
    }


    public function ControlNativeAds(){
        return $this->HasPerm('control','Nativeads');
    }
    
    public function EditPostSlug(){
        return $this->HasPerm('control','postSlug');
    }

    public function InsertotherSitesLinks(){
        return $this->HasPerm('insert','otherSitesLinks');
    }

    public function ViewPostsEdits(){
        return $this->HasPerm('view','edits');
    }

    public function ControlPostsFUpdates(){
        return $this->HasPerm('control','postsUpdates');
    }
    
    public function ControlHisPostsFUpdates(){
        return  $this->HasPerm('control','HisPostsUpdates');
    }

    public function ClearCache(){
        return $this->HasPerm('clear','cache');
    }

    public function createKeywords(){
        return $this->HasPerm('create','keywords');
    }

    public function ViewUsersLength(){
        return $this->HasPerm('view','wordsLengt');
    }

    public function manageRedirections(){
        return $this->HasPerm('manage','redirections');
    }

    public function PostsBulkAction(){
        return ( $this->PostsBulkAction_move() || $this->PostsBulkAction_delete() || $this->PostsBulkAction_status() );
    }
    
    public function PostsBulkAction_move(){
        return $this->HasPerm('move','postsBulk');
    }
    public function PostsBulkAction_delete(){
        return $this->HasPerm('delete','postsBulk');
    }
    public function PostsBulkAction_status(){
        return $this->HasPerm('status','postsBulk');

    }

    public function NoKeywordsLimit(){
        return $this->HasPerm('no_limit','keywords');

    }
    
    public function BeKeyword(){
        return $this->HasPerm('convert','bekeyword');
    }



    public function HasPerm($action, $section){
       if( Auth::check() && Auth::user()->role != null && Auth::user()->hasPermission($action, $section) ){
           return Auth::user()->hasPermission($action, $section);
       }
       return false;
    }
    

    public function Block(){
        return response("You are not allowed to perform this action", 404);
    }



     
}