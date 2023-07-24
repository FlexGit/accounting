<div id="sidebar-nav" class="sidebar">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<li><a href="/" class="@if (Request::segment(1) === '') active @endif"><i class="lnr lnr-home"></i> <span>Главная</span></a></li>
				<li><a href="/operation" class="@if (Request::segment(1) === 'operation') active @endif"><i class="lnr lnr-layers"></i> <span>Операции</span></a></li>
				<li><a href="/category" class="@if (Request::segment(1) === 'category') active @endif"><i class="lnr lnr-book"></i> <span>Категории операций</span></a></li>
				<li><a href="/template" class="@if (Request::segment(1) === 'template') active @endif"><i class="lnr lnr-book"></i> <span>Шаблоны операций</span></a></li>
			</ul>
		</nav>
	</div>
</div>
