<?php
/**
 * Created by PhpStorm.
 * User: salemcode8
 * Date: 5/11/18
 * Time: 1:54 PM
 */
namespace App\Presenters\User;

//use App\User;
use App\Presenters\Presenter;

class UrlPresenter extends Presenter{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function update(){
        return route('users.update', $this->user);
    }

    public function edit(){
        return route('users.edit', $this->user);
    }

    public function destroy(){
        return route('users.destroy', $this->user);
    }
}