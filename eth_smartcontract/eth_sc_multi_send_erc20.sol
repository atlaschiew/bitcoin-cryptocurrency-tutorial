pragma solidity ^0.4.17;

contract ERC20 {
    function transfer(address _recipient, uint256 _value) public returns (bool success);
    function balanceOf(address _owner) public view returns (uint balance);
}

contract BatchSendERC20 {
    address public owner;
    
    modifier onlyOwner(){
        require(msg.sender == owner);
        _;
    }
    
    constructor() public{
        owner = msg.sender;
    }
   
    //accept eth deposit
    function() external payable  {
        require(msg.data.length == 0); //to prevent invalid calls.
    }
    
    //getowner
    function getOwner() public view returns (address) {
        return owner;
    }
    
    //getbalance
    function getEthBalance() public view returns (uint256) {
        return address(this).balance;
    }
    
    //withdraw whole balance
    function withdrawEth() public onlyOwner{
        msg.sender.transfer(address(this).balance);
    }

    //withdraw whole erc20 token balance
    function withdraw(ERC20 token) public onlyOwner{
        token.transfer(msg.sender, token.balanceOf(address(this)));
    }
    
    function multiSendFixedAmount(ERC20 token, address[] recipients, uint256 values) public onlyOwner {
        for (uint256 i = 0; i < recipients.length; i++) {
           token.transfer(recipients[i], values);
        }
    }
    
    function multiSendArrayAmount(ERC20 token, address[] recipients, uint256[] values) public onlyOwner {
        for (uint256 i = 0; i < recipients.length; i++) {
           token.transfer(recipients[i], values[i]);
        }
    }
}