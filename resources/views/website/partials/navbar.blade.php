@php
	$article = isset($article) ? $article : null;
	$locale_article = isset($locale_article) ? $locale_article : $article;
@endphp



<nav class="navbar navbar-expand-lg fixed-top">

	<div class="container">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
			{{icon('bars')}}
		</button>
		<a class="navbar-brand" href="{{ url_locale('/') }}">
			<img src="{{ asset('website/images/logo.png') }}" alt="{{ config('maguttiCms.website.option.app.name') }}" class="img-fluid">
		</a>
		<a class="navbar-call" href="tel:{{ config('maguttiCms.website.option.app.phone') }}">
			{{ icon('phone', 'fa-rotate-90') }}
		</a>

		<div id="navbar" class="collapse navbar-collapse">
			<ul class="navbar-nav ml-auto">
				{!! HtmlMenu::getBeforeNavbar() !!}
				{!! HtmlMenu::getArticlesLinks($article) !!}
				{!! HtmlMenu::getAuthLinks() !!}
				{!! HtmlMenu::getLanguageSelector($locale_article) !!}
				{!! HtmlMenu::getSocial() !!}
				{!! HtmlMenu::getAfterNavbar() !!}

			</ul>
		</div>
        <div id="navbar-cart" class="float-right">
            {!! HtmlMenu::getStoreLinks() !!}
        </div>

	</div>
</nav>
