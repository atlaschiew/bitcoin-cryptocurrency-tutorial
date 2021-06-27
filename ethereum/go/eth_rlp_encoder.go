package main

import(
	_ "fmt"
	"github.com/ethereum/go-ethereum/rlp"
	"github.com/ethereum/go-ethereum/common/hexutil"
	"encoding/json"
	"strings"
	"math"
)

func rlpEncode(dataJson string) (map[string]string, error) {
	
	response := make(map[string]string)
	
	var thisError error	
	var arrJson []interface{}
	var rlpBytes []byte = []byte{}
	
	if thisError = json.Unmarshal([]byte(dataJson),&arrJson); thisError == nil {
		
		for k, v := range arrJson {
			
			switch v.(type) {
				case string:
					
					if strings.HasPrefix(v.(string), "0x") {
						arrJson[k], _ = hexutil.Decode(v.(string))
					}
				case float64:
					if (v.(float64) / math.Round(v.(float64))) == 1 {
						//convert if it is an integer
						arrJson[k] = uint64(arrJson[k].(float64))
					} 
				default:
				
			}
		}
		
		if rlpBytes, thisError = rlp.EncodeToBytes(arrJson); thisError==nil {
			response["rlpHex"] = hexutil.Encode(rlpBytes)
		}
		
	} 
	
	return response,thisError
}
