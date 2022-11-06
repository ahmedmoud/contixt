<?php
/**
 * Created by PhpStorm.
 * User: salemcode8
 * Date: 5/11/18
 * Time: 1:55 PM
 */

namespace App\Presenters\Post;

use App\Post;
use App\Presenters\Presenter;

class UrlPresenter extends Presenter
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function show(){
        return route('posts.show', $this->post);
    }

    public function index(){
        return route('posts.index');
    }

    public function edit(){
        return route('posts.edit', $this->post);
    }

    public function update(){
        return route('posts.update', $this->post);
    }

    public function destroy(){
        return route('posts.destroy', $this->post);
    }
}