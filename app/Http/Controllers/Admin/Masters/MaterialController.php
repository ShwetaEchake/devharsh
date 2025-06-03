<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\Masters\{StoreMaterialRequest,UpdateMaterialRequest};
use App\Models\{Material,Category};
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::with(['category', 'movements'])->orderBy('material_name', 'asc')->get();
        $categories = Category::latest()->get();

        return view('admin.masters.materials')->with(['materials'=> $materials,'categories'=> $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaterialRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            Material::create( Arr::only( $input, Material::getFillables() ) );
            DB::commit();

            return response()->json(['success'=> 'Material created successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'Material');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        $categories = Category::latest()->get();


        if ($material)
        {
            $categoriesHtml = '<span>
                <option value="">--Select--</option>';
                foreach($categories as $category):
                    $is_select = $category->id == $material->category_id ? "selected" : "";
                    $categoriesHtml .= '<option value="'.$category->id.'" '.$is_select.'>'.$category->name.'</option>';
                endforeach;
            $categoriesHtml .= '</span>';


            $response = [
                'result' => 1,
                'material' => $material,
                'categoriesHtml' => $categoriesHtml,
            ];
        }
        else
        {
            $response = ['result' => 0];
        }
        return $response;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaterialRequest $request, Material $material)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $material->update( Arr::only( $input, Material::getFillables() ) );
            DB::commit();

            return response()->json(['success'=> 'Material updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Material');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        try
        {
            DB::beginTransaction();
            $material->delete();
            DB::commit();
            return response()->json(['success'=> 'Material deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Material');
        }

    }
}
