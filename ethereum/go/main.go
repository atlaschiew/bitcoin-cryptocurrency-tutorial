package main

import (
	"github.com/gin-gonic/gin"
	"fmt"
	
	str "strings"
	err "errors"
)

func main() {

    router := gin.Default()
	router.LoadHTMLGlob("templates/*.html")
	
	router.POST("/ethereum/:name", func(ctx *gin.Context) {
		response := map[string]string{}
		name := ctx.Param("name")
		
		var pageError, submitError error 
		
		if !str.HasSuffix(name, ".go") {
			pageError = err.New("File not found");
		}
		
		htmlFile := str.Replace(name, ".go", "", -1)
		htmlFile  = str.Join([]string{htmlFile, "html"},".")
		
		switch name {
			case "eth_address_form.go":
				privateKeyHex := ctx.PostForm("input")
				retResponse, retError := generateKeyAndAddress(privateKeyHex)
				
				submitError = retError
				response = retResponse
				
			case "eth_address_validator.go":
				address := ctx.PostForm("address")
				retResponse, retError := isValidAddress(address)
				
				submitError = retError
				response = retResponse
			case "eth_contract_address_form.go":
				address := ctx.PostForm("address")
				nonce := ctx.PostForm("nonce")
				retResponse, retError := genContractAddress(address, nonce)
				
				submitError = retError
				response = retResponse
			case "eth_rlp_encoder.go":
				str := ctx.PostForm("string")
				
				retResponse, retError := rlpEncode(str)
				
				submitError = retError
				response = retResponse
				
			case "eth_tx_form.go":
			
				chainId  := ctx.PostForm("chain")
				nonce    := ctx.PostForm("nonce")
				value    := ctx.PostForm("value")
				gasLimit := ctx.PostForm("gas_limit")
				to       := ctx.PostForm("to")
				data     := ctx.PostForm("data")
				gasPrice := ctx.PostForm("gas_price") 
				privKey  := ctx.PostForm("privkey")
			
				retResponse, retError := genSignedTx(chainId, nonce, value, gasLimit, to, data, gasPrice, privKey)
				
				submitError = retError
				response = retResponse
			
			case "eth_tx_nonce.go":
				url := ctx.PostForm("host") + "/" + ctx.PostForm("path")
				
				address := ctx.PostForm("address")
				blockParam := ctx.PostForm("blockparam")
				retResponse, retError := getNonceTx(url, address, blockParam)
				
				submitError = retError
				response = retResponse
			case "eth_json_rpc.go":
				url := ctx.PostForm("host") + "/" + ctx.PostForm("path")
				method := ctx.PostForm("method")
				jsonver := ctx.PostForm("jsonver")
				params := ctx.PostForm("params")
				
				retResponse, retError := callJsonRpc(url, jsonver, method, params)
				
				submitError = retError
				response = retResponse
			default:
				pageError = err.New("File not found");
		}
		
		var responseCode int = 200
		
		if pageError != nil {
		    responseCode = 404
		}
		
		htmlVars := gin.H{}
		
		if(submitError != nil) {
			htmlVars["error"] = submitError
		}
		
		for k,v := range response {
			htmlVars[k] = v
		}
		
		for pk, pv := range ctx.Request.PostForm {
			htmlVars[pk] = pv[0]
		}
		
		htmlVars["chains"] = getChains()
		htmlVars["hosts"] = getHosts()
		htmlVars["blockParams"] = getBlockParams()
		ctx.HTML(responseCode, htmlFile, htmlVars)
    })
	
	router.GET("/ethereum/:name", func(ctx *gin.Context) {
		fmt.Print("")

		name := ctx.Param("name")
		
		var thisError error 
		
		if !str.HasSuffix(name, ".go") {
			thisError = err.New("File not found");
		}
		
		htmlFile := str.Replace(name, ".go", "", -1)
		htmlFile  = str.Join([]string{htmlFile, "html"},".")
		
		var responseCode int = 200
		
		if thisError != nil {
		    responseCode = 404
		}
		
		htmlVars := gin.H{}
		htmlVars["chains"] = getChains()
		htmlVars["hosts"] = getHosts()
		htmlVars["blockParams"] = getBlockParams()
		ctx.HTML(responseCode, htmlFile, htmlVars)
	})
	
	//due to port 80 & 443 conflict with apache, i have to enable new port 2053 to support cloudflare's https
	router.RunTLS(":2053", "../../../cert/server.crt", "../../../cert/server.key")
	
	//alternatively, you may consider to simply turn on 80 port like this to use HTTP
	//router.Run(":80")
}