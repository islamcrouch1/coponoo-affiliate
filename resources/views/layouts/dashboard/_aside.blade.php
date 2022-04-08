  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('home', app()->getLocale()) }}" class="brand-link"
          style="text-align:center; background-color: #fff; color: #000">
          <img src="{{ asset('storage/images/logo.png') }}" class="" style="width:160px"><br>
          <small style="font-size: .5em;">Powered by Sonooegy</small>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ asset('storage/images/users/' . Auth::user()->profile) }}"
                      class="img-circle elevation-2" alt="User Image">

              </div>
              <div class="info">
                  <a href="#" class="d-block">{{ Auth::user()->name }}</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  {{-- <li class="nav-header">EXAMPLES</li> --}}


                  <li class="nav-item has-treeview menu-open">
                      <a href="{{ route('home', app()->getLocale()) }}"
                          class="nav-link {{ Route::is('home*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              {{ __('Dashboard') }}

                          </p>
                      </a>
                  </li>



                  <li class="nav-item has-treeview">
                      <a href="{{ route('profile.edit', app()->getLocale()) }}"
                          class="nav-link {{ Route::is('profile.edit*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-user"></i>
                          <p>
                              {{ __('My Profile') }}

                          </p>
                      </a>
                  </li>


                  @if (auth()->user()->HasRole('vendor'))
                      <li class="nav-item has-treeview">
                          <a href="{{ route('vendor-products.index', app()->getLocale()) }}"
                              class="nav-link {{ Route::is('vendor-products.index*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-sitemap "></i>
                              <p>
                                  {{ __('Products') }}
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                      </li>
                  @endif


                  @if (auth()->user()->HasRole('vendor'))
                      <li class="nav-item has-treeview">
                          <a href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                              class="nav-link {{ Route::is('orders.vendor.show*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-list-alt"></i>
                              <p>
                                  {{ __('Orders') }}
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                      </li>
                  @endif




                  @if (auth()->user()->HasRole('vendor'))
                      <li class="nav-item has-treeview">
                          <a href="#"
                              class="nav-link {{ Route::is('withdrawals.index.vendor*') || Route::is('vendor-withdrawals.request*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-credit-card"></i>
                              <p>
                                  {{ __('Withdrawals Requests') }}
                                  <i class="fas fa-angle-left right"></i>
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('withdrawals.index.vendor', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                                      class="nav-link {{ Route::is('withdrawals.index.vendor*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Withdrawals Requests') }}</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('vendor-withdrawals.request', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                                      class="nav-link {{ Route::is('vendor-withdrawals.request*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('New withdrawal request') }}</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endif





                  @if (auth()->user()->hasPermission('settings-create'))
                      <li class="nav-item has-treeview">
                          <a href="{{ route('settings.show', app()->getLocale()) }}"
                              class="nav-link {{ Route::is('settings.show*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-cogs"></i>
                              <p>
                                  {{ __('Settings') }}

                              </p>
                          </a>

                      </li>
                  @endif




                  @if (auth()->user()->HasRole('affiliate'))
                      <li class="nav-item has-treeview">
                          <a href="{{ route('products.affiliate', app()->getLocale()) }}"
                              class="nav-link {{ Route::is('products.affiliate*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-sitemap "></i>
                              <p>
                                  {{ __('Products') }}
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                      </li>
                  @endif

                  @if (auth()->user()->HasRole('affiliate'))
                      <li class="nav-item has-treeview">
                          <a href="{{ route('products.aff.mystock', app()->getLocale()) }}"
                              class="nav-link {{ Route::is('products.aff.mystock*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-sitemap "></i>
                              <p>
                                  {{ __('My stock') }}
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                      </li>
                  @endif


                  @if (auth()->user()->HasRole('affiliate'))
                      <li class="nav-item has-treeview">
                          <a href="{{ route('cart', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                              class="nav-link {{ Route::is('cart*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-cart-plus"></i>
                              <p>
                                  {{ __('Shopping Cart') }}
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                      </li>
                  @endif

                  @if (auth()->user()->HasRole('affiliate'))
                      <li class="nav-item has-treeview">
                          <a href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                              class="nav-link {{ Route::is('orders.affiliate.show*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-list-alt"></i>
                              <p>
                                  {{ __('Orders') }}
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                      </li>
                  @endif


                  @if (auth()->user()->HasRole('affiliate'))
                      <li class="nav-item has-treeview">
                          <a href="{{ route('mystock.orders', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                              class="nav-link {{ Route::is('mystock.orders*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-cubes"></i>
                              <p>
                                  {{ __('Stock orders') }}
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                      </li>
                  @endif


                  @if (auth()->user()->HasRole('affiliate'))
                      <li
                          class="nav-item has-treeview {{ Route::is('shipping_rates.affiliate*') ? 'menu-open' : '' }}">
                          <a href="{{ route('shipping_rates.affiliate', app()->getLocale()) }}"
                              class="nav-link {{ Route::is('shipping_rates.affiliate*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-truck"></i>
                              <p>
                                  {{ __('Shipping Rates') }}

                              </p>
                          </a>
                      </li>
                  @endif




                  @if (auth()->user()->HasRole('affiliate'))
                      <li class="nav-item has-treeview">
                          <a href="#"
                              class="nav-link {{ Route::is('withdrawals.index.affiliate*') || Route::is('withdrawals.request*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-credit-card"></i>
                              <p>
                                  {{ __('Withdrawals Requests') }}
                                  <i class="fas fa-angle-left right"></i>
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('withdrawals.index.affiliate', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                                      class="nav-link {{ Route::is('withdrawals.index.affiliate*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Withdrawals Requests') }}</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('withdrawals.request', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                                      class="nav-link {{ Route::is('withdrawals.request*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('New withdrawal request') }}</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endif


                  @if (auth()->user()->HasRole('affiliate') ||
    auth()->user()->HasRole('vendor'))
                      <li class="nav-item has-treeview">
                          <a href="{{ route('messages.show', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                              class="nav-link {{ Route::is('messages.show*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-comments"></i>
                              <p>
                                  {{ __('Messages') }}
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                      </li>
                  @endif







                  @if (auth()->user()->hasPermission('users-read'))
                      <li
                          class="nav-item has-treeview {{ Route::is('users.index*') || Route::is('users.trashed*') ? 'menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ Route::is('users.index*') || Route::is('users.trashed*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-users"></i>
                              <p>
                                  {{ __('All Users') }}
                                  <i class="fas fa-angle-left right"></i>
                                  <span class="badge badge-info right">
                                      {{ $userscount - 1 }}
                                  </span>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ url(app()->getLocale() . '/dashboard/users') }}"
                                      class="nav-link {{ Route::is('users.index*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Users') }}</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('users.trashed', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('users.trashed*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Trashed Users') }}</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endif

                  @if (auth()->user()->hasPermission('roles-read'))
                      <li
                          class="nav-item has-treeview {{ Route::is('roles.index*') || Route::is('roles.trashed*') ? 'menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ Route::is('roles.index*') || Route::is('roles.trashed*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-user-tag"></i>
                              <p>
                                  {{ __('Roles') }}
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('roles.index', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('roles.index*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Roles for users') }}</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('roles.trashed', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('roles.trashed*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Trashed Roles') }}</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endif


                  @if (auth()->user()->hasPermission('countries-read'))
                      <li
                          class="nav-item has-treeview {{ Route::is('countries.index*') || Route::is('countries.trashed*') ? 'menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ Route::is('countries.index*') || Route::is('countries.trashed*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-globe"></i>
                              <p>
                                  {{ __('Countries') }}
                                  <i class="fas fa-angle-left right"></i>

                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('countries.index', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('countries.index*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Countries') }}</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('countries.trashed', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('countries.trashed*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Trashed Countries') }}</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endif


                  @if (auth()->user()->hasPermission('categories-read'))
                      <li
                          class="nav-item has-treeview {{ Route::is('categories.index*') || Route::is('products.index*') || Route::is('products.trashed*')? 'menu-open': '' }}">
                          <a href="#"
                              class="nav-link {{ Route::is('categories.index*') || Route::is('products.index*') || Route::is('products.trashed*')? 'active': '' }}">
                              <i class="nav-icon fas fa-sitemap"></i>
                              <p>
                                  {{ __('Products') }}
                                  <i class="fas fa-angle-left right"></i>

                              </p>
                          </a>

                          <ul class="nav nav-treeview">
                              @if (auth()->user()->hasPermission('categories-read'))
                                  <li class="nav-item">
                                      <a href="{{ route('categories.index', ['parent' => 'null', 'lang' => app()->getLocale()]) }}"
                                          class="nav-link {{ Route::is('categories.index*') ? 'active' : '' }}">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>{{ __('Categories') }}</p>
                                      </a>
                                  </li>
                              @endif

                              @if (auth()->user()->hasPermission('products-read'))
                                  <li class="nav-item">
                                      <a href="{{ route('products.index', app()->getLocale()) }}"
                                          class="nav-link {{ Route::is('products.index*') ? 'active' : '' }}">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>{{ __('Products') }}</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('products.trashed', app()->getLocale()) }}"
                                          class="nav-link {{ Route::is('products.trashed*') ? 'active' : '' }}">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>{{ __('Trashed Products') }}</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>

                      </li>
                  @endif



                  @if (auth()->user()->hasPermission('all_orders-read'))
                      <li
                          class="nav-item has-treeview  {{ Route::is('all_orders.index*') || Route::is('orders-all-vendors*') || Route::is('stock.orders*')? 'menu-open': '' }}">
                          <a href="#"
                              class="nav-link {{ Route::is('all_orders.index*') || Route::is('orders-all-vendors*') || Route::is('stock.orders*')? 'active': '' }}">
                              <i class="nav-icon fas fa-list-alt"></i>
                              <p>
                                  {{ __('Orders') }}
                                  <i class="fas fa-angle-left right"></i>

                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('all_orders.index', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('all_orders.index*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('All Orders') }}</p>
                                  </a>
                              </li>

                              <li class="nav-item">
                                  <a href="{{ route('orders-all-vendors', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('orders-all-vendors*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Vendors Orders') }}</p>
                                  </a>
                              </li>

                              <li class="nav-item">
                                  <a href="{{ route('stock.orders', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('stock.orders*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Stock orders') }}</p>
                                  </a>
                              </li>
                              {{-- <li class="nav-item">
                    <a href="{{route('all_orders.index' , ['lang' => app()->getLocale() , 'status' => 'pending'])}}" class="nav-link {{ Route::is('settings*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('Pending Orders')}}</p>
                      </a>
                </li>



                <li class="nav-item">
                    <a href="{{route('all_orders.index' , ['lang' => app()->getLocale() , 'status' => 'confirmed'])}}" class="nav-link {{ Route::is('settings*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('Confirmed Orders')}}</p>
                      </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('all_orders.index' , ['lang' => app()->getLocale() , 'status' => 'on the way'])}}" class="nav-link {{ Route::is('settings*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('On the way Orders')}}</p>
                      </a>
                </li>


                <li class="nav-item">
                    <a href="{{route('all_orders.index' , ['lang' => app()->getLocale() , 'status' => 'delivered'])}}" class="nav-link {{ Route::is('settings*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('delivered Orders')}}</p>
                      </a>
                </li>


                <li class="nav-item">
                    <a href="{{route('all_orders.index' , ['lang' => app()->getLocale() , 'status' => 'canceled'])}}" class="nav-link {{ Route::is('settings*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('Canceled Orders')}}</p>
                      </a>
                </li>


                <li class="nav-item">
                    <a href="{{route('all_orders.index' , ['lang' => app()->getLocale() , 'status' => 'in the mandatory period'])}}" class="nav-link {{ Route::is('settings*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('in the mandatory period')}}</p>
                      </a>
                </li>


                <li class="nav-item">
                    <a href="{{route('all_orders.index' , ['lang' => app()->getLocale() , 'status' => 'returned'])}}" class="nav-link {{ Route::is('settings*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('returned')}}</p>
                      </a>
                </li> --}}

                          </ul>
                      </li>
                  @endif


                  @if (auth()->user()->hasPermission('shipping_rates-read'))
                      <li
                          class="nav-item has-treeview {{ Route::is('shipping_rates.index*') || Route::is('shipping_rates.trashed*') ? 'menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ Route::is('shipping_rates.index*') || Route::is('shipping_rates.trashed*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-truck"></i>
                              <p>
                                  {{ __('Shipping Rates') }}
                                  <i class="fas fa-angle-left right"></i>

                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('shipping_rates.index', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('shipping_rates.index*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Shipping Rates') }}</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('shipping_rates.trashed', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('shipping_rates.trashed*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Trashed shipping rates') }}</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endif


                  @if (auth()->user()->hasPermission('bonus-read'))
                      <li class="nav-item has-treeview {{ Route::is('bonus.index*') ? 'menu-open' : '' }}">
                          <a href="{{ route('bonus.index', app()->getLocale()) }}"
                              class="nav-link {{ Route::is('bonus.index*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-money-bill"></i>
                              <p>
                                  {{ __('Bonus') }}
                              </p>
                          </a>
                      </li>
                  @endif


                  @if (auth()->user()->hasPermission('colors-read'))
                      <li
                          class="nav-item has-treeview {{ Route::is('colors.index*') || Route::is('colors.trashed*') ? 'menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ Route::is('colors.index*') || Route::is('colors.trashed*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-paint-brush"></i>
                              <p>
                                  {{ __('Colors') }}
                                  <i class="fas fa-angle-left right"></i>

                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('colors.index', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('colors.index*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Colors') }}</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('colors.trashed', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('colors.trashed*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Trashed Colors') }}</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endif


                  @if (auth()->user()->hasPermission('sizes-read'))
                      <li
                          class="nav-item has-treeview {{ Route::is('sizes.index*') || Route::is('sizes.trashed*') ? 'menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ Route::is('sizes.index*') || Route::is('sizes.trashed*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-th-large"></i>
                              <p>
                                  {{ __('Sizes') }}
                                  <i class="fas fa-angle-left right"></i>

                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('sizes.index', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('sizes.index*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Sizes') }}</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('sizes.trashed', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('sizes.trashed*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Trashed Sizes') }}</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endif


                  @if (auth()->user()->hasPermission('slides-read'))
                      <li
                          class="nav-item has-treeview {{ Route::is('slides.index*') || Route::is('slides.trashed*') ? 'menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ Route::is('slides.index*') || Route::is('slides.trashed*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-images"></i>
                              <p>
                                  {{ __('Slides') }}
                                  <i class="fas fa-angle-left right"></i>

                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('slides.index', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('slides.index*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Slides') }}</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('slides.trashed', app()->getLocale()) }}"
                                      class="nav-link {{ Route::is('slides.trashed*') ? 'active' : '' }}">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>{{ __('Trashed Slides') }}</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endif


                  @if (auth()->user()->hasPermission('withdrawals-read'))
                      <li class="nav-item has-treeview">
                          <a href="{{ route('withdraw.admin', ['lang' => app()->getLocale()]) }}"
                              class="nav-link {{ Route::is('withdraw.admin*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-credit-card"></i>
                              <p>
                                  {{ __('Withdrawals Requests') }}
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                      </li>
                  @endif


                  @if (auth()->user()->hasPermission('logs-read'))
                      <li class="nav-item has-treeview">
                          <a href="{{ route('logs.index', app()->getLocale()) }}"
                              class="nav-link {{ Route::is('logs.index*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-file"></i>
                              <p>
                                  {{ __('Logs') }}

                              </p>
                          </a>
                      </li>
                  @endif


                  @if (auth()->user()->hasPermission('messages-read'))
                      <li class="nav-item has-treeview">
                          <a href="{{ route('messages.admin.show', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                              class="nav-link {{ Route::is('messages.admin.show*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-comments"></i>
                              <p>
                                  {{ __('Messages') }}
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                      </li>
                  @endif



                  <li class="nav-item has-treeview">
                      <a href="{{ route('notification-show', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                          class="nav-link {{ Route::is('notification-show*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-bell"></i>
                          <p>
                              {{ __('Notifications') }}
                              {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                          </p>
                      </a>
                  </li>



                  @if (auth()->user()->hasPermission('finances-read'))
                      <li class="nav-item has-treeview mb-4">
                          <a href="{{ route('finances.index', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                              class="nav-link {{ Route::is('finances.index*') ? 'active' : '' }}">
                              <i class="nav-icon fa fa-credit-card"></i>
                              <p>
                                  {{ __('Finances') }}
                                  {{-- <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span> --}}
                              </p>
                          </a>
                      </li>
                  @endif

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
