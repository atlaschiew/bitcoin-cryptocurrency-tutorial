					<hr/>
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					
					
					<div class="row">
						<div class="col-sm-3"><h5>Tutorials</h5></div>
						<div class="col-sm-3"><h5>About Us</h5>
							<small>Contents have been open source in <a target="_blank" href="https://github.com/atlaschiew/btcschools">GITHUB</a>.</small>
						</div>
						<div class="col-sm-3"><h5>Community</h5>
							<small>Problem? Raise me a <a href="https://github.com/atlaschiew/btcschools/issues/new">new issue</a>.</small>
						</div>
						
						<div class="col-sm-3">
							<h5>Support Us</h5>
						
							<small>if you found this useful, please support us some coins.</small>
							
							<div class="row">
								<div class="col-sm-6">
									<img id='footer_btc' rel='<?php echo $settings['btc_address']?>' src='data:image/PNG;base64,<?php echo $settings['btc_address_qrcode']?>' style='width:150px;height:150px;display:none;'/>
									
									<img id='footer_eth' rel='<?php echo $settings['eth_address']?>' src='data:image/PNG;base64,<?php echo $settings['eth_address_qrcode']?>' style='width:150px;height:150px;display:none;'/>
									
									<img id='footer_lite' rel='<?php echo $settings['lite_address']?>' src='data:image/PNG;base64,<?php echo $settings['lite_address_qrcode']?>' style='width:150px;height:150px;display:none;'/>
								</div>
								<div class="col-sm-6">
									<select name='footer_coin' size="6" class="form-control" onchange="
									
										$('img[id^=footer_]').hide();
										var value = this.value;
										var imgElement = $('img#'+ value);
										imgElement.show();
										$('small#footer_address').html(imgElement.attr('rel'));
									">
										<option value="footer_btc">Bitcoin</option>
										<option value="footer_eth">Ethereum</option>
										<option value="footer_lite">Litecoin</option>
									</select>
								</div>
							</div>
							
							<small id='footer_address'></small>
						</div>
					</div>
					<hr/>
					<div class="row">
						<div class="col-sm-12">
							<small style='color:gray;'>
								BTCSCHOOLS would like to present you with more pratical but little theory throughout our tutorials. Pages' content are constantly keep reviewed to avoid mistakes, but we cannot warrant correctness of all contents. While using this site, you agree to accept our terms of use, cookie & privacy policy. Copyright 2019 by BTCSCHOOLS. All Rights Reserved.
							</small>
						</div>
					</div>
				</div>
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
		$('select[name=footer_coin]').val('footer_btc').trigger('change');
	});

	</script>
</html>

<?php echo ob_get_clean()?>