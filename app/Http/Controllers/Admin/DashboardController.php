<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\SiteSetting;

class DashboardController extends Controller
{
	private $BaseModel;
    private $ViewData;
    private $JsonData;
    private $ModuleTitle;
    private $ModuleView;
    private $ModulePath;
    private $SiteSetting;

    // use MultiModelTrait;

    public function __construct(
        SiteSetting $SiteSetting
    )
    {
        $this->SiteSetting  = $SiteSetting;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Dashboard';
        $this->ModuleView = 'admin.dashboard';
        $this->ModulePath = 'dashboard';
    }

   	public function index()
   	{
   		$this->ViewData['modulePath'] = $this->ModulePath;
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = $this->ModuleTitle;
        return view($this->ModuleView, $this->ViewData);
   	}
}
