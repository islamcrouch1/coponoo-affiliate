<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Slide;
use Illuminate\Http\Request;

class SlidesController extends Controller
{
    public function index()
    {
        $slides = Slide::whenSearch(request()->search)
            ->paginate(100);

        return view('dashboard.slides.index')->with('slides', $slides);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.slides.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'slide_id' => "required|string",
            'url' => "required|string",
            'image' => "required|image",

        ]);


        $slide = Slide::create([

            'slide_id' => $request['slide_id'],
            'url' => $request['url'],
            'image' => $request['image']->store('images/slides', 'public'),

        ]);





        session()->flash('success', 'slide created successfully');

        return redirect()->route('slides.index', app()->getLocale());
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
    public function edit($lang, $slide)
    {
        $slide = Slide::find($slide);
        return view('dashboard.slides.edit ')->with('slide', $slide);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, slide $slide)
    {

        $request->validate([

            'slide_id' => "string",
            'url' => "string",
            'image' => "image",


        ]);

        if ($request->hasFile('image')) {

            \Storage::disk('public')->delete($slide->image);
            $slide->update([
                'image' => $request['image']->store('images/slides', 'public'),
            ]);
        }

        $slide->update([

            'slide_id' => $request['slide_id'],
            'url' => $request['url'],

        ]);




        session()->flash('success', 'slide updated successfully');

        return redirect()->route('slides.index', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $slide)
    {

        $slide = Slide::withTrashed()->where('id', $slide)->first();

        if ($slide->trashed()) {

            if (auth()->user()->hasPermission('slides-delete')) {
                \Storage::disk('public')->delete($slide->image);
                $slide->forceDelete();

                session()->flash('success', 'slide Deleted successfully');

                $slides = Slide::onlyTrashed()->paginate(100);
                return view('dashboard.slides.index', ['slides' => $slides]);
            } else {
                session()->flash('success', 'Sorry.. you do not have permission to make this action');

                $slides = Slide::onlyTrashed()->paginate(100);
                return view('dashboard.slides.index', ['slides' => $slides]);
            }
        } else {

            if (auth()->user()->hasPermission('slides-trash')) {
                $slide->delete();

                session()->flash('success', 'slide trashed successfully');

                $slides = Slide::whenSearch(request()->search)
                    ->paginate(100);

                return view('dashboard.slides.index')->with('slides', $slides);
            } else {
                session()->flash('success', 'Sorry.. you do not have permission to make this action');

                $slides = Slide::whenSearch(request()->search)
                    ->paginate(100);

                return view('dashboard.slides.index')->with('slides', $slides);
            }
        }
    }


    public function trashed()
    {

        $slides = Slide::onlyTrashed()->paginate(100);
        return view('dashboard.slides.index', ['slides' => $slides]);
    }

    public function restore($lang, $slide)
    {

        $slide = Slide::withTrashed()->where('id', $slide)->first()->restore();

        session()->flash('success', 'slide restored successfully');

        $slides = Slide::whenSearch(request()->search)
            ->paginate(5);

        return view('dashboard.slides.index')->with('slides', $slides);
    }
}
