	</div><!-- /.container -->

	<footer class="blog-footer">
      <p>{$website_title} &copy; 2015</p>
      <p>
        <a href="#">{t}Back to top{/t}</a>
      </p>
    </footer>

    {include file="partials/debug.tpl"}

    {if !empty($themes)}
      {include file="partials/theme-switcher.tpl"}
    {/if}

	<script src="{$JS_ROOT}jquery.min.js"></script>
	<script src="{$JS_ROOT}bootstrap.min.js"></script>
</body>
</html>