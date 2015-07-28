 {include file="admin/partials/header.tpl"}

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Contacts</h1>

                        {if isset($table)}
                            {$table}
						{/if}

                        {if isset($form)}
                            <a href="{$HTTP_ROOT}admin/contact" class="btn btn-default">{t}Back{/t}</a>
                            <hr>

                            {$form}
                        {/if}

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->

{include file="admin/partials/footer.tpl"}