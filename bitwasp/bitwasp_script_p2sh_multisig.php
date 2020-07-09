<?php
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Script\ScriptFactory;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$redeemScript = ScriptFactory::create()->op('OP_2')->push(Buffer::hex("04a882d414e478039cd5b52a92ffb13dd5e6bd4515497439dffd691a0f12af9575fa349b5694ed3155b136f09e63975a1700c9f4d4df849323dac06cf3bd6458cd"))->push(Buffer::hex("046ce31db9bdd543e72fe3039a1f1c047dab87037c36a669ff90e28da1848f640de68c2fe913d363a51154a0c62d7adea1b822d05035077418267b1a1379790187"))->push(Buffer::hex("0411ffd36c70776538d079fbae117dc38effafb33304af83ce4894589747aee1ef992f63280567f52f5ba870678b4ab4ff6c8ea600bd217870a8b4f1f09f3a8e83"))->op('OP_3')->op('OP_CHECKMULTISIG')->getScript();
?>
<div class='row'>
	<div class="col-sm-1">
		Hex 
	</div>
	<div class="col-sm-11">
		<textarea class="form-control" rows="3" readonly><?php echo $redeemScript->getHex();?></textarea>
		<a href='#hashtag1' onclick="javascript:$('input#redeem_script').val($(this).prev().val());setTimeout(function() { $('input#redeem_script').focus(); }, 500);">Insert</a>
	</div>
	<?php
	$opcodes = $redeemScript->getOpcodes();
	?>
	<div class="col-sm-1">
		Asm
	</div>					
	<div class="col-sm-11">
		<textarea class="form-control" rows="3" readonly>
<?php
$opcodes = $redeemScript->getOpcodes();
foreach( $redeemScript->getScriptParser()->decode() as $operation ) {
	
	try {
		$op = $opcodes->getOp($operation->getOp());
	} catch (\RuntimeException $e) {
		$op = "";
	}
	
	echo $op ? $op . " " : "";
	
	if ($op != 'OP_0' AND $operation->isPush()) {
		$bytes = (int)ltrim($op, 'OP_PUSHDATA');
		$bytes = $bytes > 0 ? $bytes : 1;
		
		$hexsize = Buffer::int($operation->getDataSize(), $bytes)->getHex();
		echo htmlentities("{$hexsize}<{$operation->getData()->getHex()}> ");
	} 
}
?>
		</textarea>

	</div>

	<div class="col-sm-12">
		<h6 class="mt-3" title="Spend requires ScriptSig to unlock unspent tx output.">Unlock Script (ScriptSig)</h6>
		
		<div class='vertical-line-green'>
			<div class='row'>
				<div class="col-sm-12">
					<?php echo htmlentities("OP_0 <Sig1> <Sig3> OP_PUSHDATA1 <redeemScript>")?>
				</div>
			</div>
			
			<div class='row'>
				<div class="col-sm-12">
					of course the following signature combination <?php echo htmlentities("<Sig1> <Sig2>")?>, <?php echo htmlentities("<Sig2> <Sig3>")?>,  <?php echo htmlentities("<Sig1> <Sig2> <Sig3>")?> are valid too.
				</div>
			</div>
		</div>
		<div class='row'>
			<?php
			$scriptSig = ScriptFactory::create()->op('OP_0')->push(Buffer::hex("30440220762ce7bca626942975bfd5b130ed3470b9f538eb2ac120c2043b445709369628022051d73c80328b543f744aa64b7e9ebefa7ade3e5c716eab4a09b408d2c307ccd701"))->push(Buffer::hex("3045022100abf740b58d79cab000f8b0d328c2fff7eb88933971d1b63f8b99e89ca3f2dae602203354770db3cc2623349c87dea7a50cee1f78753141a5052b2d58aeb592bcf50f01"))->push($redeemScript->getBuffer())->getScript();
			
			?>
			<div class="col-sm-1">
				Hex 
			</div>
			<div class="col-sm-11">
				<textarea class="form-control" rows="3" readonly><?php echo $scriptSig->getHex();?></textarea>
			</div>
		</div>
		<div class='row'>
			<div class="col-sm-1">
				Asm
			</div>
			<div class="col-sm-11">
				<textarea class="form-control" rows="3" readonly>
<?php
$opcodes = $scriptSig->getOpcodes();
foreach( $scriptSig->getScriptParser()->decode() as $operation ) {
	
	try {
		$op = $opcodes->getOp($operation->getOp());
	} catch (\RuntimeException $e) {
		$op = "";
	}
	
	echo $op ? $op . " " : "";
	
	if ($op != 'OP_0' AND $operation->isPush()) {
		$bytes = (int)ltrim($op, 'OP_PUSHDATA');
		$bytes = $bytes > 0 ? $bytes : 1;
		
		$hexsize = Buffer::int($operation->getDataSize(), $bytes)->getHex();
		echo htmlentities("{$hexsize}<{$operation->getData()->getHex()}> ");
	} 
}
?>
				</textarea>
			</div>
		</div>
	</div>
	
	<div class="col-sm-12">
		<h6 class="mt-3" title="scriptPubKey requires redeemScriptHash.">Lock Script (RedeemScriptHash)</h6>
		
		<div class='row'>
			<div class="col-sm-1">
				Hex 
			</div>
			<div class="col-sm-11"><textarea class="form-control" rows="1" readonly><?php echo $redeemScript->getScriptHash()->getHex()?></textarea>
			</div>
		</div>
	</div>
</div>
<?php
include_once("html_iframe_footer.php");