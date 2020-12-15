<?php
$_HTML['title'] = 'Tron Protoc';
$_HTML['meta']['keywords'] = "Tron Protoc,Tron Protobuf in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Google Protocol Buffers (GPB)</h2>
<hr/>
	<p>
	ProtoBuf is a flexible and efficient language-independent structured data representation method that can be used to represent communication protocols and data storage. Compared to XML, ProtoBuF is smaller, faster and simpler. You can use the ProtoBuf compiler to generate source code for specific languages (such as C++, Java, Python, etc., ProtoBuf currently supports mainstream programming languages) for serialization and deserialization.
	</p>
	
	<p>
		Tron applies GPB-message standard to communicate with tron network, such as generate signed raw tx with transfer contract and broadcast to network.
	</p>
	
<hr/>

<h3>Steps to install Protocol Buffer Compiler (protoc)</h3>
<ol>
	<li>
		Download protoc from <a href="https://github.com/protocolbuffers/protobuf/releases">release repository</a>.
<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
#create a directory to house protoc
$ mkdir protoc

$ cd protoc

#btcschools.net applied protoc v3.14.0 with linux os and x86_64 architeture
$ wget https://github.com/protocolbuffers/protobuf/releases/download/v3.14.0/protoc-3.14.0-linux-x86_64.zip
</pre>
	</li>
	
	<li>
Extract zip file 	

<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
$ unzip protoc-3.14.0-linux-x86_64.zip
</pre>
	</li>
	
	<li>
		Tell protoc version
<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">		
$ cd bin

$ ./protoc --version
# this will output libprotoc 3.14.0
</pre>
	</li>
</ol>

<h3>Steps to download tron's message scheme</h3>
<ol>
	<li>
		Download wallet-CLI
<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
$ git clone https://github.com/tronprotocol/wallet-cli
# a wallet-cli folder will be created automatically
</pre>
	</li>
	
	
	<li>
		Check tron's message scheme
<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">		
$ ls wallet-cli/src/main/protos/core
#You will see many different raw message
</pre>
	</li>
</ol>

<h3>Build PHP scripts from compiling tron's message scheme</h3>
<ol>
	
	<li>
		Compile all required *.proto and output to desired path. Absolute path applied for ease of maintenance.
<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">		
#compile Discover.proto
$ /home/btcschools/protoc/bin/protoc --proto_path='/home/btcschools/wallet-cli/src/main/protos' --php_out='/home/btcschools/public_html/tron/protobuf/core' core/Discover.proto

#compile Tron.proto
$ /home/btcschools/protoc/bin/protoc --proto_path='/home/btcschools/wallet-cli/src/main/protos' --php_out='/home/btcschools/public_html/tron/protobuf/core' core/Tron.proto

#compile TronInventoryItems.proto
$ /home/btcschools/protoc/bin/protoc --proto_path='/home/btcschools/wallet-cli/src/main/protos' --php_out='/home/btcschools/public_html/tron/protobuf/core' core/TronInventoryItems.proto

#compile all system contract's proto files
$ /home/btcschools/protoc/bin/protoc --proto_path='/home/btcschools/wallet-cli/src/main/protos' --php_out='/home/btcschools/public_html/tron/protobuf/core/contract' core/contract/*.proto
</pre>
	</li>
</ol>


<?php
include_once("html_footer.php");