<?php
$_HTML['title'] = 'Ethereum Smart Contract Development Tool (Window Platform)';
$_HTML['meta']['keywords'] = "Ethereum Smart Contract Development Tool (Window Platform)";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Development Tool . Window Platform</h2>
<hr/>
	<p>
		Ethereum's DAPP development tool is not that friendly to beginner.
	</p>
<hr/>
<ul>
	<li>powershell</li>
	<li>nodejs</li>
	<li>npm</li>
	<li>trufflesuite</li>
	<li>ganache</li>
</ul>

<h3>Steps By Steps</h3>
<ol>
	<li>		
	In browser, please navigate to <a href="https://nodejs.org/en/download/">https://nodejs.org/en/download/</a> and Click "Windows Installer" under LTS tab. Run installation once download complete, go page by page and eventually click finish to succeed the installation.
	</li>
	
	<li>
		Please be noted that nodejs installation come with npm.
	</li>
	
	<li>
		Run powershell as administrator and verify version of nodejs and npm.
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
$ node –v
# v12.18.4 in my version

$ npm -v
# 6.14.6 in my version
		</pre>
	</li>
	
	<li>
		Install truffle.
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
$ npm install -g truffle

$ truffle version
# Truffle v5.1.47 (core: 5.1.47)
# Solidity v0.5.16 (solc-js)
# Node v12.18.4
# Web3.js v1.2.1
		</pre>
	</li>
	<li>
		Next, install a private blockchain name ganache. In browser, please navigate to https://www.trufflesuite.com/ganache and click on "Download (WINDOWS)". Finish all the common installation steps.
	</li>
	
	<li>
		Ok, now create your project directory, with directory name is helloworld. In powershell
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
# To create a bare Truffle project with no smart contracts included, use `truffle init`.
$ truffle init

# Once this operation is completed, you will see such project structure under your new created project directory.
    # contracts/: Directory for Solidity contracts
    # migrations/: Directory for scriptable deployment files
    # test/: Directory for test files for testing your application and contracts
    # truffle-config.js: Truffle configuration file
		</pre>
	</li>
	
	<li>
		Create a truffle-config.js script and put content below.
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
module.exports = {
	networks: {
		development: {
			host: "127.0.0.1",
			port: 7545,
			network_id: "*" // Match any network id
		}
	}
};
		</pre>
	</li>
	
	<li>
		Open ganache program and click on new workspace, add project and select truffle-config.js you have created previously. Lastly, save this new workspace and you will a private blockchain is running.
	</li>
	
	<li>
		Now navigate to project directory/contracts. Create a new file Helloworld.sol and paste codings below inside it.
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
pragma solidity >=0.4.22 <0.7.0;
/**
 * @title Helloworld
 * @dev Store & retrieve value in a variable
 */
contract Helloworld {

    uint256 number;

    /**
     * @dev Store value in variable
     * @param num value to store
     */
    function store(uint256 num) public {
        number = num;
    }

    /**
     * @dev Return value 
     * @return value of 'number'
     */
    function retrieve() public view returns (uint256){
        return number;
    }
}
		</pre>
	</li>
	
	<li>
		Create migration file
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
#make sure you have CD to project directory

$ truffle console 
$ create migration helloworld_migration 

#
#open and paste the following migration script inside it

		</pre>
		
	</li>
	
	<li>
		You will see a new file with name {timestamp}_helloworld_migration.js is created. Open and paste the following migration script inside it.
	
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
let Helloworld = artifacts.require("./Helloworld.sol");  
  
module.exports = function(deployer) {  
    deployer.deploy(Helloworld);  
};
		</pre>
	</li>
	<li>
		Now let's do migration to ganache. In powershell,
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
#make sure you have CD to project directory
$ Truffle Migrate 

#You will see a success message showing total deployments: 1
#In ganache, you will find out this new created contract under the "CONTRACTS" tab.
		</pre>
	</li>
	
	<li>
		Now we are going to demostrate how to interact with this newly created contract.
		<Pre data-enlighter-linenumbers="false" data-enlighter-theme="eclipse" style="background-color:#ccc;">
#make sure you have CD to project directory
#enter console
$ Truffle console 

#declare a contract instance
$ truffle(development)> let instance = await Helloworld.deployed()

#store 123
$ truffle(development)> instance.store(123)

#retrieve 123
$ truffle(development)> instance.retrieve()
		</pre>
	</li>
</ol>

<?php
include_once("html_footer.php");