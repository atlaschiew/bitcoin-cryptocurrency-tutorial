<?php 
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\Opcodes;
use BitWasp\Buffertools\Buffer;
include_once "../libraries/vendor/autoload.php";

$operators = array("+", "-"); //* and / have been disabled

if ($_GET['ajax'] == '1') {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		try {
			$data = ['error'=>''];
			
			if (!(ctype_digit($_POST['operand1']) AND ctype_digit($_POST['operand2']))) {
				throw new Exception("Operand must be integer.");
			} else {
				$operand1 = (int)$_POST['operand1'];
				$operand2 = (int)$_POST['operand2'];
			}
			
			if ($_POST['operator'] == '+') {
				$result = $operand1 + $operand2;
				$op = 'OP_ADD';
			} else if ($_POST['operator'] == '-') {
				$result = $operand1 - $operand2;
				$op = 'OP_SUB';
			} else if ($_POST['operator'] == '*') {
				$result = $operand1 * $operand2;
				$op = 'OP_MUL';
			} else if ($_POST['operator'] == '/') {
				$result = $operand1 / $operand2;
				$op = 'OP_DIV';
			} else {
				throw new Exception("Invalid operator.");
			}
			
			if (!is_integer($result)) {
				throw new Exception("Equal result must be integer.");
			}
			
			if ($result < 0 ) {
				throw new Exception("Equal result must be positive number.");
			}
			
			$scriptPubKey = ScriptFactory::create()->int($operand2)->op($op)->int($result)->op('OP_EQUAL')->getScript();
			$scriptSig = ScriptFactory::create()->int($operand1)->getScript();
			
			$data['result']  = $result;
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
	<div class="form-group">
		<label for="scriptsig">Math:</label>
		<div class="form-row">
		
			<div class="form-group col-sm-1">
				<input class="form-control" type='text' name='operand1' id='operand1' value='<?php echo $_POST['operand1']?>' placeholder="Operand#1 (Integer)">
			</div>
			
			<div class="form-group col-sm-1">
				<select id="operator" name="operator" class="form-control" >
				<?php
				foreach($operators as $operator) {
					echo "<option value='{$operator}'".($operator == $_POST['operator'] ? " selected": "").">{$operator}</option>";
				}
				?>
				</select>
			</div>
			
			<div class="form-group col-sm-1">
				<input class="form-control" type='text' name='operand2' id='operand2' value='<?php echo $_POST['operand2']?>' placeholder="Operand#2 (Integer)">
			</div>
			
			<div class="form-group col-sm-1">
				=
			</div>
			
			<div class="form-group col-sm-1">
				 <input class="form-control" type='text' name='result' id='result' placeholder="Result" readonly>
			</div>
			
			<div class="form-group col-sm-7" id='msg' style='color:red'>
			
			</div>
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