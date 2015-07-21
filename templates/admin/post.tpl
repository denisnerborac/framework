 {include file="admin/partials/header.tpl"}

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Posts</h1>

						<table class="table table-striped table-bordered table-hover" id="data-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Author</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            {$i = 0}
                            {foreach $posts as $post}
								<tr class="{if $i % 2 === 0}odd{else}even{/if}">
                                    <td>{$post->title}</td>
                                    <td>{$post->date}</td>
                                    <td>{$post->author}</td>
                                    <td class="center">
                                  		<a href=""><i class="fa fa-pencil fa-fw"></i></a>
                                  		<a href=""><i class="fa fa-trash fa-fw"></i></a>
                                    </td>
                                </tr>
                                {assign var=i value=$i + 1}
		                    {/foreach}
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->

{include file="admin/partials/footer.tpl"}