<header class="banner flex flex-col md:flex-row items-center justify-between">
  <a class="brand" href="{{ home_url('/') }}">
    {!! $siteName !!}
  </a>
	<nav class="text-center lg:text-right w-full px-8 pt-0 pb-2">
		<a href="/news/">News</a>
	</nav>
	<form id="searchform" class="by_name flex items-center gap-2 py-4 md:pt-0 pb-2">
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
