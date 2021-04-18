  public function create(Request $request){


        if($request->method() == 'POST'){
            $desc = htmlentities(trim(str_replace("\\", "", $request->prepartion)), ENT_QUOTES | ENT_IGNORE, "UTF-8", true);

            $description = $request->prepartion;
            $dom = new \DomDocument();

            $dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $images = $dom->getElementsByTagName('img');

            foreach($images as $k => $img){
                $data = $img->getAttribute('src');

                list($type, $data) = explode(';', $data);
                list($type, $data) = explode(',', $data);
                $data = base64_decode($data);



                $image_name= "/upload/" . time().$k.'.png';

                $path = public_path() . $image_name;
                file_put_contents($path, $data);
                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);

            }

            $description = $dom->saveHTML();

           //further store the description into database


        }
        return view('recipies.create');
    }
