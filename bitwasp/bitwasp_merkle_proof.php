<?php

include_once "../libraries/vendor/autoload.php";
use BitWasp\Buffertools\Buffer;

$txid = "51a3dd31a49acb157d010f08e5c4774721d6dd39217866f2ed42d209b66a6ff6";

$merkle_proofs = [
['50ba87bdd484f07c8c55f76a22982f987c0465fdc345381b4634a70dc0ea0b38', 'left'],
['96b8787b1e3abed802cff132c891c2e511edd200b08baa9eb7d8942d7c5423c6', 'right'],
['65e5a4862b807c83b588e0f4122d4ca2d46691d17a1ec1ebce4485dccc3380d4', 'left'],
['1ee9441ddde02f8ffb910613cd509adbc21282c6e34728599f3ae75e972fb815', 'left'],
['ec950fc02f71fc06ed71afa4d2c49fcba04777f353a001b0bba9924c63cfe712', 'left'],
['5d874040a77de7182f7a68bf47c02898f519cb3b58092b79fa2cff614a0f4d50', 'left'],
['0a1c958af3e30ad07f659f44f708f8648452d1427463637b9039e5b721699615', 'left'],
['d94d24d2dcaac111f5f638983122b0e55a91aeb999e0e4d58e0952fa346a1711', 'left'],
['c4709bc9f860e5dff01b5fc7b53fb9deecc622214aba710d495bccc7f860af4a', 'left'],
['d4ed5f5e4334c0a4ccce6f706f3c9139ac0f6d2af3343ad3fae5a02fee8df542', 'left'],
['b5aed07505677c8b1c6703742f4558e993d7984dc03d2121d3712d81ee067351', 'left'],
['f9a14bf211c857f61ff9a1de95fc902faebff67c5d4898da8f48c9d306f1f80f', 'left']
];

$txid = "a3f3ac605d5e4727f4ea72e9346a5d586f0231460fd52ad9895bc8240d871def";
$merkle_proofs = [
['076d0317ee70ee36cf396a9871ab3bf6f8e6d538d7f8a9062437dcb71c75fcf9', 'right'],
['522db339c186c1149843a4848990e6ddb9a6065f4bc1422af53f4bc86f1b084a', 'right'],
['89189ff0316cdc10511da71da757e553cada9f3b5b1434f3923673adb57d83ca', 'right'],
['ac392c38af156d6fc30b55fad4112df2b95531e68114e9ad10011e72f7b7cfdb', 'right']
];


$merkle_root = "17663ab10c2e13d92dccb4514b05b18815f5f38af1f21e06931c71d62b36d8af";
$toBeConcatHash = $txid;//tx id in litle endian
foreach($merkle_proofs as $proof) {
	$hash = $proof[0];
	$dir = $proof[1];
	
	if ($dir == 'left') {
		$toBeConcatHash = hash('sha256', hex2bin(hash('sha256', hex2bin($hash.$toBeConcatHash))));
	} else {
		$toBeConcatHash = hash('sha256', hex2bin(hash('sha256', hex2bin($toBeConcatHash.$hash ))));
	}
}
$result = Buffer::hex($toBeConcatHash);

echo $result->flip()->getHex();

?>