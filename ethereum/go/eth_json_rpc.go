package main

import(
    _ "fmt"
	"net/http"
	"bytes"
	"io"
	"encoding/json"	
)

func callJsonRpc(urlStr string, jsonRpcVerStr string, methodStr string, paramsStr string) (map[string]string,error) {
	
	var err error
	response := make(map[string]string)

	reqBody := bytes.NewBufferString(
        `{"jsonrpc":"2.0","id":1,"method":"`+methodStr+`","params":`+paramsStr+`}`)
	response["req"] = reqBody.String()
	
	req, err := http.NewRequest(http.MethodPost, urlStr, reqBody)
	
	if err!=nil {
		return response, err
	}
	req.Header.Set("User-Agent", "btcschools.net(Go)")
	req.Header.Set("Content-Type", "application/json; charset=utf-8")
	
	c := http.Client{}
	
	res, err := c.Do(req)
	
	if err!=nil {
		return response,err
	}
	defer res.Body.Close()
	
	var content bytes.Buffer
	_, err = io.Copy(&content, res.Body)
	
	if err!=nil {
		return response,err
	}
	
	var jsonResp map[string]interface{}
	if err = json.Unmarshal(content.Bytes(), &jsonResp); err != nil {
		return response,err
	}
	//access result by jsonResp["result"]
	
	response["url"] = urlStr
	response["resp"] = string(content.Bytes())
	
	return response, nil
}
