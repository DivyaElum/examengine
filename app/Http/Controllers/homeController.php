<?php

namespace App\Http\Controllers;

use App\User as UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\SiteSetting;

class homeController extends Controller
{

	public function index()
	{
		$this->ModuleTitle = 'Home';
        $this->ModuleView  = '';
        $this->ModulePath  = '';

        $arrSiteSetting = SiteSetting::find('1');

        $this->ViewData['page_title']    = $this->ModuleTitle;
    	$this->ViewData['moduleTitle']   = $this->ModuleTitle;
        $this->ViewData['moduleAction']  = $this->ModuleTitle;
        $this->ViewData['modulePath']    = $this->ModulePath;
        $this->ViewData['siteSetting']   = $arrSiteSetting;
        
		return view('welcome', $this->ViewData);
	}
    
}
