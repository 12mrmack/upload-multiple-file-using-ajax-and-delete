 Public function add_project_media(Request $request,$id){
        if($request->TotalImages > 0)
         {
            for ($x = 0; $x < $request->TotalImages; $x++) {
       
            if ($request->hasFile('images'.$x)) {

            $file = $request->file('images'.$x);
            $name = $file->getClientOriginalName();
            $destinationpath = public_path('images/projects/');
            $filename = pathinfo($name, PATHINFO_FILENAME);
            $filename = strtolower($filename);
            $filename = preg_replace("/[^a-z0-9_\s-]/", "", $filename);
            $filename = preg_replace("/[\s-]+/", " ", $filename);
            $filename = preg_replace("/[\s_]/", "-", $filename);
            $extension1 = $file->getClientOriginalExtension();
            $filename1 = $filename. '_' . rand(11111, 99999) . '.' . $extension1;
            $file->move($destinationpath, $filename1);
            // $data['media'] = $filename1;
            $data = array('image'=>$filename1,'project_id'=>$id);
            DB::table('project_media')->insert($data);
            }            
        }
              
    }

    $new_image = DB::table('project_media')->where('project_id',$id)->get();
        $image_data = array();
        $image_all = array();
        foreach ($new_image as $n_image) {
             $image_all[] .= '<div class="col-sm-3 added"><img src="'.asset('/images/projects').'/'.$n_image->image.'" class="img-fluid mb-2" alt="white sample"><i class="fa fa-times del m_'.$n_image->id.'" pro_img_attr="'.$n_image->id.'"></i></div>';
        }
         $image_data['all'] =  $image_all;
        $image_data['single'] = '<img src="'.asset('/images/projects').'/'.$n_image->image.'" class="img-fluid mb-2">';
        // echo '<pre>';print_r($image_data);die();
        return $image_data ;  

    }
