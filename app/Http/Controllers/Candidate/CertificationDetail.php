<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\CourseModel;

class CertificationDetail extends Controller
{
	private $CourseModel;

    public function __construct(

        CourseModel $CourseModel
    )
    {
        $this->CourseModel  = $CourseModel;

    	$this->ModuleTitle = 'Certification details';
        $this->ModuleView  = 'candidate.';
        $this->ModulePath  = '';
    }
    public function index($indId)
    {

        $this->ViewData['page_title']   = 'Detail page of Certification';
    	$this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']   = $this->ModulePath;
        $this->ViewData['arrCerficationDetils'] = $this->CourseModel->find(base64_decode(base64_decode($indId)));
        
        return view($this->ModuleView.'certification_details', $this->ViewData);
    }
}
