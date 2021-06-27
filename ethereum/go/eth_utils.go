package main

import(
	"github.com/ethereum/go-ethereum/params"
	"math/big"
	"math"
	"strings"
)

const (
	Wei  int= 0
	Kwei int= 3
	Ada
	Femtoether
	Mwei int= 6
	Babbage
	Picoether
	Gwei int= 9
	Shannon
	Nanoether
	Nano
	Microether int= 12
	Micro
	Szabo
	Milliether int= 15
	Milli
	Finney
	Ether  int= 18
	Kether int= 21
	Grand
	Einstein
	Mether int= 24
	Gether int= 27
	Tether int= 30
)

var chainsConfig map[string]*params.ChainConfig

func getChainsConfig() map[string]*params.ChainConfig {
	chainsConfig = map[string]*params.ChainConfig{}
	chainsConfig["1"] = params.MainnetChainConfig
	chainsConfig["3"] = params.RopstenChainConfig
	
	return chainsConfig
}

func getChains() map[string]string {
	var chains = make(map[string]string)
	chains["1"] = "Ethereum Mainnet"
	chains["3"] = "Ethereum Testnet Ropsten"
	
	return chains
}

func getHosts() map[string]string {
	var hosts = make(map[string]string)
	
	hosts["https://mainnet.infura.io"] = "https://mainnet.infura.io"
	hosts["https://ropsten.infura.io"] = "https://ropsten.infura.io"
	hosts["https://cloudflare-eth.com"] = "https://cloudflare-eth.com"
	
	return hosts
}

func getBlockParams() map[string]string {
	var blockParams = make(map[string]string)
	
	blockParams["pending"] = "Pending"
	blockParams["earliest"] = "Earliest"
	blockParams["latest"] = "Latest"
	
	
	return blockParams
}

func EthToWei(eth string) string {
	return Convert(eth, Ether, Wei).FloatString(Wei)
}

func GweiToWei(gwei string) string {
	wei := Convert(gwei, Gwei, Wei).FloatString(Gwei)
	wei = strings.TrimRight(wei, "0")
	wei = strings.TrimRight(wei, ".")
	
	return wei
}

func WeiToEth(wei string) string {
	eth := Convert(wei, Wei, Ether).FloatString(Ether)
	eth = strings.TrimRight(eth, "0")
	eth = strings.TrimRight(eth, ".")
	
	return eth
}

func Convert(w string, from int, to int) *big.Rat {
	v, ok := new(big.Rat).SetString(w)
	if !ok {
		return nil
	}

	fromUnit := new(big.Int).SetInt64(int64(math.Pow10(int(from))))
	toUnit := new(big.Int).SetInt64(int64(math.Pow10(int(to))))

	return v.Mul(v, new(big.Rat).SetFrac(fromUnit, toUnit))
}