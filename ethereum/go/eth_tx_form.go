package main

import(
	"github.com/ethereum/go-ethereum/crypto"
	"github.com/ethereum/go-ethereum/common"
	"github.com/ethereum/go-ethereum/core/types"
	"math/big"
	"strconv"
	"encoding/hex"	
	"strings"
)

func genSignedTx(chainIdStr string, nonceStr string, valueStr string, gasLimitStr string, toStr string, dataStr string, gasPriceStr string, privKeyStr string) (map[string]string, error) {
	
	var thisError error 
	response := make(map[string]string)
	
	chainId     := chainIdStr
	privKey, _  := crypto.HexToECDSA(privKeyStr)
	to          := common.HexToAddress(toStr)
	nonce, _    := strconv.ParseUint(nonceStr, 10, 64)
	gasLimit, _ := strconv.ParseUint(gasLimitStr,10,64)
	
	
	value, _    := new(big.Int).SetString(EthToWei(valueStr),10)
	gasPrice, _ := new(big.Int).SetString(GweiToWei(gasPriceStr),10)
	signer      := types.LatestSigner( getChainsConfig()[chainId] )
	data, _     := hex.DecodeString(strings.TrimPrefix(dataStr, "0x"))

	tx := types.NewTransaction(uint64(nonce), to, value, gasLimit, gasPrice, data)
	signedTx, _ := types.SignTx(tx, signer, privKey)
	
	rawTx, _ := signedTx.MarshalBinary()
	
	response["hash"] = signedTx.Hash().Hex()
	response["rawTx"] = hex.EncodeToString(rawTx)
	
	return response, thisError
}