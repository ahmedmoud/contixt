<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\MenuGroup;
use App\Menu;
use App\Category;
use App\Category_post;
use Response;
use Blade;
use View;
use Illuminate\Support\Facades\DB;
use Cache;
use Mobile;

class AMP_MenuController extends Controller
{

    public function index($id=null) {
        if($id == null){
            $group_id = MenuGroup::select('id')->first()->value('id');
            
        }
        else
        {
            $group_id = $id;
        }
        
        if (isset($_GET['group_id'])) {
            $group_id = (int)$_GET['group_id'];
        }
        $menu = Menu::where('group_id',$group_id)->orderBy('position', 'ASC')->get();
      
        $data['menu_ul'] = '<ul id="easymm"></ul>';
        if ($menu) {

            foreach ($menu as $ky=>$row) {
                $this->add_row(
                    $row['id'],
                    $row['parent_id'],
                    ' id="menu-'.$row['id'].'" class=" _'.$ky.' sortable"',
                    $this->get_label($row)
                );
            }

            $data['menu_ul'] = $this->generate_list('id="easymm"');
        }
        $data['group_id'] = $group_id;

        $menu_groups = MenuGroup::get();
        
        return view('admin.menu.index', compact('data','menu_groups','group_id'));
    }

    var $data;

    
    function add_row($id, $parent, $li_attr, $label, $color = false,  $category_id = false ) {
        $this->data[$parent][] = array('color'=> $color, 'id' => $id, 'li_attr' => $li_attr, 'label' => $label, 'category_id'=> $category_id);
    }

    
    function generate_list($ul_attr = '') {
        return $this->ul(0, $ul_attr);
    }
    
    function ul($parent = 0, $attr = '') {
        
    
        static $i = 1;
        $indent = str_repeat("\t\t", $i);
        if (isset($this->data[$parent])) { 

            
            if ($attr) {
                $attr = ' ' . $attr;
            }else{
                $attr = " class='dropdown-menu'";
            }
            $html = "\n$indent";
            $html .= "<div><ul$attr >";
            $i++;
            $colors = '';
            
            $menuCats = array();
            foreach( $this->data[$parent] as $singleRow ){
                
                if( isset( $singleRow['category_id'] ) && $singleRow['category_id'] != null ){
                    $menuCats[] = $singleRow['category_id'];
                    
                }
            }
            $menuLimit = count($menuCats) * 5;
     
            if( defined('HOME') && $menuLimit > 0  && !Mobile::isMobile() ){
               $posts_IDS = array();
                foreach( $menuCats as $key=>$mcat ){
                    $posts_IDSs = Category_post::where('category_id', $mcat)->join('posts', 'posts.id','=','category_post.post_id')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.status',1)->limit(5)->orderBy('post_id', 'DESC')->pluck('post_id')->toArray();
                    $posts_IDS = array_merge($posts_IDSs, $posts_IDS);
                $MenuPosts  = DB::table('posts_images as posts')->where('posts.type','post')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->whereIn('posts.id', $posts_IDS)->
                    join('category_post','category_post.post_id','=','posts.id')
                    ->join('categories','categories.id','=','category_post.category_id')
                    ->whereIn('categories.id',$menuCats)->select('posts.id','posts.created_at','posts.slug','posts.title','posts.Murl','posts.Malt','posts.excerpt','categories.name as cname', 'categories.slug as cslug','categories.color as ccolor','categories.id as Cid' )
                    ->limit($menuLimit)->orderBy('posts.created_at','DESC');
                }
                
                $MenuPosts = $MenuPosts->get();

            $MenuCPosts = array();
            
            
            foreach( $MenuPosts as $Mpost ){

                    $MenuCPosts[$Mpost->Cid][] = $Mpost;

            }
            
            }else{
                $MenuPosts = $MenuCPosts = false;
            }
          
            foreach ($this->data[$parent] as $key=>$row) {
                $child = $this->ul($row['id']);
                $html .= "\n\t$indent";


                $posts = false;
               // if( $row['category_id'] ){
                    /*
                    $category = Category::find($row['category_id']);
                    $posts = $category->posts()->latest('created_at')->limit(5)->get();
                    */
                    $moreAttrs = "drop  _'.$key.' ";
                //}else{ $moreAttrs = ''; }
                
                 
                if ($child) {
                    
                $html .= '<li class="dropdown  " '. $row['li_attr'] . '><amp-accordion><section>';
                $html .= $row['label'];

                    $i--;
                    $html .= $child;
                    $html .= "\n\t$indent";
                }else{
                    $html .= '<li '. $row['li_attr'] . '>';
                    $html .= $row['label'];
                }
                if(defined('HOME') ) { 
                    if( isset($row['category_id']) && $row['category_id'] != null &&  $MenuCPosts ){
                           // dd($row);
                            // $h = View::make('components.menu.posts')->withPosts($MenuCPosts[ $row['category_id'] ]);
                            // $h = $h->render();
                            $h = '';
                        $html .= $h;
                    }
                }
                $colors .= " .navbar-nav>li._".$key.":hover>a:before { background-color: ".$row['color']." } .navbar-nav>li._".$key.":hover>a { color: ".$row['color']." } .navbar-nav>li._".$key."  .label-cont span  { background-color: ".$row['color']." } ";
                if( $child ){
                    $html .= "</section></amp-accordion>";
                }
                $html .= '</li>';
            }
            $html .= "\n$indent</ul></div>";
           // $html .= "<style> $colors </style>";
            return $html;
        } else {
            return false;
        }
    }

    function clear() {
        $this->data = array();
    }

    private function get_label($row) {
        $label =
            '<div class="ns-row">' .
                '<div class="ns-title">'.$row['title'].'</div>' .
                '<div class="ns-url">'.$row['url'].'</div>' .
                '<div class="ns-class">'.$row['class'].'</div>' .
                '<div class="ns-actions">' .
                    '<a href="#" class="edit-menu" title="Edit">' .
                        '<img src="'.url('admin_panel/assets/menu/design/').'/images/edit.png" alt="Edit">' .
                    '</a>' .
                    '<a href="#" class="delete-menu" title="Delete">' .
                        '<img src="'.url("admin_panel/assets/menu/design/").'/images/cross.png" alt="Delete">' .
                    '</a>' .
                    '<input type="hidden" name="menu_id" value="'.$row['id'].'">' .
                '</div>' .
            '</div>';
        return $label;
    }

    function easymenu($group_id, $attr = '', $way = false) {
 
        $id = $group_id.'_'.$attr.'_'.$way;

    $compiled = \Cache::remember('AMP_easy_menu__'.$id.\APP::getLocale(), 60*60, function() use ($group_id, $attr, $way) {

     $menu = Menu::leftJoin('menus as m','m.parent_id','=','menus.id')->select('menus.*','m.parent_id as hasChild','cat.slug')->where('menus.group_id',$group_id)->orderBy('menus.position', 'ASC')->leftJoin('categories as cat','cat.id','=','menus.category')->groupBy('menus.id')->get();

        foreach ($menu as $kk=>$row) {
$cID = $row['id'];
$hasChildren = ( isset($row['hasChild']) && $row['hasChild'] != null )? $row['hasChild'] : false;

 // $expand_data = 'class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"';
 $expand_data = '';
if( !$hasChildren ){ $expand_data = ''; }

if($row->category){ 

  //  $row->category = Category::select('slug','id')->where('id', $row->category)->first();
    


  
            $label = $hasChildren ? '<h4>'.$row['title'].'</h4>' : '<h4><a href="'.url($row['slug']).'" '.$expand_data.'>'.$row['title'].'</a></h4>' ;

    
    
}else{
            
            $label = $hasChildren ? '<h4>'.$row['title'].'</h4>' : '<h4><a href="'.$row['url'].'" '.$expand_data.'>'.$row['title'].'</a></h4>';
}

            $li_attr = '';
            if($row->category){
            	$row['class'] = ' ';
            	
            	$category_id = $row['category'];
            	
            	
            }else { $category_id = false;   }
            
            
            
            // if ($row['class']) {
            //     $li_attr = ' class="'.$row['class'].'"';
            // }
           
            $this->add_row($row['id'], $row['parent_id'], $li_attr, $label, $row['color'], $category_id );
        }
        $menu = $this->generate_list($attr);
  
        if( $way ) return $menu;
        
        
        return view('preview',compact('menu','group_id'));

    });
    return $compiled;
}
    

    public function preview($id, $attr = false, $way)
    {
        if(defined('HOME')) { $home = 'yesHOME'; }else{ $home = 'NoHOME'; }
        if( Mobile::isMobile() ){ $mob = 'yesMOB'; }else { $mob = 'noMOB'; }
       // $ourMenu = Cache::remember('_ourMenuHTML'.$home.$way.$mob.$id.'_'.\APP::getLocale(), 60*24, function() use ( $attr,$id,$way) {

        return $this->easymenu($id, $attr, $way);
        
      //  });
        return $ourMenu;

    }

    public function preview_css(Request $request, $id)
    {
        return $this->easymenu($id,$request->attr);
    }

    public function menu_group()
    {
        if (isset($_POST['title'])) {
            $data['title'] = trim($_POST['title']);
            if (!empty($data['title'])) {
                //if ($this->db->insert(MENUGROUP_TABLE, $data)) {
                if (MenuGroup::create($data)) {
                    $response['status'] = 1;

                } else {
                    $response['status'] = 2;
                    $response['msg'] = 'Add group error.';
                }
            } else {
                $response['status'] = 3;
            }
            header('Content-type: application/json');
                return back();
        } else {
           return view('admin.menu.menu_group_add');

        }
    }

    // public function post_menu_group(Request $request)
    // {
    // 	$this->validate(request(),[
    // 		'title' => 'required',
    //     ]);

    //     $menu_group = new MenuGroup;

    //     $menu_group->title = $request->title;

    //     $menu_group->save();

    //     return back();

    // }

    public function add_to_menu(Request $request)
    {

        $this->validate(request(),[
            'title' => 'required',
        ]);

        $add_to_menu = new Menu();

        $add_to_menu->title = $request->title;
        $add_to_menu->url = $request->url;
        $add_to_menu->category = $request->category;
        $add_to_menu->color = $request->color;
        $add_to_menu->group_id = $request->group_id;

        $add_to_menu->save();

        return back();
    }

   public function update()
   {

$out = array();
        if (!empty($_POST['menu'])) {
            //adodb_pr($menu);
            $menu = $_POST['menu'];

            foreach ($menu as $k => $v) {
                if ($v == 'null') {
                    $menu2[0][] = $k;
                } else {
                    $menu2[$v][] = $k;
                }
            }
            //adodb_pr($menu2);

            $success = 0;
            if (!empty($menu2)) {
                 $i = 1;
                foreach ($menu2 as $k => $v) {
                   
                    foreach ($v as $v2) {
                        echo $v2."  ::  ".$i." \n";
                       
                        $data['parent_id'] = $k;
                        $data['position'] = $i;

                        $out[] = array_merge(['id'=>$v2], $data);
                        
                        $the_update = Menu::find($v2);
                        $the_update->parent_id = $k;
                        $the_update->position  = $i;
                        
                        
                        if (  $the_update->save() ) {
                            $success++;
                        }else{
                            dd('asdasdfasdf');
                        }
                        $i++;
                    }
                }
            }
         
             echo $success;
            // die;
        }

   }

   private function update_position($parent, $children) {
        $i = 1;
        foreach ($children as $k => $v) {
            $id = (int)$children[$k]['id'];
            $data['parent_id'] = $parent;
            $data['position'] = $i;
            Menu::where('id' , $v2)->update($data);
            if (isset($children[$k]['children'][0])) {
                $this->update_position($id, $children[$k]['children']);
            }
            $i++;
        }
    }

    
    public function deleteArow($id){

        $parent = Menu::where('id', $id)->select('parent_id')->first();
        $parent_id = $parent->parent_id;
        $update = Menu::where('parent_id', $id)->update(['parent_id'=> $parent_id]);
        $out = Menu::where('id', $id)->delete();
        if( $out ){
$data = ['success'=>true];
}else{
$data = ['success'=>false];
}
        
        return response()->json($data)->header('Content-Type', 'application/json');;

    }
    
        public function editRow($id){
$data = Menu::where('id', $id)->first();
return view('admin.menu.menu_edit', compact('data') );

       }

        public function editsRow(Request $request, $id){

$update = Menu::where('id', $id)->update( ['title'=>$request->title, 'url'=>$request->url,'class'=>$request->class, 'color'=>$request->color] );
$menu = Menu::where('id', $id);
$data = [ 'menu'=> $menu, 'status'=> $update  ];
        return response()->json($data)->header('Content-Type', 'application/json');



}
   


 
}
