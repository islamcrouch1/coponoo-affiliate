@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">categories</li>
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
                <input type="text" name="search" autofocus placeholder="{{__('Search..')}}" class="form-control" value="{{request()->search}}">
                </div>
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
                @if (auth()->user()->hasPermission('categories-create'))
                <a href="{{route('categories.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">Create Category</button></a>

                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Create Category</button></a>

                @endif
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">categories</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($categories->count() > 0)
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          #id
                      </th>
                      <th>
                       {{__('Image')}}
                    </th>
                      <th>
                          {{__('Arabic Name')}}
                      </th>
                      <th>
                       {{__('English Name')}}
                      </th>
                      <th>
                       {{__('English Name')}}
                      </th>
                      <th>
                        Product Count
                      </th>
                      <th>
                        Related Product
                    </th>
                    <th>
                     {{__('Updated At')}}
                  </th>
                  <?php if($categories !== Null){$Category = $categories[0];} ?>
                  @if ($Category->trashed())
                  <th>
                   {{__('Deleted At')}}
                  </th>
                  @endif
                      <th style="" class="">
                       {{__('Actions')}}
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr>

                      @foreach ($categories->reverse() as $Category)
                    <td>
                        {{ $Category->id }}
                    </td>
                    <td>

                      <img alt="Avatar" class="table-avatar" src="{{ asset('storage/images/categories/' . $Category->image) }}">

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
                  <td>
                    <small>
                        {{ $Category->products->count() }}
                    </small>
                </td>
                  <td>
                    <small>
                         <a href="{{ route('products.index' , ['category_id' => $Category->id , 'lang' => app()->getLocale()]) }}" class="btn btn-primary">related products</a>
                    </small>
                </td>
                    <td>
                        <small>
                            {{ $Category->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $Category->updated_at }}
                      </small>
                  </td>
                  @if ($Category->trashed())
                  <td>
                    <small>
                        {{ $Category->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-actions">



                        @if (!$Category->trashed())
                        @if (auth()->user()->hasPermission('categories-update'))
                        <a class="btn btn-info btn-sm" href="{{route('categories.edit' , ['lang'=>app()->getLocale() , 'category'=>$Category->id])}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                           {{__('Edit')}}
                        </a>
                        @else
                        <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                          <i class="fas fa-pencil-alt">
                          </i>
                         {{__('Edit')}}
                      </a>
                      @endif
                        @else
                        @if (auth()->user()->hasPermission('categories-restore'))

                        <a class="btn btn-info btn-sm" href="{{route('categories.restore' , ['lang'=>app()->getLocale() , 'category'=>$Category->id])}}">
                          <i class="fas fa-pencil-alt">
                          </i>
                         {{__('Restore')}}
                      </a>
                      @else
                      <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                        <i class="fas fa-pencil-alt">
                        </i>
                       {{__('Restore')}}
                    </a>
                    @endif
                                @endif

                                @if ((auth()->user()->hasPermission('categories-delete'))| (auth()->user()->hasPermission('categories-trash')))

                                    <form method="POST" action="{{route('categories.destroy' , ['lang'=>app()->getLocale() , 'category'=>$Category->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($Category->trashed())
                                                    {{ __('Delete') }}
                                                    @else
                                                    {{ __('Trash') }}
                                                    @endif
                                                </button>
                                    </form>
                                    @else
                                    <button  class="btn btn-danger btn-sm">
                                      <i class="fas fa-trash">
                                      </i>
                                      @if ($Category->trashed())
                                      {{ __('Delete') }}
                                      @else
                                      {{ __('Trash') }}
                                      @endif
                                  </button>
                                  @endif


                    </td>
                </tr>
                      @endforeach


              </tbody>
          </table>

          <div class="row mt-3"> {{ $categories->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">No categories To Show</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection
