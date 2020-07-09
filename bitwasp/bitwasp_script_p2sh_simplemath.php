<?php
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Script\ScriptFactory;

include_once "../libraries/vendor/autoload.php";

include_once("html_iframe_header.php");
?>
<div class='row'>
	<?php
	$redeemScript = ScriptFactory::create()->op('OP_5')->op('OP_ADD')->op('OP_6')->op('OP_EQUAL')->getScript();
	?>
	<div class="col-sm-12">
		<h6 class="mt-3" title="Redeem script plays important roles in both lock and unlock tx. That is, unlock tx requires redeem script while lock tx requires redeem script hash.">Redeem Script</h6>
		
		<div class='row'>
			<div class="col-sm-1">
				Hex 
			</div>
			<div class="col-sm-11">
				<textarea class="form-control" rows="1" readonly><?php echo $redeemScript->getHex();?></textarea> <a href='#hashtag1' onclick="javascript:parent.moveData($(this).prev().val(),'iframe_p2sh_address', 'redeem_script')">Insert</a>
			</div>
		</div>
		
		<div class='row'>
			<?php
			$opcodes = $redeemScript->getOpcodes();
			?>
			<div class="col-sm-1">
				Asm
			</div>                    
			<div class="col-sm-11"><textarea class="form-control" rows="1" readonly>
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
		</div>
	</div>
	
	<div class="col-sm-6">
		<h6 class="mt-3" title="Spend requires ScriptSig to unlock unspent tx output.">Unlock Script (ScriptSig)</h6>
		<div class='row'>
			<?php
			$scriptSig = ScriptFactory::create()->op('OP_1')->push($redeemScript->getBuffer())->getScript();
			?>
			<div class="col-sm-1">
				Hex 
			</div>
			<div class="col-sm-11"><textarea class="form-control" rows="1" readonly><?php echo $scriptSig->getHex();?></textarea>
			</div>
		</div>
		
		<div class='row'>
			
			<div class="col-sm-1">
				Asm
			</div>
			<div class="col-sm-11">
				<textarea class="form-control" rows="1" readonly>
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
	
	<div class="col-sm-6">
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