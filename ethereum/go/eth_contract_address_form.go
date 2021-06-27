package main

import(
	"github.com/ethereum/go-ethereum/rlp"
	"strconv"
	"github.com/ethereum/go-ethereum/common"
	"github.com/ethereum/go-ethereum/common/hexutil"
	"github.com/ethereum/go-ethereum/crypto"
)

func genContractAddress(addressHex string, nonceStr string) (map[string]string, error) {
	var thisError error 
	
	response := make(map[string]string)
	
	if nonce, err1 := strconv.ParseUint(nonceStr, 10, 64 /*uint64*/); err1 == nil {
		address := common.HexToAddress(addressHex)
	
		if rlpBytes, err2 := rlp.EncodeToBytes([]interface{}{address, nonce}); err2 == nil {
			hashBytes := crypto.Keccak256Hash(rlpBytes)
			response["ethAddress"] = hexutil.Encode(hashBytes[12:])
			
		} else {
			thisError = err2
		}
	} else {
		thisError = err1
	}
	 
	return response, thisError
}