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
        $this->ModuleView  = 'candidate.';
        $this->ModulePath  = 'CourseModel';
    }
    public function index()
    {
        $this->ViewData['page_title']   = 'Listings of Certifications';
    	$this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']   = $this->ModulePath;
        $this->ViewData['arrCerficationList'] = $this->CourseModel->get();

        return view($this->ModuleView.'certification_list', $this->ViewData);
    }
}
