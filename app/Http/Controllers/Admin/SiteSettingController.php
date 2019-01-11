<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SiteSettingRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

use App\User;
use Validator;
use Session;
use App\SiteSetting;
use Storage;
use Image;

class SiteSettingController extends Controller
{
    private $SiteSetting;

    public function __construct(
        SiteSetting $SiteSetting
    )
    {
        $this->SiteSetting  = $SiteSetting;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Site Setting';
        $this->ModuleView  = 'admin.siteSetting.';
        $this->ModulePath  = 'site-setting';
    }
    public function index()
    {
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Manage '.str_plural($this->ModuleTitle);
        $this->ViewData['modulePath'] = $this->ModulePath;

        return view($this->ModuleView.'index', $this->ViewData);
    }

    public function create()
    {
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Add '. $this->ModuleTitle;
        $this->ViewData['modulePath'] = $this->ModulePath;

       return view($this->ModuleView.'create', $this->ViewData);
    }

    public function store(SiteSettingRequest $request)
    {
        //dd($request->all());
        $SiteSetting = new $this->SiteSetting;

        $SiteSetting->site_title    = $request->site_title;
        $SiteSetting->address       = $request->address;
        $SiteSetting->contact_no    = $request->contact_no;
        $SiteSetting->email_id      = $request->email_id;
        $SiteSetting->meta_keywords = $request->meta_keywords;
        $SiteSetting->meta_desc     = $request->meta_desc;
        $SiteSetting->footer_text   = $request->footer_text;
        $SiteSetting->status        = '1';
        
        if (Input::hasFile('site_logo')) 
        {            
            $original_name   = strtolower(Input::file('site_logo')->getClientOriginalName());
            $site_logo       = Storage::disk('local')->put('site-setting/', Input::file('site_logo'), 'public');
            
            $featured_thumbnail_image = time().$original_name;
            $str_thumb_designation_path = storage_path().'/app/public/site-setting/thumbnails' ;
            $thumb_img = Image::make(Input::file('site_logo')->getRealPath())->resize(200, 45);
            $thumb_img->save($str_thumb_designation_path.'/'.$featured_thumbnail_image,80);

            $object->site_logo                     = $featured_thumbnail_image;
            $object->site_logo_image_original_name = $original_name;

        }

        if ($SiteSetting->save()) 
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['url']      = '/admin/site-setting/';
            $this->JsonData['msg']      = __('messages.ERR_SITE_SETTING_SUCCESS_MSG');
        }
        else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_SITE_SETTING_FAILD_ERR_MSG');
        }  
        return response()->json($this->JsonData);
    }
    
    /*-----------------------------------------------------
    |  Ajax Calls
    */
        public function getSettings(Request $request)
        {
            /*--------------------------------------
            |  Variables
            ------------------------------*/
                
                // skip and limit
                $start = $request->start;
                $length = $request->length;

                // serach value
                $search = $request->search['value']; 

                // order
                $column = $request->order[0]['column'];
                $dir = $request->order[0]['dir'];

                // filter columns
                $filter = array(
                    0 => 'id',
                    1 => 'site_title',
                    2 => 'email_id',
                    3 => 'updated_at',
                    4 => 'id'
                );

            /*--------------------------------------
            |  Model query and filter
            ------------------------------*/

                // start model query
                $modelQuery =  $this->SiteSetting;

                // get total count 
                $countQuery = clone($modelQuery);            
                $totalData  = $countQuery->count();

                // filter options
                if (!empty($search)) 
                {
                
                    $modelQuery = $modelQuery->where(function ($query) use($search)
                            {
                                $query->orwhere('id', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('site_title', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('email_id', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('updated_at', 'LIKE', '%'.Date('Y-m-d', strtotime($search)).'%');   
                            });
                }

                // get total filtered
                $filteredQuery = clone($modelQuery);            
                $totalFiltered  = $filteredQuery->count();
                
                // offset and limit
                $object = $modelQuery->orderBy($filter[$column], $dir)
                                     ->skip($start)
                                     ->take($length)
                                     ->get();            

            /*--------------------------------------
            |  data binding
            ------------------------------*/
                $data = [];
                if (!empty($object) && sizeof($object) > 0) 
                {
                    foreach ($object as $key => $row) 
                    {
                        $data[$key]['id']           = ($key+$start+1);
                        $data[$key]['site_title']   = '<span title="'.$row->site_title.'">'.str_limit($row->site_title, '55', '...').'</span>';
                        $data[$key]['email_id']     = $row->email_id;
                        $data[$key]['updated_at']   = Date('d-m-Y', strtotime($row->updated_at));
                        
                        $view   = '';
                        $edit   = '<a title="Edit" class="btn btn-default btn-circle" href="'.route('site-setting.edit', [ base64_encode(base64_encode($row->id))]).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;';

                        $data[$key]['actions'] = $view.$edit;
                    }
                }

                // wrapping up
                $this->JsonData['draw']             = intval($request->draw);
                $this->JsonData['recordsTotal']     = intval($totalData);
                $this->JsonData['recordsFiltered']  = intval($totalFiltered);
                $this->JsonData['data']             = $data;

            return response()->json($this->JsonData);
        }

    public function edit($id)
    {
        $SiteSetting = new $this->SiteSetting;

        $intId = base64_decode(base64_decode($id));
        $this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Edit '. $this->ModuleTitle;
        $this->ViewData['modulePath']   = $this->ModulePath;
        $this->ViewData['objectData']   = $this->SiteSetting->find($intId);

        return view($this->ModuleView.'edit', $this->ViewData);
    }

    public function update(SiteSettingRequest $request, $id)
    {
        $SiteSetting = new $this->SiteSetting;

        $intId = base64_decode(base64_decode($id));
        $SiteSetting = $this->SiteSetting->find($intId);

        $SiteSetting->site_title    = $request->site_title;
        $SiteSetting->address       = $request->address;
        $SiteSetting->contact_no    = $request->contact_no;
        $SiteSetting->email_id      = $request->email_id;
        $SiteSetting->meta_keywords = $request->meta_keywords;
        $SiteSetting->meta_desc     = $request->meta_desc;
        $SiteSetting->footer_text   = $request->footer_text;
        
        if (Input::hasFile('site_logo')) 
        {            
            $original_name   = strtolower(Input::file('site_logo')->getClientOriginalName());
            $site_logo       = Storage::disk('local')->put('site-setting/', Input::file('site_logo'), 'public');
            
            $featured_thumbnail_image = time().$original_name;
            $str_thumb_designation_path = storage_path().'/app/public/site-setting/thumbnails' ;
            $thumb_img = Image::make(Input::file('site_logo')->getRealPath())->resize(200, 45);
            $thumb_img->save($str_thumb_designation_path.'/'.$featured_thumbnail_image,80);

            $SiteSetting->site_logo                     = $site_logo;
            $SiteSetting->site_logo_image               = $featured_thumbnail_image;
            $SiteSetting->site_logo_image_original_name = $original_name;

        }

        if ($SiteSetting->save()) 
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['url']      = '/admin/site-setting';
            $this->JsonData['msg']      = __('messages.ERR_SITE_SETTING_SUCCESS_MSG');
        }
        else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_SITE_SETTING_FAILD_ERR_MSG');
        }  
        return response()->json($this->JsonData);
    }
}
