<p class="h2">Graph returning Soon™</p>
@if (SHOW_GRAPH && App\have_name_data())
<div class="container">
	<div id="graph-wrapper">
		<!-- The graph -->
		<div class="loader"><i class="fa-solid fa-spinner-third fa-spin loader"></i></div><canvas id="graph" width="600" height="400"></canvas>
		<!-- end graph -->
	</div>
	<div class="notes row">
		<div class="col-lg-1"></div>
		<div class="col-lg">

			@php
				$min = 1880;
				$max = date('Y') - 1;
				$startValue = $max - 100;
			@endphp

			<div class="source note">Source: <a href="https://www.ssa.gov/oact/babynames/limits.html" target="_blank">Social Security Administration</a></div>

			<section id="trivia" class="grid md:grid-cols-4 lg:grid-cols-5 gap-8 p-8 md:p-0">
				<div></div>
				<div class="col-span-2 lg:col-span-3 grid md:grid-cols-2 p-8 md:grid-8 md:p-0">
					<div>
						<h4>Earliest Records:</h4>
						<dl class="trivia">
							<dt>...in <span data-id="earliest-f-year"></span> as a girl's name:</dt><dd>with <span data-id="earliest-f-num"></span> names</dd>
							<dt>...in <span data-id="earliest-m-year"></span> as a boy's name:</dt><dd>with <span data-id="earliest-m-num"></span> names</dd>
						</dl>
					</div>
					<div>
						<h4>Peak Years:</h4>
						<dl class="trivia">
							<dt>...in <span data-id="peak-f-year"></span> as a girl's name:</dt><dd>with <span data-id="peak-f-num"></span> names</dd>
							<dt>...in <span data-id="peak-m-year"></span> as a boy's name:</dt><dd>with <span data-id="peak-m-num"></span> names</dd>
						</dl>
					</div>
				</div>
				<div></div>
			</section>
			<form method="post" class="form note" id="refineGraph">

				<h4><label for="minyear" class="form-label">Change the Timespan</label></h4>
				{{-- <div class="range-wrap-outer no-touch"> --}}
					<span class="sublabel" data-year="start">{{ $min }}</span>
				<div data-type="slider" data-min="{{ $min }}" data-max="{{ $max }}" class="range-wrap" data-value="{{ $startValue }}"></div>
					<span class="sublabel" data-year="end">{{ $max }}</span>
				{{-- </div> --}}

				<input type="number" name="mobileMinYear" id="mobileMinYear" min="{{ $min }}" max="{{ $startValue }}" value="{{ $startValue }}" />
				<input type="number" name="mobileMaxYear" id="mobileMaxYear" min="{{ $startValue+1 }}" max="{{ $max }}" value="{{ $max }}" />
				<div class="graph-controls is-touch">
				</div>

				<button type="button" class="btn btn-primary d-block h4 mt-3" data-toggle="modal" data-target="#statsnotes-modal">
					About Stats
				</button>

			</form>
		</div>
		<div class="col-lg-1"></div>
	</div>
</div>
@endif
