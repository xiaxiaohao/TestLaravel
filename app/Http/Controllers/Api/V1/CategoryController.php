<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Category;

class CategoryController extends Controller
{

    public function manageCategory()
    {
        $categories = Category::where('pid', '=', 0)->get();
        $allCategories = Category::pluck('title','id')->all();
        return view('categoryTreeview',compact('categories','allCategories'));
    }

    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $input = $request->all();
        $input['pid'] = empty($input['pid']) ? 0 : $input['pid'];

        Category::create($input);

        return back()->with('success', 'New Category added successfully.');
    }
}