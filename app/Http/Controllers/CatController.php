<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;

class CatController extends Controller
{
    public function index(){
        //to return parent categories only
        $cats = Cat::with('children')->whereNull('parent_id',)->get();

        return view('dashboard\admin\cats\index')->with(['cats'=>$cats]);
    }

    public function store(Request $request)
{
      $validatedData = $this->validate($request, [
            'category' => 'required|min:3|max:255|string',
            'parent_id' => 'sometimes|nullable|numeric'
      ]);

      Cat::create($validatedData);

      return redirect()->route('admin.cat.index')->withSuccess('You have successfully created a Category!');
}

public function update(Request $request, Cat $category)
{
        $validatedData = $this->validate($request, [
            'category'  => 'required|min:3|max:255|string'
        ]);

        $category->update($validatedData);

        return redirect()->route('admin.cat.index')->withSuccess('You have successfully updated a Category!');
}
public function destroy(Cat $category)
{
        if ($category->children) {
            foreach ($category->children()->with('user')->get() as $child) {
                foreach ($child->user as $post) {
                    $post->update(['cat_id' => NULL]);
                }
            }

            $category->children()->delete();
        }

        foreach ($category->user as $post) {
            $post->update(['cat_id' => NULL]);
        }
        // Cat::find($category->cat_id)->delete();
         $category->delete();

        return redirect()->route('admin.cat.index')->withSuccess('You have successfully deleted a Category!');
}

public function news(){
    $news = Cat::where('id','=',1)->first();
     $cats = Cat::with('children')->whereNull('parent_id')->get();
    return view('dashboard.admin.cats.news',compact('news','cats'));
}
public function sports(){
    $news = Cat::where('id','=',2)->first();
     $cats = Cat::with('children')->whereNull('parent_id')->get();
    return view('dashboard.admin.cats.sports',compact('sports','cats'));
}
public function politics(){
    $news = Cat::where('id','=',1)->first();
     $cats = Cat::with('children')->whereNull('parent_id')->get();
    return view('dashboard.admin.cats.politics',compact('politics','cats'));
}
public function business(){
    $news = Cat::where('id','=',1)->first();
     $cats = Cat::with('children')->whereNull('parent_id')->get();
    return view('dashboard.admin.cats.business',compact('business','cats'));
}





}
