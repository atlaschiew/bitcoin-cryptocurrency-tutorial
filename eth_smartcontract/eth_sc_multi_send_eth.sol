pragma solidity ^0.5.0;


import "https://github.com/OpenZeppelin/openzeppelin-contracts/blob/v2.4.0/contracts/math/SafeMath.sol";

contract MultiSendEth  {
    
    using SafeMath for uint256;
   
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
    
    //get eth balance
    function getEthBalance() public view returns (uint256) {
        return address(this).balance;
    }
    
    //withdraw whole balance
    function withdraw() public onlyOwner{
        msg.sender.transfer(address(this).balance);
    }
    
    //batch send fixed eth amount from sender
    function multiSendFixedEth(address payable[] memory recipients, uint256 amount) public payable {
        
        require(recipients.length > 0);
        require(amount > 0);
        require(recipients.length * amount == msg.value);
        
        uint256 length = recipients.length;
        
        for(uint256 i=0;i<length;i++) {
            recipients[i].transfer(amount);
        }
    }   
    
    //batch send different eth amount from sender
    function multiSendDiffEth(address payable[] memory recipients, uint256[] memory amounts) public payable {
        require(recipients.length > 0);
        require(recipients.length == amounts.length);
        
        uint256 length = recipients.length;
        uint256 currentSum = 0;
        
        for (uint256 i = 0; i < length; i++) {
            uint256 amount = amounts[i];
            require(amount > 0);
            currentSum = currentSum.add(amount);
            require(currentSum <= msg.value);
           
            recipients[i].transfer(amount);
        }
        
    }
    
	
    //batch send fixed eth amount from contract
    function multiSendFixedEthFromContract(address payable[] memory recipients, uint256 amount) public onlyOwner {
        
        require(recipients.length > 0);
        require(amount > 0);
        require(recipients.length * amount <= address(this).balance);
        
        uint256 length = recipients.length;
		
        for(uint256 i=0;i<length;i++) {
            recipients[i].transfer(amount);
        }
    }    
    
    //batch send different eth amount from contract
    function multiSendDiffEthFromContract(address payable[] memory recipients, uint256[] memory amounts) public onlyOwner {
        
        require(recipients.length > 0);
        require(recipients.length == amounts.length);
        
        uint256 length = recipients.length;
        uint256 currentSum = 0;
        uint256 currentEthBalance = address(this).balance;
        
        for (uint256 i = 0; i < length; i++) {
            uint256 amount = amounts[i];
            require(amount > 0);
            currentSum = currentSum.add(amount);
            require(currentSum <= currentEthBalance);
           
            recipients[i].transfer(amount);
        }
    }    
}