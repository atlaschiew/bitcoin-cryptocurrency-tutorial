package main

import (
	"errors"
	"github.com/ethereum/go-ethereum/crypto"
	"github.com/ethereum/go-ethereum/common/hexutil"
	"github.com/ethereum/go-ethereum/crypto/secp256k1"
	"crypto/ecdsa"
	"math/big"
)

func generateKeyAndAddress(privateKeyHex string) (map[string]string,  error) {
	var thisError error 
	response := make(map[string]string)
	var privateKey *ecdsa.PrivateKey
	
	
	if len(privateKeyHex) == 0 {
		
		if retPrivateKey, retError := crypto.GenerateKey(); retError != nil {
			thisError = errors.New("Key generation fail")
		} else {
			privateKey = retPrivateKey
		}
	} else {
		var pri ecdsa.PrivateKey
		var retBool bool
		if pri.D, retBool = new(big.Int).SetString(privateKeyHex,16); retBool == true {
			
			pri.PublicKey.Curve = secp256k1.S256()
			pri.PublicKey.X, pri.PublicKey.Y = pri.PublicKey.Curve.ScalarBaseMult(pri.D.Bytes())
			
			privateKey = &pri
		} else {
			thisError = errors.New("Hex input not valid")
		}
	}
	
	if (thisError == nil) {
		privateKeyBytes := crypto.FromECDSA(privateKey)	
		publicKey := privateKey.Public()
		
		if publicKeyECDSA, isPublicKeyType := publicKey.(*ecdsa.PublicKey); isPublicKeyType == true {
			
			address := crypto.PubkeyToAddress(*publicKeyECDSA).Hex()
			
			publicKeyBytes := crypto.FromECDSAPub(publicKeyECDSA)
			
			response["publicKey"] = hexutil.Encode(publicKeyBytes)[4:]
			response["privateKey"] = hexutil.Encode(privateKeyBytes)[2:]
			response["address"] = address
		} else {
			thisError = errors.New("Public key generation fail");
		}
	}
	
	return response, thisError
}
