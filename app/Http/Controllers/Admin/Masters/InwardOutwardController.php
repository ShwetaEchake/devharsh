<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\Masters\{StoreInwardOutwardRequest,UpdateInwardOutwardRequest};
use App\Models\{InwardOutward,Category,Material};
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class InwardOutwardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inward_outwords = InwardOutward::with(['category', 'material'])->get();

        $categories = Category::latest()->get();
        $materials = Material::latest()->get();

        return view('admin.masters.inward-outward')->with(['inward_outwords'=> $inward_outwords,'categories'=> $categories,'materials'=> $materials]);
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
    public function store(StoreInwardOutwardRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            InwardOutward::create( Arr::only( $input, InwardOutward::getFillables() ) );
            DB::commit();

            return response()->json(['success'=> 'InwardOutward created successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'InwardOutward');
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
    public function edit(InwardOutward $inward_outward)
    {
        $categories = Category::latest()->get();
        $materials = Material::latest()->get();


        if ($inward_outward)
        {
            $categoriesHtml = '<span>
                   <option value="">--Select Category--</option>';
                   foreach($categories as $category):
                       $is_select = $category->id == $inward_outward->category_id ? "selected" : "";
                       $categoriesHtml .= '<option value="'.$category->id.'" '.$is_select.'>'.$category->name.'</option>';
                   endforeach;
            $categoriesHtml .= '</span>';

            $materialHtml = '<span>
                   <option value="">--Select Category--</option>';
                   foreach($materials as $material):
                       $is_select = $material->id == $inward_outward->material_id ? "selected" : "";
                       $materialHtml .= '<option value="'.$material->id.'" '.$is_select.'>'.$material->material_name.'</option>';
                   endforeach;
            $materialHtml .= '</span>';

            $response = [
                'result' => 1,
                'inward_outward' => $inward_outward,
                'categoriesHtml' => $categoriesHtml,
                'materialHtml' =>  $materialHtml,
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
    public function update(UpdateInwardOutwardRequest $request, InwardOutward $inward_outward)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $inward_outward->update( Arr::only( $input, InwardOutward::getFillables() ) );
            DB::commit();

            return response()->json(['success'=> 'InwardOutward updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Inward Outward');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InwardOutward $inward_outward)
    {
        try
        {
            DB::beginTransaction();
            $inward_outward->delete();
            DB::commit();
            return response()->json(['success'=> 'InwardOutward deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'InwardOutward');
        }

    }
}
