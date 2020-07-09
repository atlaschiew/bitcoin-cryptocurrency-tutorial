				
			</div>
			<!-- /#page-content-wrapper -->

		</div>
		<!-- /#wrapper -->
	</body>
	
	<script src="../media/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../media/vendor/enlighter/js/enlighterjs.min.js"></script>
	<!-- Menu Toggle Script -->
	<script type="text/javascript">
	$("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
	});
  
	// - highlight all pre + code tags (CSS3 selectors)
	// - use javascript as default language
	// - use theme "enlighter" as default theme
	// - replace tabs with 2 spaces
	EnlighterJS.init('pre', 'code', {
		language : 'php',
		theme: 'enlighter',
		indent : 4
	});

	$(document).ready(function(){		
		$('[data-toggle="tooltip"]').tooltip();
		
		$('#clickforfun').click(function() {
			EnlighterJS.Util.Helper(document.getElementById('clickforfun'), {
				language: 'php',
				renderer: 'Inline'
			});
		});
	});
	</script>
	<script type="text/javascript" src="../media/vendor/iframeresizer/js/iframeResizer.contentWindow.min.js"></script> 
</html>