<header class="banner flex flex-col md:flex-row items-center justify-between">
  <a class="brand" href="{{ home_url('/') }}">
    {!! $siteName !!}
  </a>
	<form class="by_name flex items-center gap-2 py-4 md:py-0">
		<label for="s">Search</label>
		<input type="search" id="s" name="s" value="" />
		<button><i class="fa-solid fa-magnifying-glass"></i></button>
	</form>

  @if (has_nav_menu('primary_navigation'))
    <nav class="nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
    </nav>
  @endif
</header>
