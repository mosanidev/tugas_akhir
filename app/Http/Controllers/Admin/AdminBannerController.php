<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = Storage::files('public\images\banner');

        return view('admin.banner.index', ['arrBanner' => $files]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $files = Storage::files('public\images\banner');
        $numFiles = count(Storage::disk('public')->allFiles("images/banner"));

        $newName = $numFiles+1;

        $newFileName = $newName.".".$request->banner_file->getClientOriginalExtension(); 

        $request->banner_file->storeAs('public/images/banner', $newFileName);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $name)
    {        
        $extension = pathinfo("images/banner/$name", PATHINFO_EXTENSION);

        Storage::disk('public')->move("images/banner/$name", "images/banner/deletesoon.$extension");

        $newFileName = $name[0].".".$request->banner_file->getClientOriginalExtension(); 

        $request->banner_file->storeAs('public/images/banner', $newFileName);

        $deleted = Storage::disk('public')->delete("images/banner/deletesoon.$extension");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($name)
    {
        $deleted = Storage::disk('public')->delete("images/banner/$name");

        $files = Storage::disk('public')->allFiles("images/banner");

        $newNum[] = null;

        //sort again after delete
        for($i=0; $i<count($files); $i++)
        {
            $extension[] = pathinfo($files[$i], PATHINFO_EXTENSION);

            $baseName[] = basename($files[$i], ".".$extension[$i]);

            $newNum[$i] = $i+1;

            if($baseName[$i] != $newNum[$i]) // untuk mengecek apakah nama file sudah berurutan, ex 1,2,3
            {
                $replace = str_replace($baseName[$i], $newNum[$i], $files[$i]);

                Storage::disk('public')->move($files[$i], $replace);
            }
        }

        return redirect()->back();

    }
}
