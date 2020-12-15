pragma solidity ^0.5.0;

import "https://github.com/OpenZeppelin/openzeppelin-contracts/blob/v2.4.0/contracts/token/ERC20/IERC20.sol";
import "https://github.com/OpenZeppelin/openzeppelin-contracts/blob/v2.4.0/contracts/token/ERC20/SafeERC20.sol";

contract BatchSendERC20 {
    using SafeMath for uint256;
    using SafeERC20 for IERC20;
    
    address public owner;
    
    modifier onlyOwner(){
        require(msg.sender == owner);
        _;
    }
    
    constructor() public{
        owner = msg.sender;
    }
   
    //getowner
    function getOwner() public view returns (address) {
        return owner;
    }
    
    //get token balance
    function getTokenBalance(IERC20 token) public view returns (uint256) {
        return token.balanceOf(address(this));
    }
    
    //withdraw whole erc20 token balance
    function withdraw(IERC20 token) public onlyOwner{
        token.safeTransfer(msg.sender, token.balanceOf(address(this)));
    }
    
    function multiSendFixedAmount(IERC20 token, address[] memory recipients, uint256 values) public onlyOwner {
        for (uint256 i = 0; i < recipients.length; i++) {
           token.safeTransfer(recipients[i], values);
        }
    }
    
    function multiSendArrayAmount(IERC20 token, address[] memory recipients, uint256[] memory values) public onlyOwner {
        for (uint256 i = 0; i < recipients.length; i++) {
           token.safeTransfer(recipients[i], values[i]);
        }
    }
    
}