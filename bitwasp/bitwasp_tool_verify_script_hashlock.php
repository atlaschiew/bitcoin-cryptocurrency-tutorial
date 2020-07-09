<?php 
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Crypto\Hash;
use BitWasp\Bitcoin\Script\Opcodes;
use BitWasp\Buffertools\Buffer;
include_once "../libraries/vendor/autoload.php";

if ($_GET['ajax'] == '1') {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		try {
			$data = ['error'=>''];
			
			if (empty($_POST['preimage'])) {
				throw new Exception("Preimage cannot be empty.");
			} 
			
			$preimage = new Buffer($_POST['preimage']);
			$hash = Hash::sha256($preimage);
			
			$scriptPubKey = ScriptFactory::create()->op('OP_SHA256')->push($hash)->op('OP_EQUAL')->getScript();
			$scriptSig = ScriptFactory::create()->push($preimage)->getScript();
			
			$data['scriptPubKey'] = $scriptPubKey->getHex();
			$data['scriptSig'] = $scriptSig->getHex();
		} catch (Exception $e) {
			$data['error'] = $e->getMessage();
		}

		die(json_encode($data));
	}
}

include_once("html_iframe_header.php");
?>
<form id='this_form' action='' method='post'>
	<label for="preimage">Preimage:</label>
	<div class="form-row">
		<div class="form-group col-sm-6">
			<input class="form-control" type='text' name='preimage' id='preimage' value='<?php echo $_POST['preimage']?>' placeholder="">
		</div>
		
		<div class="form-group col-sm-6" id='msg' style='color:red'>
			
		</div>
	</div>
	
	<div class="form-group">
		<label for="scriptsig">ScriptSig:</label>
		<textarea id='scriptsig' class="form-control" rows="1" readonly></textarea>
	</div>
	
	<div class="form-group">
		<label for="scriptpubkey">ScriptPubKey:</label>
		<textarea id='scriptpubkey' class="form-control" rows="1" readonly></textarea>
	</div>
	
	<a href='#hashtag1' onclick="javascript:parent.moveData($('textarea#scriptsig').val(),'iframe_verify_form', 'script_sig');parent.moveData($('textarea#scriptpubkey').val(),'iframe_verify_form', 'script_pub_key')">Insert</a>
</form>
<script>
	jQuery(document).ready(function() {
		$('#this_form').on('keyup change paste', 'input, select, textarea', function(){
			var self = $(this);
			$.ajax({
				url: '?ajax=1', 
				data:  $('#this_form :input'),
				type: 'post',
				success:function(result){
					try {
						j = eval('(' + result + ')');
						
						if (j.error.length >0) {
							$('#msg').html(j.error);
							$('#result').val('Error');
							$('textarea#scriptpubkey').val('Error');
							$('textarea#scriptsig').val('Error');
						} else {
							$('#msg').html('');
							$('#result').val(j.result);
							$('textarea#scriptpubkey').val(j.scriptPubKey);
							$('textarea#scriptsig').val(j.scriptSig);
						}
						
					} catch(e) {
						alert('Invalid Json Format.');
					}
				}
			});
		});
	});
</script>
<?php 
include_once("html_iframe_footer.php");