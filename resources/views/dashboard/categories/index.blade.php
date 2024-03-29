@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (request()->parent == 'null')
                        <h1>{{ __('Main Categories') }}</h1>
                    @else
                        @php
                            $cat = \App\Category::where('id', request()->parent)->first();
                        @endphp
                        <h1>{{ __('Subsections') . ' - ' }} {{ app()->getLocale() == 'ar' ? $cat->name_ar : $cat->name_en }}
                        </h1>
                    @endif
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('categories.index', ['parent' => 'null', 'lang' => app()->getLocale()]) }}">{{ __('Main Categories') }}</a>
                        </li>


                        @php
                            $cats = [];
                            
                        @endphp

                        @if (request()->parent != 'null')
                            @while ($cat->parent != 'null')
                                @php
                                    array_push($cats, $cat->parent);
                                    $cat = \App\Category::where('id', intval($cat->parent))->first();
                                @endphp
                            @endwhile

                            @foreach (array_reverse($cats) as $cat)
                                @php
                                    $cat = \App\Category::where('id', intval($cat))->first();
                                @endphp
                                <li class="breadcrumb-item"> <a
                                        href="{{ route('categories.index', ['parent' => $cat->id, 'lang' => app()->getLocale()]) }}">{{ app()->getLocale() == 'ar' ? $cat->name_ar : $cat->name_en }}</a>
                                </li>
                            @endforeach

                            @php
                                $cat = \App\Category::where('id', request()->parent)->first();
                            @endphp

                            <li class="breadcrumb-item"> <a
                                    href="{{ route('categories.index', ['parent' => $cat->id, 'lang' => app()->getLocale()]) }}">{{ app()->getLocale() == 'ar' ? $cat->name_ar : $cat->name_en }}</a>
                            </li>
                        @endif

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->

        <div class="row">
            <div class="col-md-12">
                <form action="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="search" autofocus placeholder="{{ __('Search..') }}"
                                    class="form-control" value="{{ request()->search }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="country_id" style="display:inline-block">
                                <option selected disabled>All Countries</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ request()->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-search mr-1"></i>{{ __('Search') }}</button>
                            @if (auth()->user()->hasPermission('categories-create'))
                                <a
                                    href="{{ route('categories.create', ['parent' => request()->parent, 'lang' => app()->getLocale()]) }}">
                                    <button type="button" class="btn btn-primary">{{ __('Create Category') }}</button></a>
                            @else
                                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Create
                                        Category</button></a>
                            @endif


                            @if (request()->parent == 'null')
                                <a
                                    href="{{ route('categories.index', ['parent' => request()->parent, 'lang' => app()->getLocale()]) }}">
                                    <button type="button" class="btn btn-primary">{{ __('Main Categories') }}</button></a>
                            @else
                                @php
                                    $cat = \App\Category::where('id', request()->parent)->first();
                                @endphp
                                <a
                                    href="{{ route('categories.index', ['parent' => request()->parent, 'lang' => app()->getLocale()]) }}">
                                    <button type="button" class="btn btn-primary">{{ __('Subsections') . ' - ' }}
                                        {{ app()->getLocale() == 'ar' ? $cat->name_ar : $cat->name_en }}</button></a>
                            @endif


                            @if (auth()->user()->hasPermission('categories-read'))
                                <a
                                    href="{{ route('categories.trashed', ['parent' => request()->parent, 'lang' => app()->getLocale()]) }}">
                                    <button type="button" class="btn btn-primary">{{ __('Trash') }}</button></a>
                            @else
                                <a href="#" aria-disabled="true"> <button type="button"
                                        class="btn btn-primary">{{ __('Trash') }}</button></a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header">


                <h3 class="card-title">{{ __('Categories') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                @if ($categories->count() > 0)
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    #id
                                </th>
                                <th>
                                    {{ __('Image') }}
                                </th>
                                <th>
                                    {{ __('Arabic Name') }}
                                </th>
                                <th>
                                    {{ __('English Name') }}
                                </th>
                                {{-- <th>
                       {{__('Country')}}
                      </th> --}}


                                <th>
                                    {{ __('Profit Rate %') }}
                                </th>

                                <th>
                                    {{ __('Product Count') }}
                                </th>
                                <th>
                                    {{ __('Related Product') }}
                                </th>
                                <th>
                                    {{ __('Subsections') }}
                                </th>
                                <th>
                                    {{ __('Created At') }}
                                </th>
                                {{-- <th>
                     {{__('Updated At')}}
                  </th> --}}
                                <?php if ($categories !== null) {
                                    $Category = $categories[0];
                                } ?>
                                @if ($Category->trashed())
                                    <th>
                                        {{ __('Deleted At') }}
                                    </th>
                                @endif
                                <th style="" class="">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                @foreach ($categories as $Category)
                                    <td>
                                        {{ $Category->id }}
                                    </td>
                                    <td>

                                        <img alt="Avatar" class="table-avatar"
                                            src="{{ asset('storage/images/categories/' . $Category->image) }}">

                                    </td>
                                    <td>
                                        <small>
                                            {{ $Category->name_ar }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $Category->name_en }}
                                        </small>
                                    </td>
                                    {{-- <td>
                    <small>
                        {{ $Category->country->name_ar }}
                    </small>
                </td> --}}

                                    <td>
                                        <small>
                                            {{ $Category->profit . ' % ' }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $Category->products->count() }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            <a href="{{ route('products.index', ['category_id' => $Category->id, 'lang' => app()->getLocale()]) }}"
                                                class="btn btn-primary btn-sm">{{ __('Related Product') }}</a>
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            <a href="{{ route('categories.index', ['parent' => $Category->id, 'lang' => app()->getLocale()]) }}"
                                                class="btn btn-primary btn-sm">{{ __('Subsections') }}</a>
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $Category->created_at }}
                                        </small>
                                    </td>
                                    {{-- <td>
                      <small>
                          {{ $Category->updated_at }}
                      </small>
                  </td> --}}
                                    @if ($Category->trashed())
                                        <td>
                                            <small>
                                                {{ $Category->deleted_at }}
                                            </small>
                                        </td>
                                    @endif
                                    <td class="project-actions">
                                        <div class="row">

                                        @if (!$Category->trashed())
                                            @if (auth()->user()->hasPermission('categories-update'))
                                            <div class="col-md-6">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}"
                                                    href="{{ route('categories.edit', ['parent' => request()->parent,'lang' => app()->getLocale(),'category' => $Category->id]) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    
                                                </a>
                                            </div>
                                            @else
                                            <div class="col-md-6">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}" href="#" aria-disabled="true">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    
                                                </a>
                                            </div>
                                            @endif
                                        @else
                                            @if (auth()->user()->hasPermission('categories-restore'))
                                            <div class="col-md-6">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Restore') }}"
                                                    href="{{ route('categories.restore', ['parent' => request()->parent,'lang' => app()->getLocale(),'category' => $Category->id]) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    
                                                </a>
                                            </div>
                                            @else
                                            <div class="col-md-6">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Restore') }}" href="#" aria-disabled="true">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    
                                                </a>
                                            </div>
                                            @endif
                                        @endif

                                        @if (auth()->user()->hasPermission('categories-delete') |
    auth()->user()->hasPermission('categories-trash'))
                                            <form method="POST"
                                                action="{{ route('categories.destroy', ['parent' => request()->parent,'lang' => app()->getLocale(),'category' => $Category->id]) }}"
                                                enctype="multipart/form-data" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                               
                                                    @if ($Category->trashed())
                                                    <div class="col-md-6">
                                                    <button type="submit" class="btn btn-danger btn-sm delete" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}">
                                                        <i class="fas fa-trash">
                                                        </i> 
                                                    </button>
                                                    </div>
                                                    @else
                                                    <div class="col-md-6">
                                                    <button type="submit" class="btn btn-danger btn-sm delete" data-toggle="tooltip" data-placement="top" title="{{ __('Trash') }}">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                    </button>
                                                    </div>
                                                    @endif
                                                
                                            </form>
                                        @else
                                            
                                                @if ($Category->trashed())
                                                <div class="col-md-6">
                                                <button class="btn btn-danger btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}" >
                                                    <i class="fas fa-trash">
                                                    </i> 
                                                </button>
                                                </div>
                                                @else
                                                <div class="col-md-6">
                                                <button class="btn btn-danger btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Trash') }}" >
                                                    <i class="fas fa-trash">
                                                    </i>
                                                </button>
                                                </div>
                                                    
                                                @endif
                                            
                                        @endif
                                    </div>


                                    </td>
                            </tr>
                @endforeach


                </tbody>
                </table>

                <div class="row mt-3"> {{ $categories->appends(request()->query())->links() }}</div>
            @else
                <h3 class="pl-2">No categories To Show</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


@endsection
