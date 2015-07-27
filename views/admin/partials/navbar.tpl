<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">SB Admin v2.0</a>
            </div>
            <!-- /.navbar-header -->

            {*include file="admin/partials/topbar.tpl"*}

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <form id="form-search" action="{$HTTP_ROOT}admin/search" method="GET">
                                <div class="input-group custom-search-form">
                                    <input name="search" type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <!-- /input-group -->
                        </li>


                        {foreach $pages as $page_url => $page_params}
                        <li><a href="{$HTTP_ROOT}{$page_url}"{if $page_url == $current_page} class="active"{/if}><i class="fa {$page_params[1]} fa-fw"></i> {$page_params[0]}</a></li>
                        {/foreach}

                        <!--
                        <li class="active">
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Level 1<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a class="active" href="#">Level 2 - 1</a></li>
                                <li><a class="active" href="#">Level 2 - 2</a></li>
                            </ul>
                        </li>
                        -->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>