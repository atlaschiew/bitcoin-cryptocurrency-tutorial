package main

import (
	"github.com/ethereum/go-ethereum/common"
)

func isValidAddress(address string) (map[string]string,  error) {
	
	response := make(map[string]string)
	addressObj, thisError := common.NewMixedcaseAddressFromString(address);
	response["checkSum"] = "na"
	if thisError == nil {
		if addressObj.ValidChecksum() {
			response["checkSum"] = "valid"
		} else {
			response["checkSum"] = "invalid"
		}
	}
	
	return response, thisError
}