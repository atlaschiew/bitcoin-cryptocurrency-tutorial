					<hr/>
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					
					<!-- The Modal -->
					<div class="modal" id="reportus_modal">
						<div class="modal-dialog">
							<div class="modal-content">

								<!-- Modal Header -->
								<div class="modal-header">
									<h4 class="modal-title">Report to us.</h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>

								<!-- Modal body -->
								<div class="modal-body">
									<form action="?action=reportus" method="POST">
										<div class="form-group">
											<label for="target">Target:</label>
											<input name="target" type="target" class="form-control" placeholder="Target" id="target" readonly value="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
										</div>
										<div class="form-group">
											<label for="message">Message:</label>
											<textarea name="message" rows=5 type="message" class="form-control" placeholder="Enter Message" id="message"><?php echo $_GET['action'] == 'reportus' ? htmlentities($_POST['message']) : ""?></textarea>
										</div>
										
										<div class="form-group">
											<label for="sender_email">Your Email:</label>
											<input name="sender_email" type="sender_email" class="form-control" placeholder="Email" id="sender_email" value="<?php echo $_GET['action'] == 'reportus' ? htmlentities($_POST['sender_email']) : ""?>">
										</div>
										
										<div class="form-group">
											<label for="captcha">CAPTCHA:</label>
											<img style='border:1px solid black' src='../verificationimage.php?key=CAPTCHA_REPORTUS'/>
											<input name="captcha" type="captcha" class="form-control" placeholder="CAPTCHA" id="captcha" value="">
										</div>
										
										<center>
											<button type="submit" class="btn btn-danger">Submit</button>
										</center>
									</form>
								</div>

							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3"><h5>Tutorials</h5></div>
						<div class="col-sm-3"><h5>About Us</h5></div>
						<div class="col-sm-3"><h5>Community</h5>
							<small>Error in this page? <a href='#' data-toggle="modal" data-target="#reportus_modal">Report</a> to us.</small>
							
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
								<?php echo $explaination['']?>
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
	<script src="../media/vendor/enlighter/js/enlighterjs.min.js?nocache=<?php echo time()?>"></script>
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
	
	iFrameResize({});
	
	</script>
</html>