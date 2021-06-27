package main

import(
	"fmt"
	"github.com/ethereum/go-ethereum/ethclient"	
	"github.com/ethereum/go-ethereum/common"
	"context"
	"strings"
	"math/big"
)

func getNonceTx(urlStr string, addressStr string, blockParamStr string) (map[string]string, error) {
	
	response := make(map[string]string)
	
	address := common.HexToAddress(strings.TrimPrefix(addressStr, "0x"))
	
	client,err := ethclient.Dial(urlStr)

	if err!=nil {
		return response, err
	}
	
	var blockParam *big.Int
	switch blockParamStr {
		case "pending":
			blockParam = big.NewInt(-1)
		case "earliest":
			blockParam = big.NewInt(0)
	}

	resp , err := client.NonceAt(context.Background(), address, blockParam)

	if err!=nil {
		return response, err
	}
	
	response["url"] = urlStr
	response["nonce"] = fmt.Sprintf("%d", resp)
	
	return response, nil
}
