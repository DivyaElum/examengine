<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\CourseModel;

class CertificationController extends Controller
{
	private $CourseModel;

    public function __construct(

        CourseModel $CourseModel
    )
    {
        $this->CourseModel  = $CourseModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Certification Listing';
        $this->ModuleView  = 'front.certification.';
        $this->ModulePath  = 'CourseModel';
    }
    public function index()
    {
        $this->ViewData['page_title']           = 'Listings for Certifications';
    	$this->ViewData['moduleTitle']          = $this->ModuleTitle;
        $this->ViewData['moduleAction']         = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']           = $this->ModulePath;
        $this->ViewData['arrCerficationList']   = $this->CourseModel->get();

        return view($this->ModuleView.'index', $this->ViewData);
    }
    
    public function detail($indId)
    {
        $this->ViewData['page_title']           = 'Detail page for Certification';
        $this->ViewData['moduleTitle']          = $this->ModuleTitle;
        $this->ViewData['moduleAction']         = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']           = $this->ModulePath;
        $this->ViewData['arrCerficationDetils'] = $this->CourseModel->find(base64_decode(base64_decode($indId)));
        
        return view($this->ModuleView.'detail', $this->ViewData);
    }
}
