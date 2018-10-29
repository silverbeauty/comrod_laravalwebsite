<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ route('admin::getIndex') }}">Comroads Admin</a>
    </div>
    
    <ul class="nav navbar-top-links navbar-right">
        <li><a href="{{ route('upload::getVideo') }}"><i class="fa fa-cloud-upload"></i> Upload</a></li>
        <li><a href="{{ route('admin::getFlushCache') }}"><i class="fa fa-trash-o"></i> Flush Cache</a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="{{ route('home') }}" target="_blank"><i class="fa fa-globe fa-fw"></i> Visit Website</a>
                </li>                
                <li class="divider"></li>
                <li>
                    <a href="{{ route('auth::getLogout') }}">
                        <i class="fa fa-sign-out fa-fw"></i> Logout
                    </a>
                </li>
            </ul>            
        </li>        
    </ul>

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                {{--<li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>                    
                </li>--}}
                @can('manage_users', $user)
                    <li>
                        <a href="{{ route('admin::getIndex') }}">
                            <i class="fa fa-dashboard fa-fw"></i> Dashboard
                        </a>
                    </li>
                @endcan
                @can('manage_content', $user)
                    <li>
                        <a>
                            <i class="fa fa-camera-retro fa-fw"></i> Contents <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="{{ route('admin::getContents', ['published']) }}">
                                    Published
                                    <span class="badge pull-right">{{ total_published_contents() }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin::getContents', ['private']) }}">
                                    Private
                                    <span class="badge pull-right">{{ total_private_contents() }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin::getContents', ['app']) }}">
                                    App
                                    <span class="badge pull-right">{{ total_app_contents() }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin::getContents', ['pending']) }}">
                                    Pending
                                    <span class="badge pull-right">{{ total_pending_contents() }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin::getContents', ['deleted']) }}">
                                    Deleted
                                    <span class="badge pull-right">{{ total_deleted_contents() }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin::getUnencodedContents', ['published']) }}">
                                    Unencoded
                                    <span class="badge pull-right">{{ total_unencoded_contents() }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin::getMultipleViolations') }}">
                                    Multiple Violations
                                    <span class="badge pull-right">{{ total_multiple_violations() }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin::getInactiveEmbed') }}">
                                    Inactive Embed
                                    <span class="badge pull-right">{{ total_inactive_embed() }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin::getReportedContents') }}">
                                    Reported
                                    <span class="badge pull-right">{{ total_reported_contents() }}</span>
                                </a>
                            </li>                        
                        </ul>
                    </li>
                @endcan
                @can('manage_content', $user)
                    <li>
                        <a>
                            <i class="fa fa-bolt fa-fw"></i> Live Feeds <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="{{ route('admin::getAddLiveFeed') }}">
                                    Add                                    
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin::getLiveFeeds') }}">
                                    Published
                                    <span class="badge pull-right">{{ total_live_feeds() }}</span>                                    
                                </a>
                            </li>                                                                              
                        </ul>
                    </li>
                @endcan
                @can('manage_suggest_locations', $user)
                    <li>
                        <a href="{{ route('admin::getSuggestedLocations') }}">
                            <i class="fa fa-thumb-tack fa-fw"></i> Suggested Localtions
                            <span class="badge pull-right">{{ total_suggested_locations() }}</span>                            
                        </a>
                    </li>
                @endcan
                @can('manage_users', $user)
                    <li>
                        <a href="{{ route('admin::getUsers') }}">
                            <i class="fa fa-users fa-fw"></i> Users
                            <span class="badge pull-right">{{ total_users() }}</span>
                        </a>
                    </li>
                @endcan
                @can('manage_comments', $user)
                    <li>
                        <a href="{{ route('admin::getComments') }}">
                            <i class="fa fa-comments fa-fw"></i> Comments
                            <span class="badge pull-right">{{ total_comments() }}</span>
                        </a>
                    </li>
                @endcan
                @can('manage_translators', $user)
                    <li>
                        <a href="{{ route('admin::getTranslators') }}">
                            <i class="fa fa-globe fa-fw"></i> Translators
                        </a>
                    </li>
                @endcan
                @can('translate', $user)
                    <li>
                        <a>
                            <i class="fa fa-language fa-fw"></i> Localization <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            @foreach (App\Language::all() as $language)
                                @if ($user->hasLanguage($language->locale) || $user->hasRole('super_admin'))
                                    <li>
                                        <a href="{{ route('admin::getLocalization', ['locale' => $language->locale]) }}">
                                            {{ $language->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endcan
                @can('manage_utilities', $user)
                    <li>
                        <a>
                            <i class="fa fa-cogs fa-fw"></i> Utilities <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="{{ route('admin::getLanguages') }}">
                                    Languages
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin::getAds') }}">
                                    Ads
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin::getPages') }}">
                                    Pages
                                </a>
                            </li>                           
                        </ul>
                    </li>
                @endcan
                @can('manage_roles', $user)
                    <li>
                        <a href="{{ route('admin::getRolesPermissions') }}">
                            <i class="fa fa-graduation-cap fa-fw"></i> Roles & Permissions
                        </a>
                    </li>
                @endcan               
            </ul>
        </div>        
    </div>    
</nav>