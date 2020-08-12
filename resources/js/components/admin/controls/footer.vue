<template>
	<div>
		<footer class="bg-dark text-center text-light">
			<div class="row">
				<div class="col-4">
					<ul class="nav justify-content-center">
						<li class="nav-item">
							<a class="nav-link active" href="#">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">About Us</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Contact Us</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Careers</a>
						</li>
					</ul>
				</div>
				<div class="col-4">Copyright {{ brand }} &copy; {{ dateYear.getFullYear() }}</div>
				<div class="col-4 text-capitalize">
					Powered by
					<a href="http://www.avion.co.ke" target="_blank" rel="noopener noreferrer">
						<span class="designer">Avion</span>
					</a>
				</div>
			</div>
			<p></p>
		</footer>
	</div>
</template>

<script>
export default {
	props: {
		brand: {
			type: String,
			required: true
		}
	},
	data() {
		return {
			dateYear: new Date()
		};
	}
};
</script>

<style scoped>
footer {
	margin-top: 2em;
	padding-top: 3em;
	padding-bottom: 3em;
	letter-spacing: 1px;
}
footer .nav-link {
	color: #f6e019;
}
footer .nav-link:hover {
	color: #3490dc;
}
.designer {
	color: #2bbc2b;
}
</style>
