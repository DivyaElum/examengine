<?php

namespace App\Http\Controllers;

use App\User as UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class homeController extends Controller
{

	public function index()
	{
		$this->ModuleTitle = 'Index';
        $this->ModuleView  = '.';
        $this->ModulePath  = '';

        $this->ViewData['page_title']    = $this->ModuleTitle;
    	$this->ViewData['moduleTitle']   = $this->ModuleTitle;
        $this->ViewData['moduleAction']  = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']    = $this->ModulePath;
        
		return view('welcome', $this->ViewData);
	}
    
}
