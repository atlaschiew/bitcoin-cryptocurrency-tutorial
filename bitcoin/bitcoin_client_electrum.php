<?php
$_HTML['title'] = 'Tron Protoc';
$_HTML['meta']['keywords'] = "Bitcoin Electrum Linux,Bitcoin Electrum Linux Installation";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Electrum Installation (Linux)</h2>
<hr/>
	<p>
	Electrum is a lightweight Bitcoin client, based on a client-server protocol.
	</p>
	
	<p>
		Steps below is install on Centos7.
	</p>
	
<hr/>

<h3>Steps By Steps</h3>
<ol>
	<li>Open a Terminal and add the repository to your Yum install.		
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
$ yum install -y https://centos7.iuscommunity.org/ius-release.rpm
		</pre>
	</li>
	
	<li>
		Update Yum to finish adding the repository.
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
$ yum update
		</pre>
	</li>
	
	<li>
		Install python and relevant packages.
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
$ yum install -y python36u python36u-libs python36u-devel python36u-pip
		</pre>
	</li>
	
	<li>
		Test your python version.
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
$ python3.6 -V
		</pre>
	</li>
	
	<li>
		Install pyqt5 package through PIP, PIP is native Python package management tool.
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
$ pip3 install pyqt5		
		</pre>
	</li>
	
	<li>
		Download and install electrum.
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
$ cd /usr/src
$ wget https://download.electrum.org/3.3.8/Electrum-3.3.8.tar.gz
$ python3 -m pip install --user Electrum-3.3.8.tar.gz		
		</pre>
	</li>
	
	<li>
		Electrum command not found?
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
$ ln -s ~/.local/bin/electrum /usr/local/bin/electrum
		</pre>
	</li>
	
	<li>
		Start electrum in daemon
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
#mainnet
$ electrum daemon start   
		
#testnet
$ electrum daemon start --testnet
		</pre>
	</li>
</ol>

<?php
include_once("html_footer.php");