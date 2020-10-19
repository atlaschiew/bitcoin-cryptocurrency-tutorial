pragma solidity ^0.4.17;

contract MultiSendEth {
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
    function getBalance() public view returns (uint256) {
        return address(this).balance;
    }
    
    //withdraw whole balance
    function withdraw() public onlyOwner{
        msg.sender.transfer(address(this).balance);
    }

    function multiSendArrayAmount(address[] addresses, uint256[] amounts) public payable {
        require(addresses.length > 0);
        require(addresses.length == amounts.length);

        uint256 length = addresses.length;
        uint256 currentSum = 0;
        for (uint256 i = 0; i < length; i++) {
            uint256 amount = amounts[i];
            require(amount > 0);
            currentSum += amount;
            require(currentSum <= msg.value);
           
            addresses[i].transfer(amount);
        }
        require(currentSum == msg.value);
    }
    
    function multiSendFixedAmount(address[] addresses, uint256 amount) public payable {
        
        require(addresses.length > 0);
        require(amount > 0);
        require(addresses.length * amount == msg.value);
        
        uint256 length = addresses.length;
        
        for(uint256 i=0;i<length;i++) {
            addresses[i].transfer(amount);
        }
    }   
    
    function multiSendFixedAmountFromContract(address[] addresses, uint256 amount) public onlyOwner {
        
        require(addresses.length > 0);
        require(amount > 0);
        
        uint256 length = addresses.length;
        
        for(uint256 i=0;i<length;i++) {
            addresses[i].transfer(amount);
        }
    }    
}