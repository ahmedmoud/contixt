<aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="user-pro">
                            <a class="waves-effect waves-dark" aria-expanded="false">
                                <span class="hide-menu">{{ Auth::user()->name }}</span>
                            </a>
                        </li>
                         <li>
                            <a class="waves-effect waves-dark" href="{{ url('/admin/users/'.Auth::user()->id.'/edit-profile') }}">
                                <i class="icon-user"></i>
                                <span class="hide-menu">
                                   {{ __('admin.edit_profile') }}
                                </span>
                            </a>
                        </li>
                          <li>
                            <a class="waves-effect waves-dark" href="{{ url('/admin/search-posts/') }}">
                                <i class="icon-magnifier"></i>
                                <span class="hide-menu">
                                {{ __('admin.search') }}
                                </span>
                            </a> 
                        </li>
                        @can('view', 'posts')
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="icon-note"></i>
                                <span class="hide-menu">{{ __('admin.posts') }}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('view', 'others_posts')
                                <li><a href="{{ url('/admin/all-posts') }}">{{ __('admin.all_posts') }}</a></li>
                                @endcan
                                <li><a href="{{ url('/admin/posts') }}"> {{ __('admin.my_posts') }}</a></li>
                                 @can('create_publish', 'posts')
                                    <li><a href="{{ url('/admin/posts/create') }}">{{ __('admin.add_post') }}</a></li>
                                @endcan
                            </ul>
                        </li>
                        @endcan

                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="icon-folder"></i>
                                <span class="hide-menu">الكلمات الدلالية</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('create', 'keywords')
                                <li><a href="{{ url('/admin/keywords/create') }}">إضافة جديد</a></li>
                                @endcan
                                <li><a href="{{ url('/admin/keywords') }}">الكلمات الدلالية</a></li>
                                
                            </ul>
                        </li>

                        @can('view','edits')
                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('admin/posts-edits') }}" >
                            <i class="icon-pencil"></i>
                                <span class="hide-menu">{{ __('admin.postsEdits') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('/admin/categories/tree') }}">
                                <i class="icon-eye"></i>
                                <span class="hide-menu">
                                {{ __('admin.categories_tree') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @if( UPerm::ControlPostsFUpdates() )
                        <li>
                                <a class="waves-effect waves-dark" href="{{ url('admin/future-updates') }}" >
                                <i class="icon-energy"></i>
                                    <span class="hide-menu">التحديثات</span>
                                </a>
                            </li>
                            @endif
                            @if( UPerm::manageRedirections() )
                            <li>
                                    <a class="waves-effect waves-dark" href="{{ url('admin/redirection') }}" >
                                    <i class="icon-refresh"></i>
                                        <span class="hide-menu">تحويل الروابط</span>
                                    </a>
                                </li>
                                @endif
                        @can('view','categories')
                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('/admin/categories') }}">
                                <i class="icon-wallet"></i>
                                <span class="hide-menu">
                                {{ __('admin.categories') }}
                                </span>
                            </a>
                        </li>

                        @endcan
                        @can('manage','ads')
                     <li>
                         <a class="waves-effect waves-dark" href="{{ url('/admin/manage-ads') }}" aria-expanded="false">
                             <i class="icon-pin"></i>
                             <span class="hide-menu">{{ __('admin.ads') }}</span>
                         </a>
                     </li>
                     @endcan
                        @can('control','resala')
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="icon-envelope-open"></i>
                                <span class="hide-menu">{{ __('admin.setaat_msg') }}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{ url('/admin/resala') }}">{{ __('admin.all_setaat_msgs') }}</a></li>
                                <li><a href="{{ url('/admin/resala/create') }}"> {{ __('admin.add_new') }}</a></li>
                            </ul>
                        </li>
                        @endcan

                        @can('control','competitions')
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="icon-pin"></i>
                                <span class="hide-menu"> {{ __('admin.competitions') }}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{ url('/admin/competitions') }}"> {{ __('admin.show_all') }}</a></li>
                                <li><a href="{{ url('/admin/competitions/create') }}">{{ __('admin.add_new') }}</a></li>
                            </ul>
                        </li>
                        @endcan

                        @can('control','JoinUs')
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="icon-pin"></i>
                                <span class="hide-menu">{{ __('admin.join_us') }}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{ url('/admin/joinUs') }}">{{ __('admin.request') }}</a></li>
                            </ul>
                        </li>
                        @endcan


                        @can('control','users')
                     
                     <li>
                         <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                             <i class="icon-people"></i>
                             <span class="hide-menu">{{ __('admin.users') }}</span>
                         </a>
                         <ul aria-expanded="false" class="collapse">
                             <li><a href="{{ url('/admin/users') }}">{{ __('admin.admins') }}</a></li>
                         
                                 <li><a href="{{ url('/admin/users-outer') }}"> {{ __('admin.normal_users') }}</a></li>
                      
                         </ul>
                     </li>
                     @endcan

                        @can('control','roles')
                        <li>
                            <a class=" waves-effect waves-dark" href="{{ url('/admin/roles') }}" >
                                <i class="icon-pin"></i>
                                <span class="hide-menu">{{ __('admin.permissions') }}</span>
                            </a>
                        </li>
                        @endcan
                        @can('control','comments')
                        <li>
                            <a class=" waves-effect waves-dark" href="{{ url('/admin/comments') }}" >
                                <i class="icon-pin"></i>
                                <span class="hide-menu">{{ __('admin.comments') }}</span>
                            </a>
                        </li>
                        @endcan
                        @can('control','Autism')
                        <li>
                            <a class=" waves-effect waves-dark" href="{{ url('/admin/customTemplates/Autism') }}" >
                                <i class="icon-pin"></i>
                                <span class="hide-menu">Autism</span>
                            </a>
                        </li>
                        @endcan
                        @can('control','BreastCancer')
                        <li>
                            <a class=" waves-effect waves-dark" href="{{ url('/admin/customTemplates/breastCancer') }}" >
                                <i class="icon-pin"></i>
                                <span class="hide-menu">Breast Cancer</span>
                            </a>
                        </li>
                        @endcan
                        
                        @can('control', 'settings')
                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('/admin/settings') }}">
                                <i class="icon-settings"></i>
                                <span class="hide-menu">
                                {{ __('admin.settings') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('control', 'Ads')
                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('/admin/ads') }}">
                                <i class="icon-settings"></i>
                                <span class="hide-menu">
                                {{ __('admin.ads') }}
                                </span>
                            </a>
                        </li>
                        @endcan
 @can('control', 'nativeAds')
                         <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="icon-pin"></i>
                                <span class="hide-menu">Native Ads</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{ url('/admin/nativeAds/create') }}">{{ __('admin.add_new') }}</a></li>
                            
                                    <li><a href="{{ url('/admin/nativeAds') }}">{{ __('admin.show_all') }}  </a></li>
                            </ul>
                        </li>
@endcan
                        @can('control', 'settings')
                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('/admin/sidebar') }}">
                                <i class="icon-list"></i>
                                <span class="hide-menu">
                                {{ __('admin.sidebar') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                         @can('control', 'settings')
                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('/admin/menu') }}">
                                <i class="icon-menu"></i>
                                <span class="hide-menu">
                                {{ __('admin.menus') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('/logout') }}">
                                <i class="icon-logout"></i>
                                <span class="hide-menu">
                                {{ __('admin.logout') }}
                                </span>
                            </a>
                        </li>
                       
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
