@if (SHOW_GRAPH && App\have_name_data())
<div class="container">
	<div id="graph-wrapper">
		<!-- The graph -->
		<div class="loader"><i class="fa-solid fa-spinner-third fa-spin loader"></i></div><canvas id="graph" width="600" height="400"></canvas>
		<!-- end graph -->
	</div>
	<div class="notes container px-4 lg:px-16">

		@php
			$min = 1880;
			$max = date('Y') - 1;
			$startValue = $max - 100;
		@endphp

		<div class="source note">Source: <a href="https://www.ssa.gov/oact/babynames/limits.html" target="_blank">Social Security Administration</a></div>

		<form method="post" class="form note" id="refineGraph">

			<h4><label class="form-label">Change the Timespan<span></span></label></h4>
			<div class="inner no-touch">
				<span class="sublabel" data-year="start">{{ $min }}</span>
			<div data-type="slider" data-min="{{ $min }}" data-max="{{ $max }}" class="range-wrap" data-value="{{ $startValue }}"></div>
				<span class="sublabel" data-year="end">{{ $max }}</span>
			</div>

			<div class="graph-controls is-touch">
				<input type="number" name="mobileMinYear" id="mobileMinYear" min="{{ $min }}" max="{{ $startValue }}" value="{{ $startValue }}" />
				<input type="number" name="mobileMaxYear" id="mobileMaxYear" min="{{ $startValue+1 }}" max="{{ $max }}" value="{{ $max }}" />
			</div>

			<button type="button" class="h4
			mt-5
			mx-auto
			px-6
			py-2.5
			bg-secondary
			font-normal
			text-whites
			leading-tight
			uppercase
			rounded
			shadow-md
			hover:bg-secondary-700 hover:shadow-lg
			focus:bg-secondary-700 focus:shadow-lg focus:outline-none focus:ring-0
			active:bg-secondary-800 active:shadow-lg
			transition
			duration-150
			ease-in-out" data-bs-toggle="modal" data-bs-target="#statsnotes-modal">
				About Stats
			</button>

		</form>

		<section id="trivia">
			<div class="col-span-2 mx-auto lg:col-span-3 grid md:grid-cols-2 p-8 md:grid-8 md:p-0">
				<div>
					<h4>Earliest Records:</h4>
					<dl class="trivia">
						<dt class="earliest-female">...in <span data-id="earliest-female-year"></span> as a girl's name:</dt>
							<dd class="earliest-female">with <span data-id="earliest-female-num"></span> names</dd>
						<dt class="earliest-male">...in <span data-id="earliest-male-year"></span> as a boy's name:</dt>
							<dd class="earliest-male">with <span data-id="earliest-male-num"></span> names</dd>
					</dl>
				</div>
				<div>
					<h4>Peak Years:</h4>
					<dl class="trivia">
						<dt class="peak-female">...in <span data-id="peak-female-year"></span> as a girl's name:</dt>
							<dd class="peak-female">with <span data-id="peak-female-num"></span> names</dd>
						<dt class="peak-male">...in <span data-id="peak-male-year"></span> as a boy's name:</dt>
							<dd class="peak-male">with <span data-id="peak-male-num"></span> names</dd>
					</dl>
				</div>
			</div>
		</section>
	</div>
</div>
@endif
